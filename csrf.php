<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['csrf_token' => csrf_token()], JSON_THROW_ON_ERROR);
