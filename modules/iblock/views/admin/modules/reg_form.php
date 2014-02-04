<div class = "container">

	<form method="post" action="/admin/login/useradd" class = "form-signin">
		<h2 class = "form-signin-heading">Форма регистрации</h2>
		<input type = "text" name="username" class = "input-block-level" placeholder = "Логин">
		<input type = "text" name="email" class = "input-block-level" placeholder = "Email">
		<input type = "password" name="password" class = "input-block-level" placeholder = "Пароль">
		<input type = "password" name="password_confirm" class = "input-block-level" placeholder = "Подтверждение пароля">
		<label class = "checkbox">
			<input type = "checkbox" name="rem" value = "remember-me"> Remember me
		</label>
		<button class = "btn btn-large btn-primary" type = "submit">Регистрация</button>
	</form>

</div>