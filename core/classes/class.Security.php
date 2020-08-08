<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class Security
{
    private static $allowedActions = [
        'get' => [
            'home',
            'about',
            'blog',
            'join',
            'test',
            'seeBlogPost',
            'submitted'
        ],
        'post'  => [
            'formSubmit',
            'reviewSubmit',
            'onSubscribe',
        ],
    ];

    private static $adminAllowedActions = [
        'get' => [
        ],
        'post' => [
            'login',
            'logout',
            'adminGetForm',
            'adminGetBlogPost',
            'adminAddPost',
            'adminUpdatePost',
            'adminRemovePost',
            'adminRemoveReview'
        ]
    ];

    public static function isActionAllowed( $action, $method, bool $isAdmin = false ): bool
    {
        $allowedActions = $isAdmin ?
            self::$adminAllowedActions :
            self::$allowedActions;

        return
            array_key_exists($method, $allowedActions)
            and
            in_array( $action, $allowedActions[ $method ] );
    }

    public static function initialize($context): void { }

    public static function getUserIP(): string
    {
        $client     = @$_SERVER['HTTP_CF_CONNECTING_IP'] ?? @$_SERVER['HTTP_CLIENT_IP'];
        $forward    = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote     = @$_SERVER['HTTP_CF_CONNECTING_IP'] ?? @$_SERVER['REMOTE_ADDR'];

        return filter_var($client, FILTER_VALIDATE_IP) ?
            $client :
            (filter_var( $forward, FILTER_VALIDATE_IP ) ?
                $forward :
                $remote);
    }

    public static function generateCookieValueFor( array $user ): string
    {
        $currentTimestamp = time();
        return md5( "{$user['username']}-{$user['password']}-{$currentTimestamp}" );
    }

    public static function isEmailValid( string $email = '' ): bool
    {
        return !!$email ?
            filter_var( $email, FILTER_VALIDATE_EMAIL ) :
            false;

    }
}