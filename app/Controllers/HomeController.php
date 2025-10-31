<?php
declare(strict_types=1);

namespace App\Controllers;

use function App\Security\e;

class HomeController
{
	public function index(): void
	{
		$title = 'Beranda';
		$view = __DIR__ . '/../../views/home/index.php';
		require __DIR__ . '/../../views/layouts/main.php';
	}
}
