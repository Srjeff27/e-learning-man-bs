<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CacheControlMiddleware
{
    /**
     * Cache durations in seconds (1 year = 31536000)
     */
    protected int $staticCacheDuration = 31536000;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Get the path
        $path = $request->path();

        // Check if it's a static asset request
        if ($this->isStaticAsset($path)) {
            $this->setCacheHeaders($response, $this->staticCacheDuration);
        }
        // For storage files (images uploaded by users)
        elseif (str_starts_with($path, 'storage/')) {
            $this->setCacheHeaders($response, $this->staticCacheDuration);
        }
        // For build assets (Vite compiled files)
        elseif (str_starts_with($path, 'build/')) {
            $this->setCacheHeaders($response, $this->staticCacheDuration);
        }

        return $response;
    }

    /**
     * Check if the path is a static asset
     */
    protected function isStaticAsset(string $path): bool
    {
        $staticExtensions = [
            'css',
            'js',
            'mjs',
            'webp',
            'jpg',
            'jpeg',
            'png',
            'gif',
            'ico',
            'svg',
            'avif',
            'woff',
            'woff2',
            'ttf',
            'otf',
            'eot',
            'mp4',
            'webm',
            'mp3',
            'wav',
            'pdf',
            'zip'
        ];

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, $staticExtensions);
    }

    /**
     * Set cache headers on response
     */
    protected function setCacheHeaders(Response $response, int $maxAge): void
    {
        // Skip if response is an error
        if ($response->getStatusCode() >= 400) {
            return;
        }

        $response->headers->set('Cache-Control', "public, max-age={$maxAge}, immutable");
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
        $response->headers->set('Pragma', 'cache');
        $response->headers->set('Vary', 'Accept-Encoding');
    }
}
