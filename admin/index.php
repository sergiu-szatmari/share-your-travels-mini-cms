<?php

// TODO: set_error_handler(...)
// TODO: set_exception_handler(...)
// TODO: error_reporting(...)

define( '_HELIX_VALID_ACCESS', true );
define( '_DIR_PROJECT_ROOT', dirname(dirname( __FILE__ )) . '/' );

try {

    require_once _DIR_PROJECT_ROOT . '/core/classes/class.ClassLoader.php';
    require_once _DIR_PROJECT_ROOT . '/core/interface/interface.iPage.php';
    require_once _DIR_PROJECT_ROOT . '/core/pages/page.InternalServerError500.php';

    ClassLoader::load();

    AdminDispatcher::listen();

} catch (Exception $ex) {

    InternalServerError500::render([
        'errorMsg' => $ex->getMessage()
    ]);
}