<?php
declare(strict_types=1);

namespace App\Upload;

function sanitize_filename(string $name): string
{
	$name = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $name) ?? 'file';
	return trim($name, '._') ?: 'file';
}

function is_allowed_image_mime(string $mime): bool
{
	$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
	return in_array($mime, $allowed, true);
}

function move_uploaded_image(array $file, string $destDir, int $maxBytes = 5000000): ?string
{
	if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
		return null;
	}
	if (($file['size'] ?? 0) <= 0 || $file['size'] > $maxBytes) {
		return null;
	}
	$tmp = $file['tmp_name'] ?? '';
	if (!is_uploaded_file($tmp)) {
		return null;
	}
	$finfo = new \finfo(FILEINFO_MIME_TYPE);
	$mime = $finfo->file($tmp) ?: '';
	if (!is_allowed_image_mime($mime)) {
		return null;
	}
	$ext = '';
	switch ($mime) {
		case 'image/jpeg':
			$ext = '.jpg';
			break;
		case 'image/png':
			$ext = '.png';
			break;
		case 'image/gif':
			$ext = '.gif';
			break;
		case 'image/webp':
			$ext = '.webp';
			break;
		default:
			$ext = '';
	}
	$base = pathinfo($file['name'] ?? 'image', PATHINFO_FILENAME);
	$base = sanitize_filename($base);
	$filename = $base . '-' . bin2hex(random_bytes(6)) . $ext;
	$destPath = rtrim($destDir, '/').'/'.$filename;
	if (!move_uploaded_file($tmp, $destPath)) {
		return null;
	}
	@chmod($destPath, 0644);
	return $filename;
}
