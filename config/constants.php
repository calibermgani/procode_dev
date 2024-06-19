
<?php

$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
echo 'Host: ' . $host . PHP_EOL;

if ($host === '35.208.83.145' || $host === 'procode.officeos.in') {
    $url = 'https://aims.officeos.in';
} else {
    $url = 'http://dev.aims.officeos.in/'; // Change this to the appropriate URL
}

echo 'PRO_CODE_URL: ' . $url . PHP_EOL;

return [
    'PRO_CODE_URL' => $url,
];
