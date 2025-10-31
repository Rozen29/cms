<?php
declare(strict_types=1);

namespace App;

class Router
{
	private array $routes = [
		'GET' => [],
		'POST' => [],
	];

	public function get(string $path, string $handler): void
	{
		$this->routes['GET'][$this->normalize($path)] = $handler;
	}

	public function post(string $path, string $handler): void
	{
		$this->routes['POST'][$this->normalize($path)] = $handler;
	}

	public function dispatch(): void
	{
		$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
		$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
		$path = $this->normalize($path);
		$handler = $this->routes[$method][$path] ?? null;
		if (!$handler) {
			http_response_code(404);
			echo '404 Not Found';
			return;
		}
		[$controllerName, $action] = explode('@', $handler, 2);
		$controllerClass = "App\\Controllers\\$controllerName";
		require_once __DIR__ . "/Controllers/$controllerName.php";
		$controller = new $controllerClass();
		$controller->$action();
	}

	private function normalize(string $path): string
	{
		if ($path === '') return '/';
		$path = rtrim($path, '/');
		return $path === '' ? '/' : $path;
	}
}
