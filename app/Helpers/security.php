<?php
declare(strict_types=1);

namespace App\Security;

use function bin2hex;
use function random_bytes;

function start_secure_session(): void
{
	if (session_status() === PHP_SESSION_ACTIVE) {
		return;
	}
	$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params([
		'lifetime' => 0,
		'path' => $cookieParams['path'] ?? '/',
		'domain' => $cookieParams['domain'] ?? '',
		'secure' => $secure,
		'httponly' => true,
		'samesite' => 'Lax',
	]);
	session_start();
	if (!isset($_SESSION['__created'])) {
		$_SESSION['__created'] = time();
	} elseif (time() - $_SESSION['__created'] > 1800) {
		session_regenerate_id(true);
		$_SESSION['__created'] = time();
	}
}

function csrf_token(): string
{
	if (!isset($_SESSION[\App\CSRF_TOKEN_KEY]) || !is_string($_SESSION[\App\CSRF_TOKEN_KEY])) {
		$_SESSION[\App\CSRF_TOKEN_KEY] = bin2hex(random_bytes(32));
		$_SESSION['__csrf_issued_at'] = time();
	}
	return $_SESSION[\App\CSRF_TOKEN_KEY];
}

function verify_csrf(?string $token): bool
{
	if (!isset($_SESSION[\App\CSRF_TOKEN_KEY], $_SESSION['__csrf_issued_at'])) {
		return false;
	}
	if (!is_string($token)) {
		return false;
	}
	if (time() - (int)$_SESSION['__csrf_issued_at'] > \App\CSRF_TOKEN_TTL) {
		return false;
	}
	return hash_equals($_SESSION[\App\CSRF_TOKEN_KEY], $token);
}

function e(?string $value): string
{
	return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
