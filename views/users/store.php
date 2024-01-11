<?php

use App\CsrfManager;
use App\FlashMessage;
use App\Old;

viewAdd('include/header.php'); ?>

<section class="highlight-section">
	<div class="container">
		<div class="row">
			<div class="col-8">
				<h2 class="mb-4">Registrar Usuários
				</h2>
			</div>
			<div class="col-4 text-right">
				<a href="/" class="btn btn-dark btn-sm">Voltar</a>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-12">

				<form id="registerForm" action="/user/store" method="POST">
					<input type="hidden" name="csrf_token" value="<?= CsrfManager::generateToken(); ?>">

					<div class="form-group">
						<label for="name">Nome:</label>
						<input type="text" class="form-control" id="name" value="<?= Old::getOld('name') ?>" required placeholder="Digite seu nome" name="name">
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" value="<?= Old::getOld('email') ?>" required placeholder="Digite seu email" name="email">
					</div>

					<button type="submit" id="submitBtn" class="btn btn-primary" disabled>Salvar</button>
					<?php
					$response = FlashMessage::get();
					if ($response) {
						echo '<div id="alert" class="mt-2 alert alert-' . ($response['status'] === 'success' ? 'success' : 'danger') . '">' . $response['message'] . '</div>';
					}
					?>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var nameField = document.getElementById('name');
		var emailField = document.getElementById('email');
		var submitBtn = document.getElementById('submitBtn');

		function validateForm() {
			var nameValue = nameField.value.trim();
			var emailValue = emailField.value.trim();

			submitBtn.disabled = !(nameValue !== '' && emailValue !== '');
		}

		nameField.addEventListener('input', validateForm);
		emailField.addEventListener('input', validateForm);
	});
</script>

<?php viewAdd('include/footer.php'); ?>