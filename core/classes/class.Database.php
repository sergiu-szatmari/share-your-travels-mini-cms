<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class Database
{
    /** @var $db mysqli */
    private static $db = null;

    public static function initialize( $context ): void
    {
        self::$db = self::$db ?? new mysqli(
            $context['db_host'],
            $context['db_user'],
            $context['db_pass'],
            $context['db_name']
        );

        if ( self::$db ) Logger::log( 'Db connected successfully' );
    }

    private static function fetchResults( mysqli_result $resultObj ): array
    {
        $result = [];

        while ( $row = $resultObj->fetch_assoc() ) {
            $result []= $row;
        }

        return $result;
    }

    private static function buildQuery( $options, $where = [] ): string
    {
        $tableName = $options[ Constants::_OPT_TABLE ] ?? null;

        if ( !$tableName ) {
            throw new Exception('Table name missing');
        }

        $baseQuery = "SELECT * FROM $tableName WHERE 1=1";

        foreach ( $where as $field => $value ) {
            $baseQuery .= " AND $field $value";
        }

        return $baseQuery;
    }

    public static function get( $options = [], $where = [] ): array
    {
        $tableName  = $options[ Constants::_OPT_TABLE ] ?? null;

        if ( !$tableName )
        {
            throw new Exception('No table name given');
        }

        $query = self::buildQuery( $options, $where );

        if ( isset($options[ Constants::_OPT_ORDER ]) )
        {
            $query .= (" ORDER BY " . $options[ Constants::_OPT_ORDER ]);
        }

        Logger::log("Query: {$query}");
        $res = self::$db->query( $query );

        if ( $res !== false )
        {
            $result = self::fetchResults( $res );
            $res->close();
        }

        if ( self::$db->error ) {
            $error = self::$db->error;
            Logger::log( "Error on db query: {$error}" );
        }

        return $result ?? [];
    }

    public static function getFirst( $options = [], $where = [] ): array
    {
        return self::get( $options, $where )[0] ?? [];
    }

    public static function update( $options = [], $values = [], $where = [] ): bool
    {
        $tableName = $options[ Constants::_OPT_TABLE ] ?? null;

        if ( !$tableName ) throw new Exception('No table name given');

        $column = array_keys($values)[0];
        $value = $values[$column];
        array_shift( $values );
        $query = "UPDATE {$tableName} SET {$column} {$value} ";

        foreach ( $values as $column => $value ) {
            $query .= ", {$column} {$value} ";
        }

        $column = array_keys($where)[0];
        $value  = $where[$column];
        array_shift($where);
        $query .= (!!$column && !!$value) ?
            "WHERE {$column} {$value} " :
            "";

        foreach ( $where as $column => $value ) {
            $query .= "AND {$column} {$value} ";
        }

        Logger::log("Query: {$query}");
        $res = (self::$db->query($query) === true);
        return $res;
    }

    public static function insert( $options = [], $values = [] ): bool
    {
        $tableName = $options[ Constants::_OPT_TABLE ] ?? null;

        if ( !$tableName ) {
            throw new Exception('No table name given');
        }

        $query = "INSERT INTO {$tableName}";
        $queryColumns   = [];
        $queryValues    = [];

        foreach ( array_keys($values) as $column )
        {
            $queryColumns []= "{$column}";
        }

        $query .= '(' . implode(",", $queryColumns) . ')';
        $query .= " VALUES (";

        foreach ( array_values($values) as $value )
        {
            $queryValues []= "'{$value}'";
        }

        $query .=  implode( ",", $queryValues ) . ')';

        Logger::log("Query: {$query}");
        $success = self::$db->query($query);

        if ( !$success ) {
            $error = self::$db->error;
            Logger::log( "Error on db query: {$error}" );
        }

        return ($success === true);
    }

    public static function delete(array $options = [], array $where = [] ): bool
    {
        $tableName = $options[ Constants::_OPT_TABLE ] ?? null;

        if ( !$tableName ) throw new Exception( 'No table name given' );

        $col = array_keys($where)[0];
        $val = $where[ $col ];
        array_shift( $where );

        $query = "DELETE FROM {$tableName} WHERE {$col}{$val}";

        foreach ( $where as $col => $val ) {
            $query .= " AND {$col}{$val}";
        }

        Logger::log("Query: {$query}");
        $success = self::$db->query($query);

        if ( !$success )
        {
            $error = self::$db->error;
            Logger::log( "Error on db query: {$error}" );
        }

        return ($success === true);
    }

    public static function escapeStr( string $inputStr ): string
    {
        return self::$db->real_escape_string( $inputStr );
    }
}