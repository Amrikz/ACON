<?php 
//WORK
define('NAMELIMETER',  30);
define('PASSLIMITER',  60);
define('MAILLIMITER',  80);

	if($_POST['register']){
		$username = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['username']));
		$password1 = mysqli_real_escape_string($GLOBALS['dbc'], trim(crypt($_POST['password'],'$1$'.$_POST['password'].'$')));
		$password2 = mysqli_real_escape_string($GLOBALS['dbc'], trim(crypt($_POST['confirmPassword'],'$1$'.$_POST['confirmPassword'].'$')));
		$email = mysqli_real_escape_string($GLOBALS['dbc'] trim($_POST['email']));
		if (iconv_strlen($username) <= NAMELIMETER && iconv_strlen($_POST['password']) <= PASSLIMITER && iconv_strlen($email) <= MAILLIMITER) {
			if(!empty($username) && !empty($password1) && !empty($password2) && !empty($email)) {
				if ($password1 == $password2) {
					$password1 = substr($password1, 12); //Начало хэша с 12 строки (Теперь без спойлеров!)
					$query = "SELECT username FROM `users` WHERE username = ? LIMIT 1";
					$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
					mysqli_stmt_bind_param($stmt, 's', $username);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$user);
					if(!mysqli_stmt_fetch($stmt)) {
						$query = "INSERT INTO `users` (`id`, `username`, `password`, `email` , `role`) VALUES (NULL, ? , ? , SHA( ? ) , '4')";
						$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
	      				mysqli_stmt_bind_param($stmt, 'sss', $username, $password1, $email);
	      				mysqli_stmt_execute($stmt);
						$query = "SELECT id,username FROM `users` WHERE username = ? LIMIT 1";
						$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
						mysqli_stmt_bind_param($stmt, 's', $username);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt,$id,$user);
						mysqli_stmt_fetch($stmt);
							$fetched_id[] = $id;
	        				$fetched_username[] = $user;
						$_SESSION['user_id'] = $fetched_id[0];
	        			$_SESSION['user_username'] = $fetched_username[0];
		        		echo "<p id='about'>Регистрация завершена успешно!</p>";
						mysqli_close($GLOBALS['dbc']);
						$_SESSION['mainRedirect'] = '1';
						exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
					}
					else {
						echo "<p id='message'>Логин уже существует</p>";
					}
				}
				else{
					echo "<p id='message'>Пароли не совпадают</p>";
				}
			}
			else{
			echo "<p id='message'>Пожалуйста,заполните поля правильно</p>";
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
			<input type="text" name="username" placeholder="..." class="registrationInputs" maxlength="<?=NAMELIMETER?>">
			<label class="registrationLabels">Пароль</label>
			<input type="password" name="password" placeholder="..." class="registrationInputs" maxlength="<?=PASSLIMITER?>">
			<label class="registrationLabels">Подтверждение пароля</label>
			<input type="password" name="confirmPassword" placeholder="..." class="registrationInputs" maxlength="<?=PASSLIMITER?>">
			<label class="registrationLabels">Электронная почта</label>
			<input type="email" name="email"  class="registrationInputs" placeholder="..." maxlength="<?=MAILLIMITER?>">
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
