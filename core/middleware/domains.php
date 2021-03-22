<?php

return function (\Request $req, \Response $res) {

    $conf = \Env::getConfig();
    $aliasses = $conf['domains']['alias'] ?? [];

    // Check aliasses
    foreach ($aliasses as $alias => $domain) {
        if ($req->domain == $alias) {
            $req->domain = $domain;
            break;
        }
    }

    // Check if config file exists
    $path = Path::get('configs') . '/domains/' . str_replace('.', '_', $req->domain) . '.php';
    if (!file_exists($path)) {
        throw new \Exception("Domain config not found for: " . $req->domain);
    }

};
