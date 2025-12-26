<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $galleries = Gallery::with('uploader')->latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:photo,video',
            'category' => 'nullable|string|max:50',
            'file' => 'required|file|max:10240', // 10MB max
            'is_featured' => 'boolean',
        ]);

        $validated['uploaded_by'] = auth()->id();
        $validated['is_featured'] = $request->has('is_featured');

        // Handle file upload with WebP conversion for photos
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if ($validated['type'] === 'photo' && $this->isImage($file)) {
                // Convert to WebP (desktop + mobile versions)
                $images = $this->imageService->optimizeAndStoreResponsive($file, 'galleries');
                $validated['file_path'] = $images['desktop'];
                $validated['file_path_mobile'] = $images['mobile'];

                // Create thumbnail from desktop version
                $validated['thumbnail'] = $this->imageService
                    ->setQuality(80)
                    ->createThumbnail($validated['file_path'], 'galleries/thumbnails', 400, 300);

                // If thumbnail creation failed, use mobile version as fallback
                if (!$validated['thumbnail']) {
                    $validated['thumbnail'] = $validated['file_path_mobile'] ?? $validated['file_path'];
                }
            } else {
                // Store video or non-image files as-is
                $validated['file_path'] = $file->store('galleries', 'public');
            }
        }

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:50',
            'file' => 'nullable|file|max:10240',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Delete old files (desktop, mobile, thumbnail)
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            if ($gallery->file_path_mobile) {
                Storage::disk('public')->delete($gallery->file_path_mobile);
            }
            if ($gallery->thumbnail && $gallery->thumbnail !== $gallery->file_path) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }

            if ($gallery->type === 'photo' && $this->isImage($file)) {
                // Convert to WebP (desktop + mobile versions)
                $images = $this->imageService->optimizeAndStoreResponsive($file, 'galleries');
                $validated['file_path'] = $images['desktop'];
                $validated['file_path_mobile'] = $images['mobile'];

                // Create thumbnail from desktop version
                $validated['thumbnail'] = $this->imageService
                    ->setQuality(80)
                    ->createThumbnail($validated['file_path'], 'galleries/thumbnails', 400, 300);

                // If thumbnail creation failed, use mobile version as fallback
                if (!$validated['thumbnail']) {
                    $validated['thumbnail'] = $validated['file_path_mobile'] ?? $validated['file_path'];
                }
            } else {
                $validated['file_path'] = $file->store('galleries', 'public');
            }
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete files (desktop, mobile, thumbnail)
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }
        if ($gallery->file_path_mobile) {
            Storage::disk('public')->delete($gallery->file_path_mobile);
        }
        if ($gallery->thumbnail && $gallery->thumbnail !== $gallery->file_path) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil dihapus.');
    }

    /**
     * Check if file is an image
     */
    protected function isImage($file): bool
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
}
