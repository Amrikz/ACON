<?php
	if (!$_SESSION['user_id']) {
		exit("<meta http-equiv='refresh' content='0; url= home'>");
	}
	$role = level($_SESSION['view_username'],1);
	if ($role <= 2) {
		$uploaddir = '../users/www/videos/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

		echo '<pre>';
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		    echo "Файл корректен и был успешно загружен.\n";
		} else {
		    echo "Возможная атака с помощью файловой загрузки!\n";
		}

		echo 'Некоторая отладочная информация:';
		print_r($_FILES);

		print "</pre>";
		?>
		<form enctype="multipart/form-data"  method="POST">
		<input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
    	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    	Отправить этот файл: <input name="userfile" type="file" />
    	<input type="submit" value="Отправить файл" />
    	<!--<img src="<?=$_FILES['userfile']['tmp_name']?>" type="<?=$_FILES['userfile']['type']?>">
    	<source src="<?=$_FILES['userfile']['tmp_name']?>" type="<?=$_FILES['userfile']['type']?>">-->
		</form>

		<?php

		//var_dump($_FILES);
	}
	else{
		echo "<p id='message'>Извините,у вас недостаточно прав для доступа к этому месту.</p>";
	}
?>