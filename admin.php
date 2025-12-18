<?php

header("Content-Type: text/plain; charset=utf-8");
header("X-Admin-Service: INTERNAL");

function line($text = '') {
    echo $text . "\n";
}

$headers = getallheaders();
$smuggled = false;

line("[+] Incoming Headers");
line("----------------------------------------");

foreach ($headers as $name => $value) {
    line($name . ": " . $value);

    if (
        strtolower($name) === 'x-smuggled' ||
        strtolower($name) === 'x-internal-request' ||
        stripos($value, 'smuggle') !== false
    ) {
        $smuggled = true;
    }
}

line();

if ($smuggled) {
    $flag = "ADMIN_SMUGGLE_SUCCESS_" . hash(
        'sha256',
        $_SERVER['REMOTE_ADDR'] . microtime(true)
    );

    line("[!] SMUGGLED REQUEST CONFIRMED");
    line("----------------------------------------");
    line("Access granted via HTTP Request Smuggling");
    line();
    line("FLAG: " . $flag);
    exit;
}

// Direct access restriction
$ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

line("[!] ACCESS CONTROL");
line("----------------------------------------");

if ($ip === '127.0.0.1' || $ip === '::1') {
    line("[i] Localhost access detected");
    line("FLAG: LOCALHOST_BYPASS_" . hash('md5', time()));
    exit;
}

line("Access denied.");
line("This endpoint is intended to be reached via a smuggled request only.");
line("Your IP: " . $ip);

http_response_code(403);
