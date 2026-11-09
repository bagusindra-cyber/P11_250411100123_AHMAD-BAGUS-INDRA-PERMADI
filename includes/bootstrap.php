<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$projectRoot = realpath(__DIR__ . '/..');
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
$baseUrl = '';

if ($projectRoot && $documentRoot && str_starts_with($projectRoot, $documentRoot)) {
    $baseUrl = str_replace('\\', '/', substr($projectRoot, strlen($documentRoot)));
}

if (!defined('BASE_URL')) {
    define('BASE_URL', rtrim($baseUrl, '/'));
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/auth.php';
