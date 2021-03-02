<?php

class Request {

    public $method;
    public $protocol;
    public $domain;
    public $path;
    public $source;
    public $headers = [];

    public $GET = [];
    public $POST = [];
    public string $BODY = "";

    public $workermanRequest;
    public $workermanConnection;

    public $response;

    public $onError;

    private static $METHODS = ['GET', 'POST', 'DELETE', 'PUT', 'PATCH'];
    private static $PROTOCOLS = ['http', 'https'];
    private static $SOURCES = ['workerman', 'fpm', 'cli'];

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
        $this->path = $path;
        $this->source = $source;

        $this->GET = (object) [];
        $this->POST = (object) [];

        $this->response = new \Response();
        $this->response->request = $this;
    }

    public function run() {
        try {
            $middlewares = [
                '\Middleware\Errors',
                '\Middleware\Database',
                '\Middleware\Sessions',
                '\Middleware\Modules',
            ];
            $mwDir = Path::get('middleware');
            foreach ($middlewares as $mw) {
                $mw::run($this, $this->response);
            }
        } catch (\Throwable $t) {

            if (is_callable($this->onError)) {
                call_user_func($this->onError, $this, $t);
            } else {

                if ($this->source == 'workerman') {
                    echo "Error: " . ($t->getMessage()) . "\n";
                }

            }

            $this->response->status(500);
        }
    }

}
