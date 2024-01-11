<?php

// Função pra pegar uma view
function view($file_path, $params = [])
{
	$path = str_replace("\\", DIRECTORY_SEPARATOR, $file_path);
	$path = str_replace('.', DIRECTORY_SEPARATOR, $path);

	$file = APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $path . '.php';

	if (file_exists($file)) {
		// Extrai os parâmetros para variáveis locais
		extract($params);

		// Inclui a view
		require_once $file;
	} else {
		throw new Exception('Page not found: ' . $file);
	}
}

// Função pra redirecionar
function redirect($url)
{

	header("Location: $url");
	exit();
}

// Função pra adicionar uma view em uma pagina
function viewAdd($file_path)
{
	include(APP_ROOT . '/views/' . $file_path);
}

// Função pra debugar
function dd($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	die();
}
