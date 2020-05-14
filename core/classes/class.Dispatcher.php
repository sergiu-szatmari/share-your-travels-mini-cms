<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Dispatcher extends aDispatcher
{
    public static function get(): void
    {
        $action = $_GET['action'] ?? null;

        if ( !$action )
        {
            Home::render();
        }

        if ( !Security::isActionAllowed($action, __FUNCTION__) )
        {
            BadRequest400::render([
                'message' => "Action '{$action}' is not allowed"
            ]);
        }

        try
        {
            self::$action();
        }
        catch (Exception $ex)
        {
            InternalServerError500::render([
                'errorMsg' => $ex->getMessage()
            ]);
        }
    }

    public static function post(): void
    {
        $action = $_POST['action'] ?? null;

        if ( !$action )
        {
            Home::render();
        }

        if ( !Security::isActionAllowed($action, __FUNCTION__) )
        {
            BadRequest400::render([
                'message' => "Action '{$action}' is not allowed"
            ]);
        }

        try
        {
            self::$action();
        }
        catch (Exception $ex)
        {
            InternalServerError500::render([
                'errorMsg' => $ex->getMessage()
            ]);
        }
    }

    public static function defaultRequestHandler(): void
    {
        BadRequest400::render([
            'message' => "Method '{$_SERVER['REQUEST_METHOD']}' is not allowed"
        ]);
    }
}