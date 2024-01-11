# Estrutura PHP Mini Framework

Desenvolvi está estrutura pra usar em projetos simples, existe algumas versões melhorada pra ele mas possui Padrão MVC para a construção de aplicações web.

## Características

## 1. Rotas

Exemplo de como você pode definir rotas:

```php

Route::get('user', 'UserController', 'index', [Guest::class]);
Route::get('user/show/{id}', 'UserController', 'show', [Guest::class]);
Route::get('user/edit/{id}', 'UserController', 'edit', [Guest::class]);
Route::put('user/edit/{id}', 'UserController', 'update', [Guest::class]);
Route::delete('user/delete/{id}', 'UserController', 'delete', [Guest::class]);

```

## 2. Middlewares

Exemplo de como você pode usar Middlewares:

```php

Route::get('user', 'UserController', 'index', [Guest::class, Auth::class]);

```
Podera ajustar a regra que quiser nos Middlewares exemplo:

```php

class Guest
{
	public function handle()
	{
		if (isset($_SESSION['user_id'])) {
			redirect('home');
			exit();
		}
	}
}

```

## 3. Models

Criei um facilitador para criação das Models, Exemplo de como você pode criar Models:

```php

php artisan make:model User/User

php artisan make:model User

```

Exemplo de como você pode usar as Models:

```php

namespace App\Models\User;

use App\Models\Model;
use PDO;

class User extends Model
{
	private $table_name = "users";

	public function all()
	{
		$query = "SELECT * FROM " . $this->table_name;
		$stmt = $this->conn->query($query);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

```

## 4. Controllers

Criei um facilitador para criação dos Controllers, Exemplo de como você pode criar Controllers:

```php

php artisan make:controller User/User

php artisan make:controller User

```

Exemplo de como você pode usar os Controllers:

```php

namespace App\Controllers;

use App\Models\User\User;

class UserController
{

	public function index()
	{
		$userModel = new User();
		$allUsers = $userModel->all();

		view('users.index', ["users" => $allUsers]);
	}
}

```

## 5. Database

Crie um banco de dados e passe as configurações aqui app/Config/Database:

```php

private $host = 'localhost';
private $db_name = 'logsmart';
private $username = 'root';
private $password = '';

```

## 6. Arquivo na raiz do projeto script.db

Executar SQL DDL:

```php

CREATE DATABASE IF NOT EXISTS logsmart CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE logsmart;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'Identificador da tabela de usuários',
    name VARCHAR(255) NOT NULL COMMENT 'Nome do usuário',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Endereço de email do usuário (único)',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Data em que o usuário foi criado no banco, default de acordo com o date do database no servidor',
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP COMMENT 'Data em que o usuário foi alterado',
    deleted_at DATETIME COMMENT 'Coluna criada para tratar soft delete. Data em que o usuário foi "removido" da base',
    PRIMARY KEY (id)
) ENGINE=INNODB;

```

## Próximos Passos (melhorias/alternativas)

- Funcionalidade de Busca de pessoas -> Se tiver dados extremamente grandes, a filtragem no lado do cliente pode consumir muito recursos do navegador e não existe uma lógica de filtragem e a exibição dos dados, entretanto pensei em desempenho inicial e redução do tráfego de rede.

- Migrações -> Pra facilitar no controle de versão do banco de dados, possibilidade de rollback de migrações, historico de mudanças, facilidade pra instalar e subir as tabelas e criação e etc.

- Cache -> Melhoria em Desempenho.

- Query Builder -> Abstração do SQL, Consulta fluente, Padrão de design.

- Model -> Implementar recurso de ORM, termos de organização e manutenção do código.

##  Requisitos

- PHP ^7.4
- Composer
- Mysql

## Recursos

- Javascript Vanilla;
- FormData;
- Jquery;
- Axios;
- PSR-4;
- Bootstrap;
- SQL

## Instalar Projeto e Dependências

```sh

git clone https://github.com/GuilhermeAlamino/php_mini_framework.git

cd php_mini_framework

composer install

php -S localhost:8001

http://localhost:8001

```

