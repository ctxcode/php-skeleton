<?php

namespace DB;

class Query {

    private Connection $connection;

    public function __construct(Connection $con) {
        $this->connection = $con;
        return $this;
    }
}