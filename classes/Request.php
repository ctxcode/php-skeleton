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
    }

    public function run() {
        try {
            $middlewares = [
                'database',
                'sessions',
                'modules',
            ];
            $mwDir = Path::get('middleware');
            foreach ($middlewares as $mwFile) {
                include $mwDir . '/' . $mwFile . '.php';
            }
        } catch (\Throwable $t) {

            $this->response->status(500);

        }
    }

}
