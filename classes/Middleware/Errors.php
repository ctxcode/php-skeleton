<?php

namespace Middleware;

class Errors {

    public static function run($req, $res) {
        $req->onError = '\Middleware\Errors::onError';
        throw new \Exception("test");
    }

    public static function onError($req, \Throwable $t) {

        // Write error/trace to your logging system
        $error = $t->getMessage();
        $trace = $t->getTrace();

        if ($this->source == 'workerman') {
            echo "Error: $error\n";
        }

    }

}