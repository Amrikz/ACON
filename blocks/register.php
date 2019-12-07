<?php 
//WORK
/*
	if($_POST['register']){
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$password1 = mysqli_real_escape_string($dbc, trim($_POST['password']));
		$password2 = mysqli_real_escape_string($dbc, trim($_POST['confirmPassword']));
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		if(!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2) && !empty($email)) {
			$query = "SELECT * FROM `signup` WHERE username = '$username'";
			$data = mysqli_query($dbc, $query);
			if(mysqli_num_rows($data) == 0) {
				//$query ="INSERT INTO `signup` (username, password) VALUES ('$username', SHA('$password2'))";
				//INSERT INTO `users` (`id`, `username`, `password`, `level`) VALUES (NULL, 'rikz', 'X���j��', '1');
				$query = "SELECT * FROM `users`";
				mysqli_query($dbc,$query);
				echo 'Всё готово, можете авторизоваться,вернитесь на главную страницу';
				mysqli_close($dbc);
				exit();
			}
			else {
				echo 'Логин уже существует';
			}
		}
		else{
		echo "<p id='about'>Пожалуйста,заполните поля</p>";
		}
	}
	*/

	if (!$_SESSION['user_id']){
		?>
		<form method="post" id="registrationForm">
			<label class="registrationLabels">Имя пользователя</label>
			<input type="text" name="username" placeholder="..." class="registrationInputs" maxlength="30">
			<label class="registrationLabels">Пароль</label>
			<input type="password" name="password" placeholder="..." class="registrationInputs" maxlength="60">
			<label class="registrationLabels">Подтверждение пароля</label>
			<input type="password" name="confirmPassword" placeholder="..." class="registrationInputs" maxlength="60">
			<label class="registrationLabels">Электронная почта</label>
			<input type="email" name="email"  class="registrationInputs" placeholder="...">
			<input type="submit" name="register" value="Зарегистрироваться" id="registrationButton">
		</form>
		<?php
	}
	else{
		echo "<p id='about'>Вы уже вошли в аккаунт,зачем вам регистрация?</p>";
	}
?>
