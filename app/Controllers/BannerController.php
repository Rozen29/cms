<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Setting;
use function App\Security\csrf_token;
use function App\Security\verify_csrf;
use function App\Upload\move_uploaded_image;

class BannerController
{
	private function requireAuth(): void
	{
		if (!isset($_SESSION['admin_id'])) {
			header('Location: /admin/login');
			exit;
		}
	}

	public function editForm(): void
	{
		$this->requireAuth();
		$bannerPath = Setting::get('banner_image');
		$bannerCaption = Setting::get('banner_caption') ?? '';
		$csrf = csrf_token();
		$title = 'Edit Banner';
		$view = __DIR__ . '/../../views/admin/banner_form.php';
		require __DIR__ . '/../../views/layouts/main.php';
	}

	public function update(): void
	{
		$this->requireAuth();
		if (!verify_csrf($_POST['_csrf'] ?? null)) {
			http_response_code(400);
			echo 'Invalid CSRF token';
			return;
		}
		$caption = trim((string)($_POST['caption'] ?? ''));
		$uploaded = null;
		if (!empty($_FILES['banner']['name'] ?? '')) {
			$uploadDir = dirname(__DIR__, 2) . '/public/uploads';
			$uploaded = move_uploaded_image($_FILES['banner'], $uploadDir);
		}
		if ($uploaded) {
			\App\Models\Setting::set('banner_image', '/uploads/' . $uploaded);
		}
		\App\Models\Setting::set('banner_caption', $caption);
		$_SESSION['flash_success'] = 'Banner berhasil diperbarui.';
		header('Location: /admin/banner');
	}
}
