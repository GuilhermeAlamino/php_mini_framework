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

## Próximos Passos (melhorias/alternativas)

- Funcionalidade de Busca de pessoas -> Se tiver dados extremamente grandes, a filtragem no lado do cliente pode consumir muito recursos do navegador e não existe uma lógica de filtragem e a exibição dos dados, entretanto pensei em desempenho inicial e redução do tráfego de rede.

- Migrações -> Pra facilitar no controle de versão do banco de dados, possibilidade de rollback de migrações, historico de mudanças, facilidade pra instalar e subir as tabelas e criação e etc.

- Cache -> Melhoria em Desempenho.

- Query Builder -> Abstração do SQL, Consulta fluente, Padrão de design.

- Model -> Implementar recurso de ORM, termos de organização e manutenção do código.

##  Requisitos

- PHP ^7.4
- Composer

## Recursos

- Javascript Vanilla;
- FormData;
- Jquery;
- Axios;
- PSR-4;
- Bootstrap;

## Instalar Projeto e Dependências

```sh

git clone https://github.com/GuilhermeAlamino/php_mini_framework.git

cd php_mini_framework

composer install

php -S localhost:8001

http://localhost:8001

```

