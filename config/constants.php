<?php

$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
dd($host,strcmp($host, 'procode.officeos.in'));
if (strcmp($host, '35.208.83.145') == 0 || strcmp($host, 'procode.officeos.in') == 0) {
    return [
        'PRO_CODE_URL' => 'https://aims.officeos.in',
    ];
} else {
    return [
        'PRO_CODE_URL' => 'http://dev.aims.officeos.in',
    ];
}
