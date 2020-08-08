<?php

defined('_HELIX_VALID_ACCESS') or die('Invalid access');

class FormManagement
{
    public static function initialize( $context = [] ): void
    {
        Database::initialize( Environment::getEnvironment() );
    }

    public static function getForms(): array
    {
        self::initialize();

        return Database::get(
            [
                Constants::_OPT_TABLE => 'forms',
                Constants::_OPT_ORDER => 'formDate DESC'
            ]
        ) ?? [];
    }

    public static function getForm( $formID, $returnAsArray = false )
    {
        self::initialize();

        $dbResult = Database::get(
            [ Constants::_OPT_TABLE => 'forms' ],
            [ 'id' => "= {$formID}" ]
        );

        return $dbResult[0];
    }

    public static function onSubmit(): void
    {
        self::initialize();

        if ( !$_POST['action'] || $_POST['action'] !== 'formSubmit' ) return;

        try
        {
            foreach( [ 'name', 'email', 'live', 'travelStory', 'skype' ] as $key ) {
                if ( trim($_POST[$key]) === "" ) throw new Exception('badfields');
            }

            $form               = $_POST;
            $form['formDate']   = date('Y-m-d');

             Database::insert(
                 [ Constants::_OPT_TABLE => 'forms' ],
                 [
                     'name'         => $form['name'],
                     'email'        => $form['email'],
                     'live'         => $form['live'],
                     'travelStory'  => $form['travelStory'],
                     'skype'        => $form['skype'],
                     'formDate'     => $form['formDate']
                 ]
             );
        }
        catch (Exception $ex)
        {
            throw ($ex->getMessage() === 'badfields') ?
                new Exception(Language::get('contact-invalid-form')) :
                $ex;
        }
    }
}