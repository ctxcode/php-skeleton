<?php

namespace DB;

class Model {

    protected $_primary_key;
    protected $_columns;
    protected $_table; // mysql. postgres
    protected $_collection; // Arrangodb
    protected $_query_class;

    public static function query(Connection $con) {
        return (new static::$_query_class)($con);
    }

}
