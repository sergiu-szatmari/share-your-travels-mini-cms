<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class Environment
{
    private static function loadEnvironment( $envType ): array
    {
        switch ( $envType )
        {
            case Constants::_ENV_LOCALHOST:
            case Constants::_ENV_DEPLOY:

                $filename = Constants::_ENV_PREFIX . $envType;

                if ( !is_file($filename) )
                {
                    throw new Exception('Environment file not found.');
                }

                $file   = fopen( $filename, 'r' );
                $env    = [];

                while ( ($line = fgets($file)) !== false )
                {
                    $parts          = explode( '=', $line );
                    $key            = trim( $parts[0] );
                    $value          = trim( $parts[1] );

                    $env[ $key ]    = $value;
                }

                fclose( $file );

                return $env;
                break;

            default:
                return [];
        }
    }

    public static function getEnvironment(): array
    {
        $host = $_SERVER['HTTP_HOST'];
        if (stripos($host, 'localhost') !== false) return self::loadEnvironment( Constants::_ENV_LOCALHOST );
        if (stripos($host, 'live-server-name') !== false) return self::loadEnvironment( Constants::_ENV_DEPLOY );

        throw new Exception('Invalid environment');
    }

    public static function isLocalhost(): bool
    {
        return (bool)(in_array( Security::getUserIP(), ['127.0.0.1', '::1'] ));
    }

    public static function getBaseURL(): string
    {
        return self::getEnvironment()['base_url'];
    }

    public static function getTimezone(): string
    {
        return self::getEnvironment()['timezone'];
    }
}