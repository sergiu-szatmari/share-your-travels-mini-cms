<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

abstract class aDispatcher
{
    abstract static function get(): void;

    abstract static function post(): void;

    public static function listen(): void
    {
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

    public static function defaultRequestHandler(): void
    {
        $methodName = strtolower($_SERVER['REQUEST_METHOD']);

        $protocol = ($_SERVER['HTTPS'] ?? '') === 'on' ?
            "https" :
            "http";

        $url = "{$protocol}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        Logger::log( "Unhandled request: {$methodName} @ {$url}" );
        Logger::mark( false );

        header('HTTP/1.0 403 Forbidden');
        die;
    }

    public static function notFound404(): void
    {
        ErrorPage::render([
            'httpCode' => '404',
            'errorMsg' => 'Page not found',
        ]);
    }

    public static function internalServerError500( string $errMsg = ''): void
    {
        ErrorPage::render([
            'httpCode' => '500',
            'errorMsg' => $errMsg,
        ]);
    }
}