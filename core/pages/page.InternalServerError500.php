<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class InternalServerError500 implements iPage
{
    public static function render( $context = [] ): void
    {
        echo 'Server encountered an unexpected error' . ( $context['errorMsg'] ? ": '{$context['errorMsg']}'" : '' );

        header( 'HTTP/1.1 500 Internal Server Error' );

        die;
    }
}