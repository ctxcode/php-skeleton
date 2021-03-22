<?php

class Router {

    private $collector;

    public function __construct() {
        $this->collector = new \FastRoute\RouteCollector(
            new \FastRoute\RouteParser\Std,
            new \FastRoute\DataGenerator\MarkBased,
        );
    }

    public function run(\Request $req, \Response $res) {
        $dispatcher = new \FastRoute\Dispatcher\MarkBased($this->collector->getData());

        $routeInfo = $dispatcher->dispatch($req->method, $req->path);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case FastRoute\Dispatcher::FOUND:
                $endpoint = $routeInfo[1];
                $params = $routeInfo[2];

                $path = \Path::get('modules') . '/' . str_replace(".", "/", $endpoint) . '.php';
                if (!file_exists($path)) {
                    throw new \Exception("Endpoint file not found: $path");
                }

                $class = include $path;
                $controller = new $class();
                $controller->run($req, $res);

                break;
        }
    }

    public function add(string $method, string $path, string $endpoint) {
        $this->collector->addRoute($method, $path, $endpoint);
    }

}
