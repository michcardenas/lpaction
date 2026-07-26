<?php

use App\Support\Cms;

if (! function_exists('cms')) {
    /** Texto editable de la landing (override o valor por defecto). */
    function cms(string $key, ?string $default = null): string
    {
        return Cms::text($key, $default);
    }
}

if (! function_exists('cms_img')) {
    /** URL de imagen editable de la landing (override subido o imagen por defecto). */
    function cms_img(string $key, ?string $default = null): string
    {
        return Cms::img($key, $default);
    }
}
