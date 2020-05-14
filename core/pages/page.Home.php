<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Home implements iPage
{
    public static function render( $context = [] ): void
    {
        ?>
        <a href="about">About</a>
        <a href="blog">Blog</a>
        <?php
        die( 'Home works' );
    }

}