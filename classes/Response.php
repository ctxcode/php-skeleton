<?php

use Workerman\Protocols\Http\Response as WorkermanResponse;

class Response {

    public $request;
    public $isSent = false;

    private $workermanResponse;

    public function json(array $data) {
        $this->sendHeaders([
            'Content-Type' => 'application/json',
        ]);
        $this->sendBody(json_encode($data));
    }

    public function html(string $html) {
        $this->sendHeaders([
            'Content-Type' => 'text/plain',
        ]);
        $this->sendBody($html);
    }

    public function status(int $code) {

        if ($this->request->source == 'workerman') {
            $res = $this->getWorkermanResponse();
            $res->withStatus($code);
            $this->request->workermanConnection->close($res);
            return;
        }

        http_response_code($code);
        exit;
    }

    public function sendHeaders(array $headers) {

        foreach ($headers as $key => $value) {

            $header = is_int($key) ? $value : ($key . ': ' . $value);

            if ($this->request->source == 'workerman') {
                $res = $this->getWorkermanResponse();
                $res->header($key, $value);
                continue;
            }

            header($header);
        }
    }
    public function sendBody(string $body) {

        $this->isSent = true;

        if ($this->request->source == 'workerman') {
            $res = $this->getWorkermanResponse();
            $res->withBody($body);
            $this->request->workermanConnection->close($res);
            return;
        }

        echo $body;
        exit;
    }

    public function getWorkermanResponse() {
        if (!$this->workermanResponse) {
            $this->workermanResponse = new WorkermanResponse();
        }
        return $this->workermanResponse;
    }
}