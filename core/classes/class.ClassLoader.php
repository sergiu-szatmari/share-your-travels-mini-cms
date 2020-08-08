<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class ClassLoader
{
    private static $utilsDir;
    private static $utilsClassNames = [
        'Constants', 'Utils'
    ];

    private static $classes = [
        'ClassLoader', 'Dispatcher', 'AdminDispatcher',

        'Security', 'Environment',

        'Database', 'BlogPostManagement', 'FormManagement',
        'LoginManagement', 'Cookie', 'Language', 'Logger',
        'ReviewManagement'
    ];

    private static $abstractClasses = [
        'aDispatcher',
        'aPage',
    ];

    private static $interfaces = [
        'iPage',
    ];

    private static $pages = [

        // User pages
        'HomePage',
        'BlogPostPage',
        'SubmittedPage',

        // Admin pages
        'LoginPage',
        'AdminPage',

        // Error page
        'ErrorPage',
    ];

    public static function initialize(): void
    {
        self::$utilsDir = dirname(dirname(__FILE__)) . '/utils/';

        foreach (self::$utilsClassNames as $className) {
            if (!file_exists(self::$utilsDir . 'class.' . $className . '.php')) {
                throw new Exception("Cannot find class \"$className\".");
            }
        }
    }

    public static function load(): void
    {
        self::initialize();

        // Utils
        foreach (self::$utilsClassNames as $className) {
            require_once(self::$utilsDir . 'class.' . $className . '.php');
        }

        // Interfaces
        foreach (self::$interfaces as $interfaceName) {
            require_once(Constants::_INTERFACE_PREFIX . $interfaceName . Constants::_PHP_EXTENSION);
        }

        // AbstractClasses
        foreach (self::$abstractClasses as $abstractClassName) {
            require_once(Constants::_ABSTRACT_CLASS_PREFIX . $abstractClassName . Constants::_PHP_EXTENSION);
        }

        // Classes
        foreach (self::$classes as $className) {
            require_once(Constants::_CLASS_PREFIX . $className . Constants::_PHP_EXTENSION);
        }

        // Pages
        foreach (self::$pages as $pageName) {
            require_once(Constants::_PAGE_PREFIX . $pageName . Constants::_PHP_EXTENSION);
        }
    }

}