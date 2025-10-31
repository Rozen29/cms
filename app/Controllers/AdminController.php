<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use function App\Security\csrf_token;
use function App\Security\verify_csrf;
use function App\Security\e;

class AdminController
{
	private function requireAuth(): void
	{
		if (!isset($_SESSION['admin_id'])) {
			header('Location: /admin/login');
			exit;
		}
	}

	public function loginForm(): void
	{
		if (isset($_SESSION['admin_id'])) {
			header('Location: /admin');
			exit;
		}
		$title = 'Login Admin';
		$csrf = csrf_token();
		$view = __DIR__ . '/../../views/admin/login.php';
		require __DIR__ . '/../../views/layouts/main.php';
	}

	public function login(): void
	{
		if (!verify_csrf($_POST['_csrf'] ?? null)) {
			http_response_code(400);
			echo 'Invalid CSRF token';
			return;
		}
		$email = trim((string)($_POST['email'] ?? ''));
		$password = (string)($_POST['password'] ?? '');
		$db = Database::getConnection();
		$stmt = $db->prepare('SELECT id, password_hash FROM users WHERE email = ? LIMIT 1');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
		if ($user && password_verify($password, $user['password_hash'])) {
			$_SESSION['admin_id'] = (int)$user['id'];
			session_regenerate_id(true);
			header('Location: /admin');
			return;
		}
		$_SESSION['flash_error'] = 'Email atau password salah.';
		header('Location: /admin/login');
	}

	public function logout(): void
	{
		unset($_SESSION['admin_id']);
		session_regenerate_id(true);
		header('Location: /admin/login');
	}

	public function dashboard(): void
	{
		$this->requireAuth();
		$title = 'Dashboard Admin';
		$view = __DIR__ . '/../../views/admin/dashboard.php';
		require __DIR__ . '/../../views/layouts/main.php';
	}
}
