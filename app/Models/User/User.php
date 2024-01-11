<?php

namespace App\Models\User;

use App\Models\Model;
use PDO;

class User extends Model
{
	private $table_name = "users";
	public $id;
	public $name;
	public $email;

	public function all()
	{
		$query = "SELECT * FROM " . $this->table_name;
		$stmt = $this->conn->query($query);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function find($id)
	{
		$query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':id', $id);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function create()
	{

		$query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':email', $this->email);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return ['status' => 'danger', 'message' => 'E-mail já em uso. Escolha outro e-mail.'];
		}

		$query = "INSERT INTO " . $this->table_name . " (name,email) VALUES (:name,:email)";
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':email', $this->email);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Usúario criado com sucesso.'];
		} else {
			return ['status' => 'danger', 'message' => 'Falha no registro. Por favor, tente novamente.'];
		}
	}

	public function update()
	{
		if (!$this->id) {
			return ['status' => 'danger', 'message' => 'ID do usuário não fornecido para a atualização.'];
		}

		$query = "SELECT * FROM " . $this->table_name . " WHERE email = :email AND id != :id";
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return ['status' => 'danger', 'message' => 'E-mail já em uso por outro usuário. Escolha outro e-mail.'];
		}

		$query = "UPDATE " . $this->table_name . " SET name = :name, email = :email WHERE id = :id";
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Usúario atualizado com sucesso.'];
		} else {
			return ['status' => 'danger', 'message' => 'Falha na atualização do usuário. Por favor, tente novamente.'];
		}
	}

	public function delete($id)
	{
		$query = "DELETE FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':id', $id);

		if ($stmt->execute()) {
			return ['status' => 'danger', 'message' => 'Usúario deletado com sucesso.'];
		} else {
			return ['status' => 'danger', 'message' => 'Falha na atualização do usuário. Por favor, tente novamente.'];
		}
	}
}
