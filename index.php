<?php

// TODO: set_error_handler(...)
// TODO: set_exception_handler(...)
// TODO: error_reporting(...)

define('_HELIX_VALID_ACCESS',   true);
define('_DIR_PROJECT_ROOT',     dirname( __FILE__ ) . '/' );

echo "Welcome <br/>";
if ( $_GET['action'] ?? null )
{
    echo "Action: {$_GET['action']}";
}
