<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class Utils
{
    public static function logObject( $object )
    {
        echo json_encode( $object, JSON_PRETTY_PRINT );
        echo '<br/>';
    }

    public static function logMessage( $message )
    {
        echo $message . '<br/>';
    }

    public static function getSeoName( string $name, $separator = '-' )
    {
        $accentsRegExp = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $specialCases = [ '&' => 'and', "'" => '' ];

        $name = str_replace('ă', 'a', $name);
        $name = str_replace('â', 'a', $name);
        $name = str_replace('î', 'i', $name);
        $name = str_replace('ş', 's', $name);
        $name = str_replace('ţ', 't', $name);

        $name = mb_strtolower( trim( $name ), 'UTF-8' );
        $name = str_replace( array_keys($specialCases), array_values( $specialCases), $name );
        $name = preg_replace( $accentsRegExp, '$1', htmlentities( $name, ENT_QUOTES, 'UTF-8' ) );
        $name = preg_replace("/[^a-z0-9]/u", "$separator", $name);
        $name = preg_replace("/[$separator]+/u", "$separator", $name);

        $name = preg_replace("/(.*)-+$/", '$1', $name);

        return $name;
    }
}