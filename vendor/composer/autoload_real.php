<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInite9ed97e5a1cbe4ad0f748d5d0f9a3f7d
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

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInite9ed97e5a1cbe4ad0f748d5d0f9a3f7d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInite9ed97e5a1cbe4ad0f748d5d0f9a3f7d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInite9ed97e5a1cbe4ad0f748d5d0f9a3f7d::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInite9ed97e5a1cbe4ad0f748d5d0f9a3f7d::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequiree9ed97e5a1cbe4ad0f748d5d0f9a3f7d($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequiree9ed97e5a1cbe4ad0f748d5d0f9a3f7d($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}