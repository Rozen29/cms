<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Setting;

class HomeController
{
	public function index(): void
	{
		$title = 'Beranda';
		$bannerPath = Setting::get('banner_image');
		$bannerCaption = Setting::get('banner_caption') ?? '';
		$view = __DIR__ . '/../../views/home/index.php';
		require __DIR__ . '/../../views/layouts/main.php';
	}
}
