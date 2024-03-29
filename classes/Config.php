<?php

class Config {

    public static function load(string $name) {

        $path = Path::get('configs') . "/$name";
        if (!file_exists($path)) {
            throw new \Exception("Config not found: " . $name);
        }
        return include $path;

    }

}