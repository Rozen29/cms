<?php
declare(strict_types=1);
?>
<h1>Login Admin</h1>
<form method="post" action="/admin/login" class="form">
	<input type="hidden" name="_csrf" value="<?php echo App\Security\e($csrf); ?>" />
	<div class="form-group">
		<label>Email</label>
		<input type="email" name="email" required />
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" name="password" required />
	</div>
	<button type="submit" class="button">Masuk</button>
</form>
