<?php
declare(strict_types=1);

$title = $title ?? App\APP_NAME;
$csrf = $csrf ?? null;
?><!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo App\Security\e($title) . ' - ' . App\Security\e(App\APP_NAME); ?></title>
	<link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
	<?php require __DIR__ . '/../partials/header.php'; ?>
	<main class="container">
		<?php if (!empty($_SESSION['flash_error'])): ?>
			<div class="alert alert-error"><?php echo App\Security\e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
		<?php endif; ?>
		<?php if (!empty($_SESSION['flash_success'])): ?>
			<div class="alert alert-success"><?php echo App\Security\e($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
		<?php endif; ?>
		<?php require $view; ?>
	</main>
	<?php require __DIR__ . '/../partials/footer.php'; ?>
	<script src="/assets/js/main.js"></script>
</body>
</html>
