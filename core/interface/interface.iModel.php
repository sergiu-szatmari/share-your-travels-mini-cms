<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

interface iModel
{
    public function __construct( array $args );

    public function update( $properties ): void;
}