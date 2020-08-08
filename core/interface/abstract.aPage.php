<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

abstract class aPage implements iPage
{
    private static $pageHeaders = [
        'Default' =>
            '<!DOCTYPE html>
			<!-- This comment line needed for bootstrap to work on mobile devices -->
			<html lang="en">
			<meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="{{BASE_URL}}/favicon.png" type="image/png" sizes="16x16"/>
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            
            <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
            
            <link rel="stylesheet" href="{{BASE_URL}}/webfiles/css/constructive-theme{{USE_MIN}}.css">
            <link rel="stylesheet" href="{{BASE_URL}}/webfiles/css/style{{USE_MIN}}.css" type="text/css">
            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" type="text/css">
            <link rel="stylesheet" href="{{BASE_URL}}/webfiles/img/ajax-loader.gif" type="image/gif">',

        'Lang' =>
            '<script src="{{BASE_URL}}/webfiles/js/lang.js"></script>',

        'AdminPage' =>
            '<link rel="stylesheet" href="{{BASE_URL}}/webfiles/css/admin{{USE_MIN}}.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>',

        'HomePage' =>
            '',

        'LoginPage' =>
            '<link rel="stylesheet" href="{{BASE_URL}}/webfiles/css/login{{USE_MIN}}.css">',

        'BlogPostPage' =>
            ''

    ];

    private static $scripts = [

        'Default' =>
            '<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.1.18/jquery.backstretch.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"></script>
            
            <script type="text/javascript" src="{{BASE_URL}}/webfiles/js/core{{USE_MIN}}.js"></script>
            <script type="text/javascript" src="{{BASE_URL}}/webfiles/js/constructive-theme{{USE_MIN}}.js"></script>',

        'HomePage' =>
            '<script type="text/javascript" src="{{BASE_URL}}/webfiles/js/home{{USE_MIN}}.js"></script>',

        'BlogPostPage' =>
            '<script type="text/javascript" src="{{BASE_URL}}/webfiles/js/blogpost{{USE_MIN}}.js"></script>',

        'LoginPage' =>
            '',

        'AdminPage' =>
            '<meta name="robots" content="noindex">
            <script type="text/javascript" src="{{BASE_URL}}/webfiles/js/admin{{USE_MIN}}.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>',
    ];

    abstract public static function render($context = []): void;

    public static function clear(): void
    {
        ob_clean();
        ob_start();
    }

    public static function headers( $page = '', $pageTitle ): void
    {
        $env = Environment::getEnvironment();
        $baseURL = $env['base_url'];
        $useMin = $env['use_min'];

        $defaultHeaders = str_replace('{{BASE_URL}}', $baseURL , self::$pageHeaders['Default'] );
        $defaultHeaders = str_replace('{{USE_MIN}}', $useMin , $defaultHeaders );

        $langScript = str_replace('{{BASE_URL}}', $baseURL, self::$pageHeaders['Lang']);
        $langScript = str_replace('{{USE_MIN}}', $useMin, $langScript);

        $pageHeaders = str_replace('{{BASE_URL}}', $baseURL , self::$pageHeaders[ $page ] );
        $pageHeaders = str_replace('{{USE_MIN}}', $useMin , $pageHeaders );


        echo $defaultHeaders;
        echo "<script> const baseURL = '{$baseURL}'; </script>";
        echo $langScript;
        echo $pageHeaders;
        echo "<title>{$pageTitle}</title>";
    }

    public static function scripts( $page = '' ): void
    {
        $env = Environment::getEnvironment();
        $baseURL = $env['base_url'];
        $useMin = $env['use_min'];

        $defaultScripts = str_replace('{{BASE_URL}}', $baseURL , self::$scripts['Default'] );
        $defaultScripts = str_replace('{{USE_MIN}}', $useMin , $defaultScripts );

        $pageScripts = str_replace('{{BASE_URL}}', $baseURL , self::$scripts[ $page ] );
        $pageScripts = str_replace('{{USE_MIN}}', $useMin , $pageScripts );

        echo $defaultScripts;
        echo $pageScripts;
    }
}