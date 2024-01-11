<?php

namespace App\Middleware;

class Auth
{
	public function handle()
	{
		if (!isset($_SESSION['user_id'])) {
			view('404.index');
			exit();
		}
	}
}
