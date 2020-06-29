<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Cookie
{
    private const CANCEL_COOKIE = -72;
    private const ONE_WEEK = 168;

    private static function getExpireTime( int $availabilityAsHours = 1 ): int
    {
        return time() + $availabilityAsHours * 3600;
    }

    public static function exists( string $cookieType ): bool
    {
        return !!$_COOKIE[ $cookieType ];
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
                $value = $value ?: 'en';
                $expiresAt = self::getExpireTime( self::ONE_WEEK );

                return setcookie( $name, $value, $expiresAt );
        }

        return false;
    }

    public static function unset( string $cookieType ): bool
    {
        if ( !$_COOKIE[ $cookieType ] ) return true;

        return setcookie( $cookieType, '', self::getExpireTime( self::CANCEL_COOKIE ));
    }
}