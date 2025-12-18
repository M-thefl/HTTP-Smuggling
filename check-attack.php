<?php
session_start();

define('LOG_FILE', __DIR__ . '/attack_log.txt');

function log_line($text = '') {
    file_put_contents(LOG_FILE, $text . PHP_EOL, FILE_APPEND);
}

log_line("========================================");
log_line("Timestamp      : " . date('Y-m-d H:i:s'));
log_line("Client IP      : " . ($_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN'));
log_line("Request        : " . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI']);

log_line("---- Headers ----");
$headers = getallheaders();
foreach ($headers as $name => $value) {
    log_line($name . ": " . $value);
}

$body = file_get_contents('php://input');
log_line("---- Body (" . strlen($body) . " bytes) ----");
log_line($body ?: '[EMPTY]');
log_line("----------------------------------------");

// Detection logic
if (
    isset($_SERVER['HTTP_X_SMUGGLED']) ||
    isset($_SERVER['HTTP_X_INTERNAL_REQUEST']) ||
    stripos(json_encode($headers), 'smuggle') !== false
) {
    $flag = "SMUGGLE_DETECTED_" . hash('sha256', session_id() . microtime(true));

    log_line("[!] SMUGGLING DETECTED");
    log_line("Flag: " . $flag);
    log_line("========================================");

    header("Content-Type: text/plain");
    header("X-Smuggling-Status: CONFIRMED");

    echo "SMUGGLING CONFIRMED\n";
    echo "Flag: {$flag}\n";
    exit;
}

log_line("[i] No smuggling indicators detected");
log_line("========================================");

header("Content-Type: text/plain");
echo "Request logged. No smuggling indicators found.\n";
