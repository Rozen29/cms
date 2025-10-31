<?php
declare(strict_types=1);

// Bootstrap
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Helpers/security.php';
require_once __DIR__ . '/../app/Helpers/upload.php';
require_once __DIR__ . '/../app/Router.php';

// Simple autoloader for App\* classes
spl_autoload_register(function ($class): void {
	if (substr($class, 0, 4) !== 'App\\') {
		return;
	}
	$relative = str_replace('App\\', 'app/', $class);
	$relative = str_replace('\\', '/', $relative) . '.php';
	$file = dirname(__DIR__) . '/' . $relative;
	if (is_file($file)) {
		require_once $file;
	}
});

use App\Router;

App\Security\start_secure_session();

$router = new Router();
$router->get('/', 'HomeController@index');
$router->get('/news', 'NewsController@index');
$router->get('/admin/login', 'AdminController@loginForm');
$router->post('/admin/login', 'AdminController@login');
$router->get('/admin/logout', 'AdminController@logout');
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/news/create', 'NewsController@createForm');
$router->post('/admin/news/create', 'NewsController@create');
$router->get('/admin/news/delete', 'NewsController@delete');
$router->get('/admin/banner', 'BannerController@editForm');
$router->post('/admin/banner', 'BannerController@update');

$router->dispatch();
