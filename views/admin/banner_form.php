<?php
declare(strict_types=1);
?>
<h1>Edit Banner</h1>
<form class="form" method="post" action="/admin/banner" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?php echo App\Security\e($csrf); ?>" />
	<div class="form-group">
		<label>Gambar Banner (JPG/PNG/WEBP, maks 5MB)</label>
		<input type="file" name="banner" accept="image/*" />
	</div>
	<?php if (!empty($bannerPath)): ?>
		<div class="form-group">
			<label>Pratinjau Saat Ini</label>
			<div class="banner" style="max-width: 700px;">
				<img src="<?php echo App\Security\e($bannerPath); ?>" alt="Banner" />
			</div>
		</div>
	<?php endif; ?>
	<div class="form-group">
		<label>Teks Caption</label>
		<input type="text" name="caption" value="<?php echo App\Security\e($bannerCaption ?? ''); ?>" />
	</div>
	<button class="button" type="submit">Simpan</button>
</form>
