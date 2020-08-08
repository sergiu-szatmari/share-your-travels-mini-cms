<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class BlogPostManagement
{
    public static function initialize( $context = [] ): void
    {
        Database::initialize( Environment::getEnvironment() );
    }

    public static function getBlogposts( $newestFirst = false ): array
    {
        self::initialize();

        $options = [ Constants::_OPT_TABLE => 'blogposts' ];
        if ( $newestFirst )
        {
            $options[Constants::_OPT_ORDER] = 'createdAt DESC';
        }

        return Database::get($options) ?? [];
    }

    public static function addBlogpost( array $blogPost ): bool
    {
        self::initialize();

        $seoNameEn = Utils::getSeoName( $blogPost['postTitleEn'] );

        $result = Database::insert(
            [ Constants::_OPT_TABLE => 'blogposts' ],
            [
                'postTitleRo'   => $blogPost['postTitleRo'],
                'postTitleEn'   => $blogPost['postTitleEn'],
                'seo'           => $seoNameEn,
                'postContentRo' => str_replace("\n", "<br/>", $blogPost['postContentRo']),
                'postContentEn' => str_replace("\n", "<br/>", $blogPost['postContentEn']),
                'createdAt'     => $blogPost['createdAt'] ?: date('m/d/y')
            ]
        );

        return $result;
    }

    public static function updateBlogpost( string $blogPostID, array $newBlogPost ): bool
    {
        self::initialize();

        // Eliminating empty fields
        $fields = [
            'postTitleRo'   => $newBlogPost['postTitleRo']   ?: '',
            'postTitleEn'   => $newBlogPost['postTitleEn']   ?: '',
            'postContentRo' => str_replace("\n", "<br/>", $newBlogPost['postContentRo']) ?: '',
            'postContentEn' => str_replace("\n", "<br/>", $newBlogPost['postContentEn']) ?: '',
            'createdAt'     => $newBlogPost['createdAt']     ?: ''
        ];

        foreach (array_keys($fields) as $key) {
            if ( $fields[$key] !== '' ) {
                $fields[ $key ] = "= '{$fields[ $key ]}'";
            }else {
                unset($fields[$key]);
            }
        }

        // Updating only the values that are not empty
        $result = Database::update(
            [ Constants::_OPT_TABLE => 'blogposts' ],
            $fields,
            [ 'id' => "= {$blogPostID}" ]
        );

        return $result;
    }

    public static function removeBlogpost( string $postID ): bool
    {
        if ( !$postID ) return false;

        self::initialize();

        $result = Database::delete(
            [ Constants::_OPT_TABLE => 'blogposts' ],
            [ 'id' => "= {$postID}" ]
        );

        return $result;
    }

    public static function getBlogpost( string $blogPostID ): array
    {
        if ( !$blogPostID ) return null;

        self::initialize();

        $dbResult = Database::get(
            [ Constants::_OPT_TABLE => 'blogposts' ],
            [ 'id' => "= {$blogPostID}" ]
        );

        return $dbResult[0];
    }

    public static function getBlogpostBySeo( string $seo ): array
    {
        if ( !$seo ) return null;

        self::initialize();

        $dbResult = Database::get(
            [ Constants::_OPT_TABLE => 'blogposts' ],
            [ 'seo' => "= '{$seo}'" ]
        );

        return $dbResult[0];
    }

    public static function trimContent( $seoName, $postContent, $numberOfWords = 50, $excludeHref = false ): string
    {
        $contentArray = explode(" ", $postContent);

        if ( count($contentArray) <= $numberOfWords ) return $postContent;

        $contentArray = array_slice( $contentArray, 0, $numberOfWords );

        $postContent = implode( ' ', $contentArray );

        $readMore = Language::get( 'blog-readmore' );
        $baseURL = Environment::getBaseURL();
        $aHref = $excludeHref ? "" : "&nbsp; <a id='powered-by' style='margin-right: 0;' href='{$baseURL}/posts/{$seoName}' target='_blank'> {$readMore} </a>";

        return "{$postContent} ...{$aHref}";
    }
}