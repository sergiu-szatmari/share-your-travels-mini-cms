<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Security
{
    private static $allowedActions = [
        'get' => [
            'home',
            'about',
            'blog',
            'join'
        ],
        'post' => [

        ]
    ];

    private static $adminAllowedActions = [
        'get' => [
            '',
        ],
        'post' => [
            'login',
        ]
    ];

    public static function isActionAllowed( $action, $method, bool $isAdmin = false ): bool
    {
        $allowedActions = $isAdmin ?
            self::$adminAllowedActions :
            self::$allowedActions;

        return
            array_key_exists( $method, $allowedActions )
            and
            in_array( $action, $allowedActions[ $method ] );
    }
}