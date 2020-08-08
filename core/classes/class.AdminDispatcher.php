<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class AdminDispatcher extends aDispatcher
{
    public static function get(): void
    {
        $action = $_GET['action'] ?? null;

        if ( !$action ) self::adminHome();
        if ( !Security::isActionAllowed($action, __FUNCTION__)) self::notFound404();

        try { self::$action(); }
        catch (Exception $ex) { self::internalServerError500( $ex->getMessage() ); }
    }

    public static function post(): void
    {
        $action = $_POST['action'] ?? null;

        if ( !$action ||
            !Security::isActionAllowed($action, __FUNCTION__, $isAdmin = true)) self::notFound404();

        try { self::$action(); }
        catch (Exception $ex) { self::internalServerError500( $ex->getMessage() ); }
    }

    public static function adminHome( bool $redirectToGet = false ): void
    {
        $baseURL = Environment::getBaseURL();
        if ( $redirectToGet )
        {
            header( "Location: {$baseURL}/admin" );
            die;
        }

        $user = Cookie::exists(Constants::_COOKIE_AUTH) ?
            LoginManagement::getByCookieValue( Cookie::get(Constants::_COOKIE_AUTH) ) :
            [];

        if ( !$user ) self::loginPage();

        AdminPage::render([
            'username' => $user['username']
        ]);
    }

    public static function adminGetForm(): void
    {
        $formID = $_POST['formID'] ?? null;

        if ( !$formID ) die(json_encode([ 'ok' => 0, 'errMsg' => 'No form ID provided' ]));

        $form = FormManagement::getForm( $formID, $asArray = true);

        die(json_encode([
            'ok' => 1,
            'form' => $form
        ]));
    }

    public static function loginPage(): void
    {
        Cookie::unset( Constants::_COOKIE_AUTH );

        LoginPage::render();
    }

    public static function login(): void
    {
        LoginManagement::initialize();

        $formData = [
            'username' => $_POST['username'] ?? null,
            'password' => $_POST['password'] ? sha1($_POST['password']) : null
        ];

        if (LoginManagement::onLogin($formData, $user)) self::adminHome( true );

        LoginPage::render([
            'error' => 'Wrong credentials',
        ]);
    }

    public static function logout(): void
    {
        LoginManagement::onLogout();

        self::adminHome( true );
    }

    public static function adminAddPost(): void
    {
        $createdAt = $_POST['createdAt'] ?? date('m/d/Y');
        $blogPost = [
            'postTitleRo'   => $_POST['postTitleRo'] ?? '',
            'postTitleEn'   => $_POST['postTitleEn'] ?? '',
            'postContentRo' => $_POST['postContentRo'] ?? '',
            'postContentEn' => $_POST['postContentEn'] ?? '',
            'createdAt'     => $createdAt
        ];

        BlogPostManagement::addBlogpost($blogPost);

        self::adminHome( true );
    }

    public static function adminRemovePost(): void
    {
        $postID = $_POST['postID'] ?? '';

        if ( !$postID ) die(json_encode([ 'ok' => 0, 'errMsg' => 'No post ID provided' ]));

        try
        {
            $result = BlogPostManagement::removeBlogpost( $postID );
            die(json_encode([ 'ok' => $result ]));
        }
        catch (Exception $ex)
        {
            die(json_encode([ 'ok' => 0, 'errMsg' => $ex->getMessage() ]));
        }

    }

    public static function adminUpdatePost(): void
    {
        $postID = $_POST['postID'] ?? $_POST['id'] ?? '';

        $createdAt = $_POST['createdAt'] ?? date('m/d/Y');
        $blogPost = [
            'id'            => $postID,
            'postTitleRo'   => $_POST['postTitleRo'] ?? '',
            'postTitleEn'   => $_POST['postTitleEn'] ?? '',
            'postContentRo' => $_POST['postContentRo'] ?? '',
            'postContentEn' => $_POST['postContentEn'] ?? '',
            'createdAt'     => $createdAt
        ];

        if ( $postID ) BlogPostManagement::updateBlogpost( $postID, $blogPost );
        // else error ?

        self::adminHome( true );
    }

    public static function adminGetBlogPost(): void
    {
        $postID = $_POST['postID'];

        if ( !$postID ) die(json_encode([ 'ok' => 0, 'errMsg' => 'No blog post ID provided' ]));

        $blogPost = BlogPostManagement::getBlogpost( $postID );

        die(json_encode([
            'ok' => 1,
            'blogPost' => $blogPost
        ]));
    }

    public static function adminRemoveReview(): void
    {
        $reviewID = $_POST['reviewID'];

        if ( !$reviewID ) die(json_encode([ 'ok' => 0, 'msg' => 'No review ID provided' ]));

        try
        {
            ReviewManagement::removeReview( $reviewID );
            die(json_encode([
                'ok' => 1,
                'msg' => 'OK'
            ]));
        }
        catch (Exception $ex)
        {
            die(json_encode([
                'ok' => 0,
                'msg' => $ex->getMessage()
            ]));
        }


    }
}