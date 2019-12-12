<?php
	if (!$_SESSION['user_id']) {
		exit("<meta http-equiv='refresh' content='0; url= home'>");
	}
	$role = level('',1);
	if ($role <= 2) {
		require "lib/adminFunc.php";
			if ($_POST['admin_option'] == "NULL" || $_POST['admin_option'] == NULL) {
					$_SESSION['admin_option'] = NULL;
			}
			elseif ($_POST['admin_option']) {
					$_SESSION['admin_option'] = $_POST['admin_option'];
					echo "<form method='POST' class='adminButtons'>";
					echo "<button type='submit' name='admin_option' class='adminButton' value='NULL'>Вернуться</button>";
					echo "</form>";
			}
			if ($_SESSION['admin_option']) {
				$option = $_POST['admin_option'];
				if ($option == 'add') {
					
				?>
				<form enctype="multipart/form-data"  method="POST">
				<input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" /> 
		    	<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
		    	<input name="userfile" type="file" />
		    	<input type="submit" value="Отправить файл" />
		    	<!--<img src="<?=$_FILES['userfile']['tmp_name']?>" type="<?=$_FILES['userfile']['type']?>">
		    	<source src="<?=$_FILES['userfile']['tmp_name']?>" type="<?=$_FILES['userfile']['type']?>">-->
				</form>
				<?php
				}
			}
			else{
				echo "<p class='adminFunctions'>Функции админ-панели:</p>";
				?>
				<form method="POST" class='adminButtons'>
					<button type='submit' class='adminButton' name='admin_option' value="add">Добавление Видео</button>
				</form>
				<?php
			}
			/*
		*/
	}
	else{
		echo "<p id='message'>Извините,у вас недостаточно прав для доступа к этому месту.</p>";
	}
?>