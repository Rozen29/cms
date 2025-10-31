<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use function App\Security\csrf_token;
use function App\Security\verify_csrf;
use function App\Security\e;
use function App\Upload\move_uploaded_image;

class NewsController
{
	private function requireAuth(): void
	{
		if (!isset($_SESSION['admin_id'])) {
			header('Location: /admin/login');
			exit;
		}
	}

	public function index(): void
	{
		$db = Database::getConnection();
		$result = $db->query('SELECT id, title, content, image_path, created_at FROM news ORDER BY created_at DESC LIMIT 50');
		$news = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
		$title = 'Berita';
		$view = __DIR__ . '/../../views/news/index.php';
		require __DIR__ . '/../../views/layouts/main.php';
	}

	public function createForm(): void
	{
		$this->requireAuth();
		$title = 'Tambah Berita';
		$csrf = csrf_token();
		$view = __DIR__ . '/../../views/admin/news_form.php';
		require __DIR__ . '/../../views/layouts/main.php';
	}

	public function create(): void
	{
		$this->requireAuth();
		if (!verify_csrf($_POST['_csrf'] ?? null)) {
			http_response_code(400);
			echo 'Invalid CSRF token';
			return;
		}
		$title = trim((string)($_POST['title'] ?? ''));
		$content = trim((string)($_POST['content'] ?? ''));
		$imageFilename = null;
		if (!empty($_FILES['image']['name'] ?? '')) {
			$uploadDir = dirname(__DIR__, 2) . '/public/uploads';
			$imageFilename = move_uploaded_image($_FILES['image'], $uploadDir);
		}
		if ($title === '' || $content === '') {
			$_SESSION['flash_error'] = 'Judul dan konten wajib diisi.';
			header('Location: /admin/news/create');
			return;
		}
		$db = Database::getConnection();
		if ($imageFilename) {
			$stmt = $db->prepare('INSERT INTO news(title, content, image_path) VALUES(?, ?, ?)');
			$imagePath = '/uploads/' . $imageFilename;
			$stmt->bind_param('sss', $title, $content, $imagePath);
		} else {
			$stmt = $db->prepare('INSERT INTO news(title, content) VALUES(?, ?)');
			$stmt->bind_param('ss', $title, $content);
		}
		$stmt->execute();
		$_SESSION['flash_success'] = 'Berita berhasil ditambahkan.';
		header('Location: /news');
	}

	public function delete(): void
	{
		$this->requireAuth();
		$id = (int)($_GET['id'] ?? 0);
		$token = $_GET['_csrf'] ?? null;
		if (!verify_csrf(is_string($token) ? $token : null)) {
			http_response_code(400);
			echo 'Invalid CSRF token';
			return;
		}
		if ($id > 0) {
			$db = Database::getConnection();
			$stmt = $db->prepare('DELETE FROM news WHERE id = ?');
			$stmt->bind_param('i', $id);
			$stmt->execute();
		}
		header('Location: /news');
	}
}
