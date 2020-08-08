<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Language
{
    private static $defaultLangCode     = 'en';
    private static $supportedLangCodes  = [ 'ro', 'en' ];
    private static $lang                = [];

    private static function parseJsonFile( string $langCode ): array
    {
        $filePath = Constants::_DIR_LANG . $langCode . Constants::_JSON_EXT;
        Logger::log( $filePath );
        if ( !is_file($filePath) )
            throw new Exception( "Language file for code '{$langCode}' was not found" );

        $fileContent = file_get_contents( $filePath );

        return json_decode( $fileContent, true );
    }

    private static function initialize(): void
    {
        foreach ( self::$supportedLangCodes as $langCode )
        {
            self::$lang[ $langCode ] = self::parseJsonFile( $langCode );
        }
    }

    public static function get( string $stringCode, string $langCode = '' )
    {
        $langCode = $langCode ?: Cookie::get( Constants::_COOKIE_LANG ) ?: Language::getDefaultLangCode();

        if ( !self::$lang ) self::initialize();

        return self::$lang[ $langCode ][ $stringCode ] ?? '[UNDEF]';
    }

    public static function getDefaultLangCode(): string
    {
        return self::$defaultLangCode;
    }
}