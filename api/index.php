<?php

// Vercel's filesystem is read-only except for /tmp.
$viewPath = '/tmp/laravel-views';

if (! is_dir($viewPath)) {
    mkdir($viewPath, 0777, true);
}

// Tell Laravel where to compile Blade templates.
putenv("VIEW_COMPILED_PATH={$viewPath}");
$_ENV['VIEW_COMPILED_PATH'] = $viewPath;
$_SERVER['VIEW_COMPILED_PATH'] = $viewPath;

// Forward the request to Laravel.
require __DIR__ . '/../public/index.php';
