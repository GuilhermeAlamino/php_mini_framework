<?php

use App\CsrfManager;
use App\FlashMessage;

viewAdd('include/header.php'); ?>

<section class="highlight-section">
	<div class="container">
		<div class="row">
			<div class="col-8">
				<h2 class="mb-4">Editar Usuário</h2>
			</div>
			<div class="col-4 text-right">
				<a href="/" class="btn btn-dark btn-sm">Home</a>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-12">

				<form id="userForm" action="/user/edit/<?php echo $user['id']; ?>" method="POST">
					<input type="hidden" name="csrf_token" value="<?= CsrfManager::generateToken(); ?>">
					<input type="hidden" name="_method" value="PUT">
					<input type="hidden" id="userId" name="userId" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>">

					<div class="form-group">
						<label for="name">Nome:</label>
						<input type="text" class="form-control" id="name" required placeholder="Digite seu nome" name="name" value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>">
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" required placeholder="Digite seu email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
					</div>

					<button type="submit" id="submitBtn" class="btn btn-primary">Salvar</button>
				</form>

				<?php
				$response = FlashMessage::get();
				if ($response) {
					echo '<div id="alert" class="mt-2 alert alert-' . ($response['status'] === 'success' ? 'success' : 'danger') . '">' . $response['message'] . '</div>';
				}
				?>
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