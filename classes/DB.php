<?php

// Shortcut class
class DB {

    // Get connection
    public function main(): \DB\Connection {
        return \DB\Connection::instance('default');
    }
}