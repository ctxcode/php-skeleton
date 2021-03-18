<?php

namespace Query;

class User extends \DB\Query {

    ////////////////////
    // Custom queries
    ////////////////////

    public function findFirstActive($query) {
        return $query->where('active', true);
    }

}