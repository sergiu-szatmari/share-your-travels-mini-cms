<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Constants
{
    // Dirs
    public const _DIR_CORE              = _DIR_PROJECT_ROOT . 'core/';
    public const _DIR_ENV               = _DIR_PROJECT_ROOT . 'env/';

    public const _DIR_INTERFACES        = self::_DIR_CORE . 'interface/';
    public const _DIR_MODELS            = self::_DIR_CORE . 'model/';
    public const _DIR_CLASSES           = self::_DIR_CORE . 'classes/';
    public const _DIR_PAGES             = self::_DIR_CORE . 'pages/';

    // Resources dirs
    public const _DIR_WEBFILES          = 'webfiles/';
    public const _DIR_CSS               = self::_DIR_WEBFILES . 'css/';
    public const _DIR_JS                = self::_DIR_WEBFILES . 'js/';

    // Prefixes
    public const _ENV_PREFIX            = self::_DIR_ENV . ".env-";
    public const _INTERFACE_PREFIX      = self::_DIR_INTERFACES . 'interface.';
    public const _ABSTRACT_CLASS_PREFIX = self::_DIR_INTERFACES . 'abstract.';
    public const _MODEL_PREFIX          = self::_DIR_MODELS . 'entity.';
    public const _CLASS_PREFIX          = self::_DIR_CLASSES . 'class.';
    public const _PAGE_PREFIX           = self::_DIR_PAGES . 'page.';

    // Environment types
    public const _ENV_LOCALHOST         = 'localhost';
    public const _ENV_DEPLOY            = 'deploy';
    public const _ENV_TEST              = 'test';

    // Extensions
    public const _PHP_EXT               = '.php';
    public const _CSS_EXT               = '.css';
    public const _JS_EXT                = '.js';

    // Component names
    public const _COMPONENT_NAVBAR      = 'Navbar';

    // Options
    public const _OPT_TABLE             = 'table';
    public const _OPT_ORDER_BY          = 'orderBy';
}