<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControlMiddleware
{
    /**
     * Cache durations in seconds
     */
    protected array $cacheDurations = [
        'images' => 31536000, // 1 year
        'css' => 31536000,    // 1 year
        'js' => 31536000,     // 1 year
        'fonts' => 31536000,  // 1 year
    ];

    /**
     * File extensions for each type
     */
    protected array $fileTypes = [
        'images' => ['webp', 'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'avif'],
        'css' => ['css'],
        'js' => ['js'],
        'fonts' => ['woff', 'woff2', 'ttf', 'otf', 'eot'],
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip if not a static file request
        if (!$this->isStaticFile($request)) {
            return $response;
        }

        $extension = strtolower(pathinfo($request->path(), PATHINFO_EXTENSION));
        $cacheType = $this->getCacheType($extension);

        if ($cacheType) {
            $maxAge = $this->cacheDurations[$cacheType];

            $response->headers->set('Cache-Control', "public, max-age={$maxAge}, immutable");
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');

            // Add Vary header for proper caching
            $response->headers->set('Vary', 'Accept-Encoding');
        }

        return $response;
    }

    /**
     * Check if request is for a static file
     */
    protected function isStaticFile(Request $request): bool
    {
        $path = $request->path();
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        foreach ($this->fileTypes as $extensions) {
            if (in_array($extension, $extensions)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get cache type for extension
     */
    protected function getCacheType(string $extension): ?string
    {
        foreach ($this->fileTypes as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                return $type;
            }
        }

        return null;
    }
}
