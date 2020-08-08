<?php

define( '_HELIX_VALID_ACCESS',  1 );
define( '_DIR_PROJECT_ROOT',    dirname(dirname( __FILE__ )) . '/' );

try {

    require_once( _DIR_PROJECT_ROOT . '/core/interface/interface.iPage.php' );
    require_once( _DIR_PROJECT_ROOT . '/core/interface/abstract.aPage.php' );
    require_once( _DIR_PROJECT_ROOT . '/core/classes/class.ClassLoader.php' );

    ClassLoader::load();

    Logger::mark();

    if ( !Cookie::exists(Constants::_COOKIE_LANG) )
    {
        Cookie::set( Constants::_COOKIE_LANG, Language::getDefaultLangCode() );
    }

    date_default_timezone_set( Environment::getTimezone() );

    AdminDispatcher::listen();

} catch (Exception $ex) {

    ErrorPage::render([
        'httpCode' => 500,
        'errorMsg' => $ex->getMessage()
    ]);
}