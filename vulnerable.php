<?php
header("Content-Type: text/plain; charset=utf-8");
header("X-Lab-Mode: HTTP-Smuggling");
header("X-Vulnerability: CL-TE");

function line($text = "") {
    echo $text . "\n";
}

line("========================================");
line(" HTTP REQUEST SMUGGLING LAB - VULNERABLE ");
line("========================================");
line();

line("[+] Request Metadata");
line("----------------------------------------");
line("Method              : " . $_SERVER['REQUEST_METHOD']);
line("Request URI         : " . $_SERVER['REQUEST_URI']);
line("Protocol            : " . $_SERVER['SERVER_PROTOCOL']);
line("Client IP           : " . ($_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN'));
line();

$cl = $_SERVER['HTTP_CONTENT_LENGTH'] ?? null;
$te = $_SERVER['HTTP_TRANSFER_ENCODING'] ?? null;

line("[+] Header Analysis");
line("----------------------------------------");
line("Content-Length      : " . ($cl ?? "NOT PRESENT"));
line("Transfer-Encoding   : " . ($te ?? "NOT PRESENT"));
line();

$rawBody = file_get_contents("php://input");
$bodyLength = strlen($rawBody);

line("[+] Raw Request Body");
line("----------------------------------------");
line("Total bytes received: {$bodyLength}");
line();

if ($bodyLength > 0) {
    $preview = substr($rawBody, 0, 600);
    line($preview);
    if ($bodyLength > 600) {
        line("...[truncated]");
    }
}
line();

if ($cl !== null && $te !== null) {

    line("[!] VulnerABILITY IDENTIFIED");
    line("----------------------------------------");
    line("Conflicting headers detected:");
    line("- Front-end uses Content-Length");
    line("- Back-end uses Transfer-Encoding");
    line();

    $cl = (int)$cl;

    $frontendView = substr($rawBody, 0, $cl);
    $backendView  = substr($rawBody, $cl);

    line("[>] Front-End Interpretation (CL-based)");
    line("----------------------------------------");
    line("Processed bytes: {$cl}");
    line($frontendView);
    line();

    line("[>] Back-End Queue (Smuggled Data)");
    line("----------------------------------------");

    if (strlen($backendView) > 0) {
        line($backendView);
        line();
        line("[!] Potential request smuggling payload detected");
        line("    Data after CL may be interpreted as a new request");
    } else {
        line("No remaining data detected");
    }

} else {
    line("[i] No vulnerability triggered");
    line("    Both Content-Length and Transfer-Encoding headers are required");
}

line();
line("========================================");
line(" End of analysis");
line("========================================");

flush();
