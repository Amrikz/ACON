<?php 
//WORK
$namelimiter = 30;
$passlimiter = 60;
$maillimiter = 80;

	if($_POST['register']){
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$password1 = mysqli_real_escape_string($dbc, trim(crypt($_POST['password'],'$1$'.$_POST['password'].'$')));
		$password2 = mysqli_real_escape_string($dbc, trim(crypt($_POST['confirmPassword'],'$1$'.$_POST['confirmPassword'].'$')));
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		if (iconv_strlen($username) <= $namelimiter && iconv_strlen($_POST['password']) <= $passlimiter && iconv_strlen($email) <= $maillimiter) {
			if(!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2) && !empty($email)) {
				$password1 = substr($password1, 12); 
				$query = "SELECT * FROM `users` WHERE username = '$username'";
				$data = mysqli_query($dbc, $query); //Начало хэша с 12 строки (Теперь без спойлеров!)
				if(mysqli_num_rows($data) == 0) {
					$query = "INSERT INTO `users` (`id`, `username`, `password`, `email` , `level`) VALUES (NULL, '$username', '$password1', SHA('$email') , '3')";
					mysqli_query($dbc,$query);
					$query = "SELECT id,username FROM `users` WHERE username = '$username'";
					$data = mysqli_query($dbc, $query);
					$row = mysqli_fetch_array($data);
					$_SESSION['user_id'] = $row['id'];
	        		$_SESSION['user_username'] = $row['username'];
	        		echo "<p id='about'>Регистрация завершена успешно!</p>";
					mysqli_close($dbc);
					$mainRedirect = '1';
					exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
				}
				else {
					echo "<p id='about'>Логин уже существует</p>";
				}
			}
			else{
			echo "<p id='about'>Пожалуйста,заполните поля правильно</p>";
			}
		}
		else{
			echo "<p id='ban'>HACKER</p>";
		}
	}

	if (!$_SESSION['user_id']){
		?>
		<form method="post" id="registrationForm">
			<label class="registrationLabels">Имя пользователя</label>
			<input type="text" name="username" placeholder="..." class="registrationInputs" maxlength="<?=$namelimiter?>">
			<label class="registrationLabels">Пароль</label>
			<input type="password" name="password" placeholder="..." class="registrationInputs" maxlength="<?=$passlimiter?>">
			<label class="registrationLabels">Подтверждение пароля</label>
			<input type="password" name="confirmPassword" placeholder="..." class="registrationInputs" maxlength="<?=$passlimiter?>">
			<label class="registrationLabels">Электронная почта</label>
			<input type="email" name="email"  class="registrationInputs" placeholder="..." maxlength="<?=$maillimiter?>">
			<input type="submit" name="register" value="Зарегистрироваться" id="registrationButton">
		</form>
		<?php
	}
	else{
		$_SESSION['mainRedirect'] = '1';
		echo "<p id='about'>Вы уже вошли в аккаунт,зачем вам регистрация?</p>";
		exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
	}
?>
