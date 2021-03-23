<?php

class Path {

    public static function get($name) {
        $root = realpath(__DIR__ . '/../');
        switch ($name) {
            case "root":
                return $root;
                break;
            case "configs":
                return $root . "/configs";
                break;
            case "classes":
                return $root . "/classes";
                break;
            case "models":
                return $root . "/models";
                break;
            case "structs":
                return $root . "/structs";
                break;
            case "storage":
                return $root . "/storage";
                break;
            case "cache":
                return $root . "/storage/cache";
                break;
            case "public":
                return $root . "/public";
                break;
            case "modules":
                return $root . "/modules";
                break;
            case "core":
                return $root . "/core";
                break;
            case "middleware":
                return $root . "/core/middleware";
                break;
            case "servers":
                return $root . "/servers";
                break;
        }

        throw new \Exception('Unknown path: ' . $name);
    }

}
