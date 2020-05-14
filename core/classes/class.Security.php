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

    public static function isActionAllowed( $action, $method ): bool
    {
        return
            array_key_exists( $method, self::$allowedActions )
            and
            in_array( $action, self::$allowedActions[ $method ] );
    }
}