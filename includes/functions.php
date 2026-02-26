<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function db(): mysqli
{
    static $conn = null;

    if ($conn instanceof mysqli) {
        return $conn;
    }

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        http_response_code(500);
        die('Database connection failed.');
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['csrf_token'];
}

function csrf_verify(?string $submitted): void
{
    $token = (string) ($_SESSION['csrf_token'] ?? '');
    if (!$submitted || !$token || !hash_equals($token, $submitted)) {
        http_response_code(400);
        die('Invalid CSRF token.');
    }
}

function is_valid_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function normalize_phone(string $phone): string
{
    return preg_replace('/[^0-9+]/', '', $phone) ?? '';
}
