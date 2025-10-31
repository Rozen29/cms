<?php
declare(strict_types=1);
/** @var array $news */
?>
<h1>Berita Terbaru</h1>
<?php if (isset($_SESSION['admin_id'])): ?>
	<p><a class="button" href="/admin/news/create">+ Tambah Berita</a></p>
<?php endif; ?>
<div class="news-list">
	<?php if (empty($news)): ?>
		<p>Belum ada berita.</p>
	<?php else: ?>
		<?php foreach ($news as $item): ?>
			<article class="news-item">
				<h2><?php echo App\Security\e($item['title']); ?></h2>
				<p class="meta">Diposting: <?php echo App\Security\e($item['created_at']); ?></p>
				<p><?php echo nl2br(App\Security\e(mb_strimwidth($item['content'], 0, 300, '...'))); ?></p>
				<?php if (isset($_SESSION['admin_id'])): ?>
					<a class="link-danger" href="/admin/news/delete?id=<?php echo (int)$item['id']; ?>&amp;_csrf=<?php echo App\Security\e(App\Security\csrf_token()); ?>">Hapus</a>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
