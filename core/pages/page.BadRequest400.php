<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class BadRequest400 implements iPage
{
    public static function render( $context = [] ): void
    {
        echo "400 Bad Request" . ( $context['message'] ? ": {$context['message']}" : '' );

        header( 'HTTP/1.1 400 Bad Request' );

        die;
    }
}