<?php

use App\CsrfManager;
use App\FlashMessage;

viewAdd('include/header.php'); ?>

<section class="highlight-section">
	<div class="container">
		<div class="row">
			<div class="col-8">
				<h2 class="mb-4">Lista de Usuários
				</h2>
			</div>
			<div class="col-4 text-right">
				<a href="/user/store" class="btn btn-dark btn-sm">Cadastrar</a>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-12">

				<div class="input-group mb-3">
					<input type="text" id="searchInput" class="form-control" placeholder="Pesquisar por nome ou email" aria-describedby="searchBtn">
					<button class="btn btn-outline-secondary" type="button" id="searchBtn">Pesquisar</button>
				</div>

				<?php
				$response = FlashMessage::get();
				if ($response) {
					echo '<div id="alert" class="mt-2 alert alert-' . ($response['status'] === 'success' ? 'success' : 'danger') . '">' . $response['message'] . '</div>';
				}
				?>

				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Nome</th>
								<th scope="col">E-mail</th>
								<th scope="col">Ações</th>
							</tr>
						</thead>
						<tbody id="userTableBody">
							<?php foreach ($users as $user) : ?>
								<tr>
									<td><?php echo $user['id']; ?></td>
									<td><?php echo $user['name']; ?></td>
									<td><?php echo $user['email']; ?></td>
									<td>
										<div class="btn-group" role="group">
											<a href="user/edit/<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
											<button type="button" class="btn btn-danger btn-sm deleteBtn" data-toggle="modal" data-target="#confirmDeleteModal" data-user-id="<?php echo $user['id']; ?>">Deletar</button>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Tem certeza de que deseja excluir este usuário?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-danger" id="confirmDeleteBtn">Confirmar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	document.getElementById('searchBtn').addEventListener('click', function() {
		var searchInput = document.getElementById('searchInput').value.toLowerCase();
		var userTableBody = document.getElementById('userTableBody');
		var rows = userTableBody.getElementsByTagName('tr');

		for (var i = 0; i < rows.length; i++) {
			var name = rows[i].getElementsByTagName('td')[1].innerText.toLowerCase();
			var email = rows[i].getElementsByTagName('td')[2].innerText.toLowerCase();

			if (name.includes(searchInput) || email.includes(searchInput)) {
				rows[i].style.display = '';
			} else {
				rows[i].style.display = 'none';
			}
		}
	});

	document.addEventListener('DOMContentLoaded', function() {
		var deleteBtns = document.querySelectorAll('.deleteBtn');
		var modalConfirmDelete = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

		deleteBtns.forEach(function(deleteBtn) {
			deleteBtn.addEventListener('click', function() {
				// Obtém o ID do usuário a partir do botão de exclusão
				var userId = deleteBtn.getAttribute('data-user-id');
				console.log(userId);

				// Mostra o modal de confirmação
				modalConfirmDelete.show();

				// Adiciona evento de clique no botão de confirmação no modal
				document.getElementById('confirmDeleteBtn').addEventListener('click', function() {

					// Cria um objeto FormData
					var formData = new FormData();
					formData.append('_method', 'DELETE');
					formData.append('userId', userId);
					formData.append('csrf_token', '<?= CsrfManager::generateToken(); ?>');

					// Faz a solicitação DELETE usando Axios e FormData
					axios.post('/user/delete/' + userId, formData)
						.then(function(response) {
							console.log(response.data);
							if (response.data == 'token not found') return console.log(response.data);

							// Redireciona para a página desejada após a exclusão
							window.location.href = '/';
						})
						.catch(function(error) {
							console.error('Erro durante a exclusão:', error);
						})
						.finally(function() {

							// Esconde o modal de confirmação
							modalConfirmDelete.hide();
						});
				});
			});
		});
	});
</script>

<?php viewAdd('include/footer.php'); ?>