<?php

include __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class_name) {

    $fn = str_replace('\\', '/', $class_name);

    $file = __DIR__ . '/../classes/' . $fn . '.php';
    if (file_exists($file)) {
        include $file;
        return;
    }
    $file = __DIR__ . '/../models/' . $fn . '.php';
    if (file_exists($file)) {
        include $file;
        return;
    }
    $file = __DIR__ . '/../modules/' . $fn . '.php';
    if (file_exists($file)) {
        include $file;
        return;
    }
});
