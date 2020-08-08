<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Logger
{
    private static $filePath = '';

    private static function initialize(): void
    {
        $today = date('Y-m-d');
        self::$filePath = Constants::_DIR_LOG . ".{$today}.log";

        // Opens file if exists, creates file if not
        $file = fopen( self::$filePath, 'a' );

        if ( !$file )
            throw new Exception('Logfile error' );

        fclose( $file );
    }

    public static function mark( $begin = true )
    {
        self::initialize();

        $ts         = date('Y-m-d H:i:s' );
        $ipAddr     = Security::getUserIP();

        $http       = isset($_SERVER['HTTPS']) && !!$_SERVER['HTTPS'] && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $uri        = "{$http}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        $mark       = $begin ? ">>> {$uri}" : "<<<";

        $logEntry   = "[ {$ts} ] [ {$ipAddr} ] {$mark}\n";

        self::write( $logEntry );
    }

    private static function write( string $logMessage ): void
    {
        file_put_contents( self::$filePath, $logMessage, FILE_APPEND );
    }

    public static function log( string $message = '' ): void
    {
        if ( !self::$filePath ) self::initialize();

        // get caller info as Class::Method(arg1,arg2,...)
        $callerData = debug_backtrace()[1];
        $callerArgs = json_encode( $callerData['args'] );
        $callerData = ($callerData['class'] ?? '').'::'. ($callerData['function'] ?? '') . "({$callerArgs})";

        $ts = date('Y-m-d H:i:s' );
        $ipAddr = Security::getUserIP();

        $logEntry = "[ {$ts} ] [ {$ipAddr} ] [ {$callerData} ] {$message}\n";

        self::write($logEntry);
    }
}