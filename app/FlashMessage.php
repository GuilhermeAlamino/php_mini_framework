<?php

namespace App;

class FlashMessage
{
	public static function set($status, $message)
	{
		$_SESSION['flash_message'] = ['status' => $status, 'message' => $message];
		return $_SESSION['flash_message'];
	}

	public static function get()
	{
		if (isset($_SESSION['flash_message'])) {
			$message = $_SESSION['flash_message'];
			unset($_SESSION['flash_message']);
			return $message;
		}

		return null;
	}
}
