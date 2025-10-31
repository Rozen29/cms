<?php
declare(strict_types=1);
?>
<header class="site-header">
	<div class="container header-inner">
		<div class="brand">
			<a href="/" class="brand-link">
				<span class="brand-title">MIN 1 Pringsewu</span>
			</a>
		</div>
		<nav class="nav">
			<a href="/" class="nav-link">Beranda</a>
			<a href="/news" class="nav-link">Berita</a>
			<?php if (isset($_SESSION['admin_id'])): ?>
				<a href="/admin" class="nav-link">Admin</a>
				<a href="/admin/logout" class="nav-link">Keluar</a>
			<?php else: ?>
				<a href="/admin/login" class="nav-link">Login</a>
			<?php endif; ?>
		</nav>
	</div>
</header>
