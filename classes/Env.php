<?php

class Env {

    public static $config_cache;

    public static function getConfig() {
        if (static::$config_cache) {
            return static::$config_cache;
        }
        $path = Path::get("root") . '/env.json';
        if (!file_exists($path)) {
            throw new \Exception("Please create an \"env.json\" file in the root directory");
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid json syntax was used in env.json, json_decode failed");
        }
        static::$config_cache = $data;
        return $data;
    }

    public static function isDebug() {
        $conf = static::getConfig();
        return $conf['environment']['debug'] ?? false;
    }

}