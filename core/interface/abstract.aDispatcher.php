<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

abstract class aDispatcher
{
    abstract static function get(): void;

    abstract static function post(): void;

    abstract static function defaultRequestHandler(): void;

    public static function listen(): void
    {
        // TODO: Security
        $requestMethod = strtolower( $_SERVER['REQUEST_METHOD'] );

        switch ( $requestMethod )
        {
            case 'get':
            case 'post':
                static::$requestMethod();
                break;

            default:
                static::defaultRequestHandler();
                break;
        }
    }

    public static function home(): void
    {
        Home::render();
    }

    public static function about(): void
    {
        About::render();
    }

    public static function blog(): void
    {
        Blog::render();
    }
}