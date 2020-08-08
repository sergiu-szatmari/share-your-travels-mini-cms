<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class Constants
{
    public const _DIR_UTILS                 = __DIR__ . '/';

    public const _DIR_CORE                  = _DIR_PROJECT_ROOT . 'core/';
    public const _DIR_WEBFILES              = _DIR_PROJECT_ROOT . 'webfiles/';
    public const _DIR_ENV                   = _DIR_PROJECT_ROOT . 'env/';
    public const _DIR_LOG                   = _DIR_PROJECT_ROOT . 'logs/';

    public const _DIR_CLASSES               = self::_DIR_CORE . 'classes/';
    public const _DIR_INTERFACES            = self::_DIR_CORE . 'interface/';
    public const _DIR_PAGES                 = self::_DIR_CORE . 'pages/';

    public const _DIR_LANG                  = self::_DIR_WEBFILES . 'lang/';

    public const _PAGE_PREFIX               = self::_DIR_PAGES . 'page.';
    public const _CLASS_PREFIX              = self::_DIR_CLASSES . 'class.';
    public const _INTERFACE_PREFIX          = self::_DIR_INTERFACES . 'interface.';
    public const _ABSTRACT_CLASS_PREFIX     = self::_DIR_INTERFACES . 'abstract.';
    public const _ENV_PREFIX                = self::_DIR_ENV . '.env-';

    public const _PHP_EXTENSION             = '.php';
    public const _JSON_EXT                  = '.json';

    public const _OPT_TABLE                 = 'table';
    public const _OPT_ORDER                 = 'order';

    public const _ENV_LOCALHOST             = 'localhost';
    public const _ENV_DEPLOY                = 'deploy';

    public const _COOKIE_LANG               = 'helixlang';
    public const _COOKIE_AUTH               = 'helixauth';
}