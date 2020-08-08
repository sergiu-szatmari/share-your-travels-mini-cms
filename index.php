<?php

//error_reporting(E_ALL);
error_reporting(E_ERROR);

define( '_HELIX_VALID_ACCESS',  1 );
define( '_DIR_PROJECT_ROOT',    dirname( __FILE__ ) . '/' );

try
{
    require_once( _DIR_PROJECT_ROOT . '/core/interface/interface.iPage.php');
    require_once( _DIR_PROJECT_ROOT . '/core/interface/abstract.aPage.php');
    require_once( _DIR_PROJECT_ROOT . '/core/classes/class.ClassLoader.php');

    ClassLoader::load();

    date_default_timezone_set( Environment::getTimezone() );

    Logger::mark();

    if ( !Cookie::exists(Constants::_COOKIE_LANG) )
    {
        Cookie::set( Constants::_COOKIE_LANG, Language::getDefaultLangCode() );
    }

    Dispatcher::listen();

} catch (Exception $ex) {

    ErrorPage::render([
        'httpCode' => 500,
        'errorMsg' => $ex->getMessage()
    ]);
}