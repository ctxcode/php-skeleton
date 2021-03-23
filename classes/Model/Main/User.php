<?php

namespace Model\Main;

class User extends \DB\Model {

    public int $id;
    public string $firstname;
    public string $lastname;
    public string $email;

    public static function struct() {
        return \S::object([
            'id' => \S::integer(),
            'firstname' => \S::string(),
            'lastname' => \S::string(),
            'email' => \S::string()->format('email'),
        ]);
    }

    protected $_columns = ['id', 'firstname', 'lastname', 'email'];
    protected $_primary_key = 'id';
    protected $_table = 'users'; // mysql. postgres
    protected $_collection = 'users'; // Arrangodb
    protected $_query_class = \Query\User::class;

    ////////////////////
    // Custom functions
    ////////////////////

}