<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class Dispatcher extends aDispatcher
{
    public static function get(): void
    {
        $action = $_GET['action'] ?? null;

        if ( !$action ) self::home();
        if ( !Security::isActionAllowed($action, __FUNCTION__)) self::notFound404();

        try { self::$action(); }
        catch (Exception $ex) { self::internalServerError500( $ex->getMessage() ); }

    }

    public static function post(): void
    {
        $action = $_POST['action'] ?? null;

        if ( !$action ||
            !Security::isActionAllowed($action, __FUNCTION__)) self::notFound404();

        try { self::$action(); }
        catch (Exception $ex) { self::internalServerError500( $ex->getMessage() ); }

    }

    public static function test(): void
    {
        ErrorPage::render([
            'errorMsg' => "Test (args: {$_GET['arg']})"
        ]);
    }

    public static function seeBlogPost(): void
    {
        $seoName = $_GET['seoName'];

        if ( !$seoName ) ErrorPage::render([
            'httpCode' => '404',
            'errorMsg' => Language::get( 'error-invalid-url' )
        ]);

        BlogPostPage::render([ 'seoName' => $seoName ]);
    }

    public static function home(): void
    {
        HomePage::render();
    }

    private static function formSubmit(): void
    {
        try { FormManagement::onSubmit(); }
        catch (Exception $ex) { self::internalServerError500( $ex->getMessage() ); }

        header( 'Location: submit' );
    }

    public static function submitted(): void
    {
        SubmittedPage::render();
    }

    public static function reviewSubmit(): void
    {
        try
        {
            if (!$_POST['review_name'] || !$_POST['review_email'] ||
                !$_POST['review_rating'] || !$_POST['review_message'] ) {
                throw new Exception('Invalid fields');
            }

            ReviewManagement::addReview( $_POST );

            die(json_encode([
                'ok' => 1,
                'message' => 'OK'
            ]));
        }
        catch (Exception $ex)
        {
            die(json_encode([
                'ok' => 0,
                'message' => $ex->getMessage()
            ]));
        }

    }
}