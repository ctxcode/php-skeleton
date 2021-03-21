<?php

return function (\Request $req, \Response $res) {

    $req->onError = function (\Request $req, \Throwable $t) {

        // Write error/trace to your logging system
        $error = $t->getMessage();
        $trace = $t->getTrace();

        if ($this->source == 'workerman') {
            echo "Error: $error\n";
        }

    };

    throw new \Exception("test");

};
