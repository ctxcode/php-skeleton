<?php

class Test {

    public string $title;
    public bool $stop_on_error = false;
    public  ? \DB\Connection $db;

    private array $errors = [];

    public function start(string $title) {
        $this->title = $title;
        echo "$title\n";
        echo "-------------------------------------\n";
    }

    public function finish() {
        echo "--------------- DONE ----------------\n";
        echo "-------------------------------------\n";
    }

    public function error($msg) {
        echo "Error: $msg\n";
    }
}