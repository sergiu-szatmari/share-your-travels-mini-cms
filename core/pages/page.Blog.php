<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Blog implements iPage
{
    public static function render( $context = [] ): void
    {
        die( 'Blog works' );
    }
}