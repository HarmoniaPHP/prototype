<?php

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}


if (!function_exists('asset')) {
    function asset($path): string
    {
        return '/' . ltrim(str_replace(BASE_PATH, '', $path), '/');
    }
}
