<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Database
{
    private static $db;

    public static function initialize( $context ): void
    {
        self::$db = self::$db ?? new mysqli(
            $context['db_host'],
            $context['db_user'],
            $context['db_pass'],
            $context['db_name']
        );

        if ( self::$db )
        {
            // Logger::info( 'Db connected successfully' );
        }
    }
}