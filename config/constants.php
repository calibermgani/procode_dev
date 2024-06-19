<?php

$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

if (php_sapi_name() == 'cli') {
    // Set default value for CLI context
    $host = 'localhost';
} else {
    // In web context, use the actual HTTP_HOST
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
}
echo 'Host: ' . $host . PHP_EOL;
if ($host === '35.208.83.145' || $host === 'procode.officeos.in') {
    return [
        'PRO_CODE_URL' => 'https://aims.officeos.in',
    ];
} else {
    return [
        'PRO_CODE_URL' => 'http://dev.aims.officeos.in', // Change this to the appropriate URL
    ];
}
