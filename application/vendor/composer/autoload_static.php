<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita86e60878d831a410867cd523e81810c
{
    public static $classMap = array (
        'Gumlet\\ImageResize' => __DIR__ . '/..' . '/gumlet/php-image-resize/lib/ImageResize.php',
        'Gumlet\\ImageResizeException' => __DIR__ . '/..' . '/gumlet/php-image-resize/lib/ImageResize.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInita86e60878d831a410867cd523e81810c::$classMap;

        }, null, ClassLoader::class);
    }
}
