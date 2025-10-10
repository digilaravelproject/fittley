<?php

if (!function_exists('getImagePath')) {
    function getImagePath($path, $fallback = null)
    {
        if (!$path) {
            return $fallback ?? asset('images/fallback.jpg');
        }

        if (strpos($path, '/storage/app/public/') === false) {
            $path = '/storage/app/public/' . ltrim($path, '/');
        }

        return asset($path);
    }
}
