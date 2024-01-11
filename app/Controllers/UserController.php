<?php

namespace App\Controllers;

use App\CsrfManager;
use App\FlashMessage;
use App\Models\User\User;
use App\Old;

class UserController
{

	public function index()
	{
		$userModel = new User();
		$allUsers = $userModel->all();

		view('users.index', ["users" => $allUsers]);
	}

	public function create()
	{
		view('users.store');
	}

	public function store()
	{
		// Valide o token CSRF recebido do formulário
		$receivedToken = $_POST['csrf_token'] ?? '';
		if (empty(CsrfManager::validateToken($receivedToken))) return view('404.index');

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user = new User;
			$user->name = $_POST['name'];
			$user->email = $_POST['email'];

			$result = $user->create();

			FlashMessage::set($result['status'], $result['message']);

			if ($result['status'] == 'success') {
				redirect('/');
			} else {
				Old::setOld();

				redirect('/user/store');
			}
		}
	}

	public function edit($id)
	{
		$userModel = new User();
		$userData = $userModel->find($id);

		view('users.edit', ["user" => $userData]);
	}

	public function update($id)
	{
		// Valide o token CSRF recebido do formulário
		$receivedToken = $_POST['csrf_token'] ?? '';
		if (empty(CsrfManager::validateToken($receivedToken))) return view('404.index');

		if ($_POST['_method'] === 'PUT') {
			$user = new User;
			$user->id = $_POST['userId'];
			$user->name = $_POST['name'];
			$user->email = $_POST['email'];

			$result = $user->update();

			FlashMessage::set($result['status'], $result['message']);

			if ($result['status'] == 'success') {
				redirect('/');
			} else {
				view('users.edit', ["user" => $user->find($id)]);
			}
		}
	}

	public function delete($id)
	{
		// Valide o token CSRF recebido do formulário
		$receivedToken = $_POST['csrf_token'] ?? '';
		if (empty(CsrfManager::validateToken($receivedToken))) dd('token not found');

		if ($_POST['_method'] === 'DELETE') {
			$user = new User;
			$result = $user->delete($id);

			FlashMessage::set($result['status'], $result['message']);

			echo json_encode(["status" => $result['status'], "message" => $result['message']]);
		}
	}
}
