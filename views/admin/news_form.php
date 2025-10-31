<?php
declare(strict_types=1);
?>
<h1>Tambah Berita</h1>
<form method="post" action="/admin/news/create" class="form">
	<input type="hidden" name="_csrf" value="<?php echo App\Security\e($csrf); ?>" />
	<div class="form-group">
		<label>Judul</label>
		<input type="text" name="title" required />
	</div>
	<div class="form-group">
		<label>Konten</label>
		<textarea name="content" rows="8" required></textarea>
	</div>
	<button type="submit" class="button">Simpan</button>
</form>
