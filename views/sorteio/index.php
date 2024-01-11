<?php

use App\CsrfManager;
use App\FlashMessage;

viewAdd('include/header.php'); ?>

<section class="highlight-section">
	<div class="container">
		<div class="row">
			<div class="col-8">
				<h2 class="mb-4">Sorteio de Usuários</h2>
			</div>
			<div class="col-4 text-right">
				<a href="/home" class="btn btn-dark btn-sm">Voltar</a>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-12 text-center">

				<?php
				$response = FlashMessage::get();
				if ($response) {
					echo '<div id="alert" class="mt-2 alert alert-' . ($response['status'] === 'success' ? 'success' : 'danger') . '">' . $response['message'] . '</div>';
				}
				?>

				<div class="table-responsive mt-4">
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Resultado</th>
							</tr>
						</thead>
						<tbody id="userTableBody">
							<?php foreach ($users as $user) : ?>
								<tr>
									<td id="result-<?php echo $user['id']; ?>"></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<!-- Elemento de overlay para cobrir a página -->
				<div id="overlay" style="display: none;">
					<div class="spinner-border text-danger" role="status" id="loadingSpinner"></div>
				</div>

				<button class="btn btn-primary mt-3" id="realizarSorteioBtn" onclick="realizarSorteio()">Realizar Sorteio</button>

			</div>
		</div>
	</div>
</section>

<style>
	/* Adicione estilos CSS conforme necessário */
	.table {
		margin-top: 20px;
	}

	th,
	td {
		text-align: center;
	}

	#overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(255, 255, 255, 0.8);
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}

	#loadingSpinner {
		z-index: 1001;
	}

	.btn-primary {
		margin-top: 15px;
	}
</style>

<script>
	function realizarSorteio() {
		// Exibe o overlay com o spinner ao clicar
		const overlay = document.getElementById('overlay');
		overlay.style.display = 'flex';

		const spinner = document.getElementById('loadingSpinner');

		const users = <?php echo json_encode($users); ?>;
		let shuffledUsers = [...users];


		// Embaralha os usuários
		do {
			for (let i = shuffledUsers.length - 1; i > 0; i--) {
				const j = Math.floor(Math.random() * (i + 1));
				[shuffledUsers[i], shuffledUsers[j]] = [shuffledUsers[j], shuffledUsers[i]];
			}
		} while (isCombinationValid(users, shuffledUsers) == false);

		// Exibe o resultado na tabela
		for (let i = 0; i < users.length; i++) {
			const currentUser = users[i];
			const selectedUser = shuffledUsers[i];

			const resultElement = document.getElementById(`result-${currentUser.id}`);
			resultElement.textContent = `■ ${currentUser.name} tirou ${selectedUser.name}`;
		}

		// Oculta o overlay com o spinner após o sorteio
		setTimeout(() => {
			overlay.style.display = 'none';
		}, 1000); // Ajuste o tempo conforme necessário
	}

	// Função para verificar se a combinação é válida
	function isCombinationValid(originalUsers, shuffledUsers) {

		for (let i = 0; i < originalUsers.length; i++) {

			if (originalUsers[i].id === shuffledUsers[i].id) {
				return false; // A combinação não é válida
			}
		}
		return true; // A combinação é válida
	}
</script>

<?php viewAdd('include/footer.php'); ?>