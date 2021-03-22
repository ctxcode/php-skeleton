<?php

return function (\Request $req, \Response $res) {

    $req->on_error = function (\Request $req, \Throwable $t) {

        // Write error/trace to your logging system
        $error = $t->getMessage();
        $trace = $t->getTrace();

        $trace_text = '';
        foreach ($trace as $tr) {
            $trace_text .= $tr['file'] . ' (' . ($tr['line']) . ')' . "\n";
        }

        if ($this->source == 'workerman') {
            echo "Error: $error\n";
            echo "-------------------------------\n";
            echo $trace_text;
            echo "-------------------------------\n";
        }

    };

};
