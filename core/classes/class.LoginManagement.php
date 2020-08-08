<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class LoginManagement
{
    public static function initialize( $context = [] ): void
    {
        Database::initialize( Environment::getEnvironment() );
    }

    public static function onLogin( array $loginForm, array &$user = null ): bool
    {
        self::initialize();

        if ( !$loginForm['username'] || !$loginForm['password'] ) return false;

        $username       = $loginForm['username'];
        $shaPassword    = $loginForm['password'];

         $user = Database::getFirst(
             [ Constants::_OPT_TABLE => 'users' ],
             [ 'username' => "= '{$username}'", 'password' => "= '{$shaPassword}'" ]
         );

        Logger::log( $user ?
            "User {$username} has logged in":
            "Wrong credentials on login for username '{$username}'" );

        $loginSuccessful = !!$user;

        if ( $loginSuccessful )
        {
            $cookieVal = Security::generateCookieValueFor( $user );
            $success = Cookie::set( Constants::_COOKIE_AUTH, $cookieVal );

            if ( $success )
            {
                Logger::log('Cookie was set successfully');
                if ( Database::update(
                    [ Constants::_OPT_TABLE => 'users' ],
                    [ 'cookieval' => "= '{$cookieVal}'" ],
                    [ 'username' => "= '{$username}'" ]
                ) ) Logger::log('Cookie stored successfully to db');
            }
        }

        return $loginSuccessful;
    }

    public static function onLogout(): bool
    {
        self::initialize();

        $cookieVal = Cookie::get( Constants::_COOKIE_AUTH );
        Cookie::unset( Constants::_COOKIE_AUTH );

        return Database::update(
            [ Constants::_OPT_TABLE => 'users' ],
            [ 'cookieval' => "= 'UNDEF'" ],
            [ 'cookieval' => "= '{$cookieVal}'" ]
        );
    }

    public static function getByCookieValue( string $cookieValue ): array
    {
        self::initialize();

        return Database::getFirst(
            [ Constants::_OPT_TABLE => 'users' ],
            [ 'cookieval' => "= '{$cookieValue}'" ]
        ) ?? [];
    }
}