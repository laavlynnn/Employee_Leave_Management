
<?php

// Vercel allows temporary writes in /tmp.
$viewPath = '/tmp/laravel-views';

if (! is_dir($viewPath)) {
    mkdir($viewPath, 0777, true);
}

putenv("VIEW_COMPILED_PATH={$viewPath}");
$_ENV['VIEW_COMPILED_PATH'] = $viewPath;
$_SERVER['VIEW_COMPILED_PATH'] = $viewPath;

// Create the Aiven CA certificate from a Base64 environment variable.
$certificateBase64 = getenv('AIVEN_CA_CERT_BASE64');

if ($certificateBase64 !== false && $certificateBase64 !== '') {
    $certificate = base64_decode($certificateBase64, true);

    if ($certificate === false || $certificate === '') {
        http_response_code(500);
        exit('Database SSL certificate configuration is invalid.');
    }

    $certificatePath = '/tmp/aiven-ca.pem';

    if (file_put_contents($certificatePath, $certificate) === false) {
        http_response_code(500);
        exit('Could not prepare the database SSL certificate.');
    }

    putenv("MYSQL_ATTR_SSL_CA={$certificatePath}");
    $_ENV['MYSQL_ATTR_SSL_CA'] = $certificatePath;
    $_SERVER['MYSQL_ATTR_SSL_CA'] = $certificatePath;
}

// Forward the request to Laravel.
require __DIR__ . '/../public/index.php';
