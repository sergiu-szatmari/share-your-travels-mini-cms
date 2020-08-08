<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class ReviewManagement
{
    public static function initialize(): void
    {
        Database::initialize( Environment::getEnvironment() );
    }

    public static function getReviews( $newestFirst = false ): array
    {
        self::initialize();

        $options = [ Constants::_OPT_TABLE => 'reviews' ];
        if ( $newestFirst ) $options[ Constants::_OPT_ORDER ] = 'createdAt DESC';

        return Database::get( $options ) ?? [];
    }

    public static function addReview( array $review ): bool
    {
        self::initialize();

        return Database::insert(
            [ Constants::_OPT_TABLE => 'reviews' ],
            [
                'displayName' => $review['review_name'],
                'email' => $review['review_email'],
                'rating' => $review['review_rating'],
                'message' => $review['review_message'],
                'createdAt' => date('Y-m-d'),
            ]
        );
    }

    public static function removeReview( string $reviewID ): bool
    {
        self::initialize();

        return Database::delete(
            [ Constants::_OPT_TABLE => 'reviews' ],
            [ 'id' => "= {$reviewID}"]
        );
    }
}