<?php

if (!function_exists('getImagePath')) {
    /**
     * Returns the full URL for an image stored in storage/app/public.
     * Uses a fallback image if the given path is null or empty.
     *
     * @param string|null $path Path to the image in storage
     * @param string|null $fallback Optional fallback image path
     * @return string Full URL to the image
     */
    function getImagePath(?string $path, ?string $fallback = null): string
    {
        // Use fallback if path is null or empty
        if (empty($path)) {
            return $fallback ?? asset('/storage/app/public/default-profile1.png');
        }

        // Ensure path starts with storage prefix
        $path = strpos($path, '/storage/app/public/') === false
            ? '/storage/app/public/' . ltrim($path, '/')
            : $path;

        return asset($path);
    }
}
