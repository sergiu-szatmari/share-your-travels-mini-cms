<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

interface iPage
{
    public static function render( $context ): void;
}