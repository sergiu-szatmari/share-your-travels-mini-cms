<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class Constants
{
    // Dirs
    public const _DIR_CORE          = _DIR_PROJECT_ROOT . 'core/';
    public const _DIR_WEBFILES      = _DIR_PROJECT_ROOT . 'webfiles/';
    public const _DIR_ENV           = _DIR_PROJECT_ROOT . 'env/';

    // Prefixes
    public const _ENV_PREFIX        = self::_DIR_ENV . ".env-";

    // Environment types
    public const _ENV_LOCALHOST     = 'localhost';
    public const _ENV_DEPLOY        = 'deploy';
    public const _ENV_TEST          = 'test';
}