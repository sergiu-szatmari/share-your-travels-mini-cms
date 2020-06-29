<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class ClassLoader
{
    private static $utilClasses = [
        'Constants',
    ];

    private static $interfaces = [
        'iModel',
        'iPage'
    ];

    private static $abstractClasses = [
        'aModel',
        'aDispatcher',
        'aPage',
    ];

    private static $models = [
        'BlogPost',
    ];

    private static $classes = [
        'Environment',
        'Security',
        'Database',
        'Dispatcher',
        'AdminDispatcher',
    ];

    private static $pages = [
        'BadRequest400',
        'NotFound404',
        'InternalServerError500',

        'Home',
        'About',
        'Blog',

        'Login',
    ];

    private static function loadUtils(): void
    {
        $utilsDir = _DIR_PROJECT_ROOT . "/core/utils/";

        foreach ( self::$utilClasses as $className )
        {
            $classPath = "{$utilsDir}/class.{$className}.php";
            if ( !file_exists($classPath) )
            {
                throw new Exception( "Cannot find class '{$className}'" );
            }
            require_once $classPath;
        }
    }

    public static function loadInterfaces()
    {
        foreach ( self::$interfaces as $interface )
        {
            $interfacePath = Constants::_INTERFACE_PREFIX . $interface . Constants::_PHP_EXT;
            if ( !file_exists($interfacePath) )
            {
                throw new Exception( "Cannot find class '{$interface}'" );
            }
            require_once $interfacePath;
        }
    }

    public static function loadAbstractClasses()
    {
        foreach ( self::$abstractClasses as $abstractClass )
        {
            $abstractClassPath = Constants::_ABSTRACT_CLASS_PREFIX . $abstractClass . Constants::_PHP_EXT;
            if ( !file_exists($abstractClassPath) )
            {
                throw new Exception( "Cannot find class '{$abstractClass}'" );
            }
            require_once $abstractClassPath;
        }
    }

    public static function loadModels()
    {
        foreach ( self::$models as $model )
        {
            $modelPath = Constants::_MODEL_PREFIX . $model . Constants::_PHP_EXT;
            if ( !file_exists($modelPath) )
            {
                throw new Exception( "Cannot find class '{$model}'" );
            }
            require_once $modelPath;
        }
    }

    public static function loadClasses()
    {
        foreach ( self::$classes as $class )
        {
            $classPath = Constants::_CLASS_PREFIX . $class . Constants::_PHP_EXT;
            if ( !file_exists($classPath) )
            {
                throw new Exception( "Cannot find class '{$class}'" );
            }
            require_once $classPath;
        }
    }

    public static function loadPages()
    {
        foreach ( self::$pages as $page )
        {
            $pagePath = Constants::_PAGE_PREFIX . $page . Constants::_PHP_EXT;
            if ( !file_exists($pagePath) )
            {
                throw new Exception( "Cannot find class '{$page}'" );
            }
            require_once $pagePath;
        }
    }

    public static function load(): void
    {
        self::loadUtils();

        self::loadInterfaces();

        self::loadAbstractClasses();

        self::loadModels();

        self::loadClasses();

        self::loadPages();
    }
}