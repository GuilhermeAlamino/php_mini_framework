<?php

namespace App;

class Old
{
	// Função pra armazenar os dados antigos
	public static function setOld()
	{
		$_SESSION['old'] = $_POST ?? [];
	}

	// Função pra obter dados antigos de um índice específico
	public static function getOld($index)
	{
		if (isset($_SESSION['old'][$index])) {
			$old = $_SESSION['old'][$index];
			unset($_SESSION['old'][$index]);
			return htmlspecialchars($old);
		}
		return '';
	}
}
