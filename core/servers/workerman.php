<?php

use Workerman\Worker;

require_once __DIR__ . '/../autoload.php';

// #### http worker ####
$http_worker = new Worker('http://127.0.0.1:8080');

// 4 processes
$http_worker->count = 8;

// Emitted when data received
$http_worker->onMessage = function (Workerman\Connection\TcpConnection $connection, Workerman\Protocols\Http\Request $request) {

    $req = new \Request($request->method(), 'http', 'localhost', $request->path(), 'workerman');
    $req->headers = $request->header();
    $req->GET = $request->get();
    $req->POST = $request->post();
    $req->BODY = $request->rawBody();
    $req->workermanConnection = $connection;

    $req->run();

    if (!$req->response->isSent) {
        $connection->send('No reply from server...');
    }
};

// Run all workers
Worker::runAll();
