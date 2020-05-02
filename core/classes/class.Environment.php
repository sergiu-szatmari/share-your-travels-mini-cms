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

                $file   = fopen( Constants::_ENV_PREFIX . $envType, 'r' );
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
        return $_SERVER['HTTP_HOST'] === 'localhost' ?
            self::loadEnvironment( Constants::_ENV_LOCALHOST ) :
            self::loadEnvironment( Constants::_ENV_DEPLOY );
    }
}