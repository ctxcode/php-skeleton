<?php

namespace DB;

class Connection {

    private $model_namespace;

    private static $pool;

    public static function instance($name) {

        $connection = static::getFromPool($name);
        if ($connection) {
            return $connection;
        }

        // Get connection instance
        $env = \Env::getConfig();
        $dbs = $env['databases'] ?? [];
        if (!isset($dbs[$name])) {
            throw new \Exception("No databases in env.json named: $name");
        }
        $settings = $dbs[$name];
        if (!isset($settings['type'])) {
            throw new \Exception("Missing 'type' parameter in database settings (env.json)");
        }
        $type = $settings['type'];
        $connection = null;
        switch ($type) {
            case 'mysql':
                $connection = new \DB\Connection\Mysql($settings);
                break;
            default:
                throw new \Exception("Unknown database type \"$type\" in env.json");
                break;
        }

        if (!$connection) {
            // You could throw an error here.
            return null;
        }

        $config = \Config::load('databases');
        $connection->model_namespace = $config[$name]['models']['namespace'] ?? '';

        return $connection;
    }

    public static function getFromPool($name) {

        if (!isset(static::$pool[$name])) {
            return null;
        }

        return array_pop(static::$pool[$name]);
    }

    //
    public function __get($name) {
        // Shortcut function for model queries
        $model = $this->model_namespace . $name;
        return $model::query($this);
    }
}