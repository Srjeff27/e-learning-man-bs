<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizationService
{
    /**
     * Default quality for WebP conversion (0-100)
     */
    protected int $quality = 80;

    /**
     * Maximum width for resizing (null = no resize)
     */
    protected ?int $maxWidth = 1920;

    /**
     * Maximum height for resizing (null = no resize)
     */
    protected ?int $maxHeight = 1080;

    /**
     * Set quality for WebP conversion
     */
    public function setQuality(int $quality): self
    {
        $this->quality = max(1, min(100, $quality));
        return $this;
    }

    /**
     * Set maximum dimensions for resizing
     */
    public function setMaxDimensions(?int $width = null, ?int $height = null): self
    {
        $this->maxWidth = $width;
        $this->maxHeight = $height;
        return $this;
    }

    /**
     * Convert and optimize an uploaded image to WebP format
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory Storage directory (e.g., 'news', 'galleries')
     * @param string $disk Storage disk (default: 'public')
     * @return string|null The path to the stored WebP file, or null on failure
     */
    public function optimizeAndStore(UploadedFile $file, string $directory, string $disk = 'public'): ?string
    {
        try {
            // Check if file is an image
            if (!$this->isImage($file)) {
                // Not an image, store as-is
                return $file->store($directory, $disk);
            }

            // Get image info
            $mimeType = $file->getMimeType();
            $tempPath = $file->getRealPath();

            // Create image resource based on mime type
            $image = $this->createImageFromFile($tempPath, $mimeType);

            if (!$image) {
                // Fallback to regular storage if can't process
                return $file->store($directory, $disk);
            }

            // Resize if needed
            $image = $this->resizeImage($image);

            // Generate unique filename with .webp extension
            $filename = $this->generateFilename($file, 'webp');
            $storagePath = $directory . '/' . $filename;

            // Create WebP in memory
            ob_start();
            imagewebp($image, null, $this->quality);
            $webpData = ob_get_clean();

            // Free memory
            imagedestroy($image);

            // Store the WebP file
            Storage::disk($disk)->put($storagePath, $webpData);

            return $storagePath;

        } catch (\Exception $e) {
            \Log::error('Image optimization failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
            ]);

            // Fallback to regular storage
            return $file->store($directory, $disk);
        }
    }

    /**
     * Convert and optimize an uploaded image to responsive WebP formats (desktop + mobile)
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory Storage directory (e.g., 'news', 'galleries')
     * @param string $disk Storage disk (default: 'public')
     * @return array{desktop: string|null, mobile: string|null} Paths to desktop and mobile images
     */
    public function optimizeAndStoreResponsive(UploadedFile $file, string $directory, string $disk = 'public'): array
    {
        $result = [
            'desktop' => null,
            'mobile' => null,
        ];

        try {
            // Check if file is an image
            if (!$this->isImage($file)) {
                // Not an image, store as-is (only desktop)
                $result['desktop'] = $file->store($directory, $disk);
                return $result;
            }

            // Get image info
            $mimeType = $file->getMimeType();
            $tempPath = $file->getRealPath();

            // Create image resource based on mime type
            $originalImage = $this->createImageFromFile($tempPath, $mimeType);

            if (!$originalImage) {
                // Fallback to regular storage
                $result['desktop'] = $file->store($directory, $disk);
                return $result;
            }

            // Generate base filename
            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $baseName = Str::slug($baseName);
            $timestamp = now()->format('Ymd_His');
            $random = Str::random(6);

            // ========== DESKTOP VERSION (1920px, quality 85%) ==========
            $desktopImage = $this->createImageFromFile($tempPath, $mimeType);
            $desktopImage = $this->resizeImageToMaxWidth($desktopImage, 1920);

            $desktopFilename = "{$baseName}_{$timestamp}_{$random}_desktop.webp";
            $desktopPath = $directory . '/' . $desktopFilename;

            ob_start();
            imagewebp($desktopImage, null, 85);
            $desktopData = ob_get_clean();
            imagedestroy($desktopImage);

            Storage::disk($disk)->put($desktopPath, $desktopData);
            $result['desktop'] = $desktopPath;

            // ========== MOBILE VERSION (768px, quality 75%) ==========
            $mobileImage = $this->createImageFromFile($tempPath, $mimeType);
            $mobileImage = $this->resizeImageToMaxWidth($mobileImage, 768);

            $mobileFilename = "{$baseName}_{$timestamp}_{$random}_mobile.webp";
            $mobilePath = $directory . '/' . $mobileFilename;

            ob_start();
            imagewebp($mobileImage, null, 75);
            $mobileData = ob_get_clean();
            imagedestroy($mobileImage);

            Storage::disk($disk)->put($mobilePath, $mobileData);
            $result['mobile'] = $mobilePath;

            // Free original image memory
            imagedestroy($originalImage);

            \Log::info('Responsive images created', [
                'desktop' => $desktopPath,
                'mobile' => $mobilePath,
                'desktop_size' => strlen($desktopData),
                'mobile_size' => strlen($mobileData),
            ]);

            return $result;

        } catch (\Exception $e) {
            \Log::error('Responsive image optimization failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
            ]);

            // Fallback to regular storage
            $result['desktop'] = $file->store($directory, $disk);
            return $result;
        }
    }

    /**
     * Resize image to maximum width while maintaining aspect ratio
     */
    protected function resizeImageToMaxWidth($image, int $maxWidth)
    {
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // No resize needed if already smaller
        if ($originalWidth <= $maxWidth) {
            return $image;
        }

        $ratio = $maxWidth / $originalWidth;
        $newWidth = $maxWidth;
        $newHeight = (int) ($originalHeight * $ratio);

        // Create new image with new dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
        imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);

        // Resize
        imagecopyresampled(
            $newImage,
            $image,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $originalWidth,
            $originalHeight
        );

        // Free original image memory
        imagedestroy($image);

        return $newImage;
    }


    /**
     * Check if file is an image
     */
    protected function isImage(UploadedFile $file): bool
    {
        $mimeType = $file->getMimeType();
        return in_array($mimeType, [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
        ]);
    }

    /**
     * Create GD image resource from file
     */
    protected function createImageFromFile(string $path, string $mimeType)
    {
        switch ($mimeType) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                $image = imagecreatefrompng($path);
                // Preserve transparency
                imagealphablending($image, true);
                imagesavealpha($image, true);
                return $image;
            case 'image/gif':
                return imagecreatefromgif($path);
            case 'image/webp':
                return imagecreatefromwebp($path);
            case 'image/bmp':
                return imagecreatefrombmp($path);
            default:
                return null;
        }
    }

    /**
     * Resize image if exceeds max dimensions while maintaining aspect ratio
     */
    protected function resizeImage($image)
    {
        if (!$this->maxWidth && !$this->maxHeight) {
            return $image;
        }

        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        $newWidth = $originalWidth;
        $newHeight = $originalHeight;

        // Calculate new dimensions
        if ($this->maxWidth && $originalWidth > $this->maxWidth) {
            $ratio = $this->maxWidth / $originalWidth;
            $newWidth = $this->maxWidth;
            $newHeight = (int) ($originalHeight * $ratio);
        }

        if ($this->maxHeight && $newHeight > $this->maxHeight) {
            $ratio = $this->maxHeight / $newHeight;
            $newHeight = $this->maxHeight;
            $newWidth = (int) ($newWidth * $ratio);
        }

        // No resize needed
        if ($newWidth === $originalWidth && $newHeight === $originalHeight) {
            return $image;
        }

        // Create new image with new dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
        imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);

        // Resize
        imagecopyresampled(
            $newImage,
            $image,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $originalWidth,
            $originalHeight
        );

        // Free original image memory
        imagedestroy($image);

        return $newImage;
    }

    /**
     * Generate unique filename
     */
    protected function generateFilename(UploadedFile $file, string $extension): string
    {
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $baseName = Str::slug($baseName);
        $timestamp = now()->format('Ymd_His');
        $random = Str::random(6);

        return "{$baseName}_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Create thumbnail from an image
     *
     * @param string $sourcePath Path to source image in storage
     * @param string $directory Directory to store thumbnail
     * @param int $width Thumbnail width
     * @param int $height Thumbnail height
     * @param string $disk Storage disk
     * @return string|null Path to thumbnail
     */
    public function createThumbnail(
        string $sourcePath,
        string $directory,
        int $width = 300,
        int $height = 200,
        string $disk = 'public'
    ): ?string {
        try {
            $fullPath = Storage::disk($disk)->path($sourcePath);

            if (!file_exists($fullPath)) {
                return null;
            }

            $mimeType = mime_content_type($fullPath);
            $image = $this->createImageFromFile($fullPath, $mimeType);

            if (!$image) {
                return null;
            }

            // Calculate crop dimensions to maintain aspect ratio
            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);

            $sourceRatio = $originalWidth / $originalHeight;
            $targetRatio = $width / $height;

            if ($sourceRatio > $targetRatio) {
                // Original is wider - crop width
                $cropHeight = $originalHeight;
                $cropWidth = (int) ($originalHeight * $targetRatio);
                $cropX = (int) (($originalWidth - $cropWidth) / 2);
                $cropY = 0;
            } else {
                // Original is taller - crop height
                $cropWidth = $originalWidth;
                $cropHeight = (int) ($originalWidth / $targetRatio);
                $cropX = 0;
                $cropY = (int) (($originalHeight - $cropHeight) / 2);
            }

            // Create thumbnail
            $thumbnail = imagecreatetruecolor($width, $height);
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);

            imagecopyresampled(
                $thumbnail,
                $image,
                0,
                0,
                $cropX,
                $cropY,
                $width,
                $height,
                $cropWidth,
                $cropHeight
            );

            // Generate filename
            $baseName = pathinfo($sourcePath, PATHINFO_FILENAME);
            $filename = "{$baseName}_thumb_{$width}x{$height}.webp";
            $storagePath = $directory . '/' . $filename;

            // Save as WebP
            ob_start();
            imagewebp($thumbnail, null, $this->quality);
            $webpData = ob_get_clean();

            imagedestroy($image);
            imagedestroy($thumbnail);

            Storage::disk($disk)->put($storagePath, $webpData);

            return $storagePath;

        } catch (\Exception $e) {
            \Log::error('Thumbnail creation failed', [
                'error' => $e->getMessage(),
                'source' => $sourcePath,
            ]);
            return null;
        }
    }
}
