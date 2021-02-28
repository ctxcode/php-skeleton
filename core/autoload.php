<?php

include __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/../classes/' . $class_name . '.php';
    if (file_exists($file)) {
        include $file;
        return;
    }
    $file = __DIR__ . '/../models/' . $class_name . '.php';
    if (file_exists($file)) {
        include $file;
        return;
    }
    $file = __DIR__ . '/../modules/' . $class_name . '.php';
    if (file_exists($file)) {
        include $file;
        return;
    }
});
