<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Blog extends aPage
{
    public static function render( $context = [] ): void
    {
        self::clear();
        self::headers();
        self::css( __CLASS__ );

        self::component(
            Constants::_COMPONENT_NAVBAR,
            [ 'currentPage' => __CLASS__ ]
        );

        self::js( __CLASS__ );
        die;
    }
}