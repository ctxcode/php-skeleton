<?php

// Run tests
$testsDir = Path::get('tests');
$tests = [];

// Load all
$files = glob($testsDir . '/*/*.php');
foreach ($files as $file) {
    $path = realpath($file);
    $tests[] = $path;
}

// Filter dupes
$tests = array_unique($tests);

// Run
$db = null;

foreach ($tests as $file) {

    $test = new \Test();
    $test->stop_on_error = false;

    $func = include $file;
    $func($current_test);

}
