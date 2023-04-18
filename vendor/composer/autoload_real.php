<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitcc3c2f205e53d2d871f4c1376cf4778c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitcc3c2f205e53d2d871f4c1376cf4778c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitcc3c2f205e53d2d871f4c1376cf4778c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitcc3c2f205e53d2d871f4c1376cf4778c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}