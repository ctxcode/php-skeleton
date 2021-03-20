<?php

// Test if configs have the correct structure

return function (\Test $test) {

    $test->start("Test configs by struct");

    $struct = \S::load('configs.domain');
    $domains = glob(Path::get('configs') . '/domains/*.php');

    foreach ($domains as $domainFile) {
        $config = include $domainFile;
        if (!$struct->validate($config, $errors)) {
            foreach ($errors as $error) {
                $test->error($error);
                continue;
            }
        }
    }

    $test->finish();
};