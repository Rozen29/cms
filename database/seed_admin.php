<?php
declare(strict_types=1);

// Run from project root: php database/seed_admin.php

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/Database.php';

use App\Database;

if (php_sapi_name() !== 'cli') {
	fwrite(STDERR, "This script must be run from CLI.\n");
	exit(1);
}

$email = $argv[1] ?? 'admin@min1pringsewu.sch.id';
$password = $argv[2] ?? 'admin123';

$db = Database::getConnection();
$stmt = $db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->fetch_assoc()) {
	fwrite(STDOUT, "User already exists: $email\n");
	exit(0);
}
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $db->prepare('INSERT INTO users(email, password_hash) VALUES(?, ?)');
$stmt->bind_param('ss', $email, $hash);
if ($stmt->execute()) {
	fwrite(STDOUT, "Admin created: $email\n");
	exit(0);
}

fwrite(STDERR, "Failed to create admin.\n");
exit(1);
