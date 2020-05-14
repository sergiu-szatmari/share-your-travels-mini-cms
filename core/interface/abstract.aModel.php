<?php

defined( '_HELIX_VALID_ACCESS' ) or die( 'Invalid access' );

abstract class aModel implements iModel
{
    protected $properties;

    public function __construct( array $args )
    {
        if ( !$this->properties )
        {
            throw new Exception( 'Inner model properties not set' );
        }

        foreach ( $this->getProperties() as $property )
        {
            if ( !$args[$property] )
            {
                throw new Exception( "Invalid constructor parameter for property {$property} of class " . __CLASS__ );
            }

            $this->$property = $args[ $property ];
        }
    }

    public function __call( $method, $arguments )
    {
        $isGetFunction = strpos( $method, 'get' );
        if ( $isGetFunction === 0 && $isGetFunction !== false )
        {
            $propertyName = lcfirst( substr($method, 3) );
            return $this->$propertyName;
        }
    }

    protected function getProperties(): array
    {
        return $this->properties;
    }

    public function update( $properties ): void
    {
        foreach ( $this->getProperties() as $property )
        {
            $this->$property = $properties[ $property ] ?? $this->$property;
        }
    }


}