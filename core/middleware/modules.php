<?php

return function ($req, $res) {

    $conf = \Config::load('domains/' . str_replace('.', '_', $req->domain) . '.php');

    $modules = $conf['modules'] ?? [];

    // Load modules
    foreach ($modules as $mod) {
        // Routes
        $routes_path = Path::get('modules') . "/$mod/routes.php";
        if (file_exists($routes_path)) {
            $routes = include $routes_path;
            foreach ($routes as $route) {
                $req->router->add($route[0], $route[1], $mod . '.endpoints.' . $route[2]);
            }
        }
    }

};
