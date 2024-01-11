<?php

namespace App\Services;

class Route
{
	private static $routes = [];
	private static $controllerNamespace = 'App\Controllers\\';

	public static function add($uri, $controller, $action, $method = 'GET', $middleware = [])
	{
		self::$routes[] = [
			'method' => strtoupper($method),
			'uri' => $uri,
			'controller' => $controller,
			'action' => $action,
			'middleware' => $middleware
		];
	}

	public static function get($uri, $controller, $action, $middleware = [])
	{
		self::add($uri, $controller, $action, 'GET', $middleware);
	}

	public static function post($uri, $controller, $action, $middleware = [])
	{
		self::add($uri, $controller, $action, 'POST', $middleware);
	}

	public static function put($uri, $controller, $action, $middleware = [])
	{
		self::add($uri, $controller, $action, 'PUT', $middleware);
	}

	public static function delete($uri, $controller, $action, $middleware = [])
	{
		self::add($uri, $controller, $action, 'DELETE', $middleware);
	}

	public static function handle()
	{
		$requestURI = $_SERVER['REQUEST_URI'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];

		// Verifica se o método é PUT ou DELETE quando o campo _method está presente e contém "PUT" ou "DELETE"
		if ($requestMethod === 'POST' && isset($_POST['_method'])) {
			if (strtoupper($_POST['_method']) === 'PUT') {
				$requestMethod = 'PUT';
			} elseif (strtoupper($_POST['_method']) === 'DELETE') {
				$requestMethod = 'DELETE';
			}
		}

		if ($requestURI === '/') {
			redirect('home');
		}

		foreach (self::$routes as $route) {
			$pattern = '/^\/' . str_replace(['{id}', '/'], ['(\d+)', '\/'], $route['uri']) . '$/';

			if (preg_match($pattern, $requestURI, $matches) && $route['method'] == $requestMethod) {
				$routeParams = isset($matches[1]) ? [$matches[1]] : [];

				// handle middleware 
				foreach ($route['middleware'] as $middleware) {
					$middlewareClass = new $middleware;
					$middlewareClass->handle();
				}

				$controllerClass = self::$controllerNamespace . $route['controller'];
				$action = $route['action'];

				$controller = new $controllerClass();
				$controller->$action(...$routeParams);
				return;
			}
		}

		view('404.index');
	}
}
