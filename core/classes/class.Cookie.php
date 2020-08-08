<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Cookie
{
    private const CANCEL_COOKIE = -72;
    private const ONE_DAY       = 24;
    private const ONE_WEEK      = 168;

    private static function getExpireTime( int $availabilityAsHours = 1 ): int
    {
        return time() + $availabilityAsHours * 3600;
    }

    public static function exists( string $cookieType ): bool
    {
        return isset( $_COOKIE[$cookieType] ) && !!$_COOKIE[ $cookieType ];
    }

    public static function get( string $cookieType ): string
    {
        return $_COOKIE[ $cookieType ] ?? '';
    }

    public static function set( string $cookieType, string $value = '' ): bool
    {
        $name = $cookieType;

        switch ( $cookieType )
        {
            case Constants::_COOKIE_LANG:

                $value          = $value ?: Language::getDefaultLangCode();
                $cookieWasSet   = setcookie( $name, $value );
                if ($cookieWasSet) $_COOKIE[ Constants::_COOKIE_LANG ] = $value;

                Logger::log( $cookieWasSet ?
                    "Cookie was successfully set to '{$value}'" :
                    'Cookie was not set...'
                );
                
                return $cookieWasSet;
                break;

            case Constants::_COOKIE_AUTH:

                if ( !$value ) return false;

                $expiresAt = self::getExpireTime( self::ONE_DAY );

                $cookieWasSet = setcookie( $name, $value, $expiresAt, '/' );
//                if ($cookieWasSet) $_COOKIE[ Constants::_COOKIE_AUTH ] = $value;

                Logger::log( $cookieWasSet ?
                    "Auth cookie was successfully set to value '{$value}'" :
                    "Auth cookie was not set"
                );

                return $cookieWasSet;
                break;
        }

        return false;
    }

    public static function unset( string $cookieType ): bool
    {
        if ( !$_COOKIE[ $cookieType ] ) return true;

        $cookieWasUnset = setcookie( $cookieType, '', self::getExpireTime( self::CANCEL_COOKIE ), '/');
        if ($cookieWasUnset) unset($_COOKIE[$cookieType]);

        return $cookieWasUnset;
    }
}