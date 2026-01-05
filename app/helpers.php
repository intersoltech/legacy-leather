<?php

if (!function_exists('image_url')) {
    /**
     * Get the correct URL for an image path.
     * Handles storage paths, asset paths, and full URLs.
     *
     * @param string|null $path
     * @param string|null $fallback
     * @return string
     */
    function image_url(?string $path, ?string $fallback = null): string
    {
        if (empty($path)) {
            return $fallback ? asset($fallback) : asset('assets/img/placeholder.jpg');
        }

        // Full URL (http:// or https://)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Absolute path starting with /
        if (str_starts_with($path, '/')) {
            return $path;
        }

        // Storage path (uploads/...)
        if (str_starts_with($path, 'uploads/')) {
            return asset('storage/' . $path);
        }

        // Already has storage/ prefix
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // Default: treat as asset path
        return asset($path);
    }
}

