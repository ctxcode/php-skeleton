<?php

class Request {

    public $method;
    public $protocol;
    public $domain;
    public $real_domain;
    public $path;
    public $source;
    public $headers = [];

    public $GET = [];
    public $POST = [];
    public string $BODY = "";

    public $workerman_request;
    public $workerman_connection;

    public $response;
    public $router;

    public $on_error;

    private static $METHODS = ['GET', 'POST', 'DELETE', 'PUT', 'PATCH'];
    private static $PROTOCOLS = ['http', 'https'];
    private static $SOURCES = ['workerman', 'fpm', 'cli'];

    public static $middleware_cache = [];
    public static $use_middleware_cahe = true;

    public function __construct($method, $protocol, $domain, $path, $source) {

        if (!in_array($method, static::$METHODS, true)) {
            throw new \Exception('Invalid request method: ' . $method);
        }

        if (!in_array($protocol, static::$PROTOCOLS, true)) {
            throw new \Exception('Invalid request protocol: ' . $protocol);
        }

        if (!in_array($source, static::$SOURCES, true)) {
            throw new \Exception('Invalid request source: ' . $source);
        }

        $this->method = $method;
        $this->protocol = $protocol;
        $this->domain = $domain;
        $this->real_domain = $domain;
        $this->path = $path;
        $this->source = $source;

        $this->GET = (object) [];
        $this->POST = (object) [];

        $this->router = new \Router();

        $this->response = new \Response();
        $this->response->request = $this;
    }

    public function run() {

        try {
            $middlewares = [
                'errors',
                'domains',
                'sessions',
                'modules',
            ];
            $mwDir = Path::get('middleware');
            foreach ($middlewares as $mw) {
                $path = $mwDir . '/' . $mw . '.php';
                if (isset(static::$middleware_cache[$path])) {
                    $mwFunc = static::$middleware_cache[$path];
                } else {
                    $mwFunc = include $path;
                }
                if (static::$use_middleware_cahe) {
                    static::$middleware_cache[$path] = $mwFunc;
                }
                $mwFunc($this, $this->response);

                if ($this->response->is_sent) {
                    return;
                }
            }

            // Handle routing
            $this->router->run($this, $this->response);

        } catch (\Throwable $t) {

            if (is_callable($this->on_error)) {
                call_user_func($this->on_error, $this, $t);
            } else {

                if ($this->source == 'workerman') {
                    echo "Error: " . ($t->getMessage()) . "\n";
                }

            }

            $this->response->status(500);
        }
    }

}
