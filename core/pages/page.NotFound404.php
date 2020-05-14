<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class NotFound404 implements iPage
{
    public static function render( $context = [] ): void
    {
        echo '404 - Page not found';

        header( 'HTTP/1.1 404 Not Found' );

        die;
    }
}