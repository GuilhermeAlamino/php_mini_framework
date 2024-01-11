<?php

namespace App\Controllers;

use App\Models\User\User;

class SorteioController
{

	public function index()
	{
		$userModel = new User();
		$allUsers = $userModel->all();

		view('sorteio.index', ["users" => $allUsers]);
	}
}
