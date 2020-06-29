<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

class Database
{
    /**
     * @var $db mysqli
     */
    private static $db;

    public static function initialize( $context ): void
    {
        self::$db = self::$db ?? new mysqli(
            $context['db_host'],
            $context['db_user'],
            $context['db_pass'],
            $context['db_name']
        );

        if ( self::$db )
        {
            // Logger::info( 'Db connected successfully' );
        }
    }

    private static function buildQuery( array $options, array $where = [] ): string
    {
        if ( !$options[ Constants::_OPT_TABLE ] )
            throw new Exception( 'Table name missing' );

        $table      = $options[ Constants::_OPT_TABLE ];
        $baseQuery  = "SELECT * FROM {$table} WHERE 1=1";

        // Where
        foreach ( $where as $field => $value )
        {
            $baseQuery .= " AND {$field} {$value}";
        }

        // Order by
        if ( $options[ Constants::_OPT_ORDER_BY ] )
        {
            $order = $options[ Constants::_OPT_ORDER_BY ];
            $baseQuery .= " ORDER BY {$order}";
        }

        return $baseQuery;
    }

    private static function fetchResults( mysqli_result $res ): array
    {
        $result = [];

        while ( $row = $res->fetch_assoc() )
        {
            $result []= $row;
        }

        return $result;
    }

    public static function get( array $options = [], array $where = [] ): array
    {
        if ( !$options[ Constants::_OPT_TABLE ] )
            throw new Exception('No table name given');

        $query  = self::buildQuery( $options, $where );
        $result = [];
        $res    = self::$db->query( $query );

        if ( $res !== false )
        {
            $result = self::fetchResults( $res );
            $res->close();
        }

        if ( self::$db->error )
        {
            throw new Exception( "Exception occured: " . self::$db->error );
        }

        return $result;
    }

    public static function getFirst( array $options = [], array $where = [] ): array
    {
        return self::get( $options, $where )[0] ?? [];
    }
}