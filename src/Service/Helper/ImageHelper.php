<?php

declare(strict_types=1);

namespace App\Service\Helper;

class ImageHelper
{
    public const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'webp'];

    public function getImageExtensions(): array
    {
        return self::IMAGE_EXTENSIONS;
    }

    public static function getImageExtensionsAssocArray(): array
    {
        $result = [];
        foreach (self::IMAGE_EXTENSIONS as $extension) {
            $result[] = [strtoupper($extension) => $extension];
        }
        return $result;
    }
}
