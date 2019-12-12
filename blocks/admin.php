<?php
	if (!$_SESSION['user_id']) {
	 	$_SESSION['mainRedirect'] = '1';
		exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
	}
	$role = level($_SESSION['view_username'],1);
	if ($role <= 2) {
		?>
		<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
		<form enctype="multipart/form-data"  method="POST">
    	<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    	<!-- Название элемента input определяет имя в массиве $_FILES -->
    	Отправить этот файл: <input name="userfile" type="file" />
    	<input type="submit" value="Отправить файл" />
    	<!--<img src="<?=$_FILES['userfile']['tmp_name']?>" type="<?=$_FILES['userfile']['type']?>">
    	<source src="<?=$_FILES['userfile']['tmp_name']?>" type="<?=$_FILES['userfile']['type']?>">-->
		</form>

		<?php
		var_dump($_FILES);
	}
	else{
		echo "<p id='message'>Извините,у вас недостаточно прав для доступа к этому месту.</p>";
	}
?>