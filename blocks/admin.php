<?php
	if (!$_SESSION['user_id']) {
		exit("<meta http-equiv='refresh' content='0; url= home'>");
	}
	$role = level('',1);
	if ($role <= 2) {
		require "lib/adminFunc.php";
			if (!$_POST['admin_option'] && $_SESSION['admin_option']) {
				if ($_POST['admin_option'] != NULL) {
					$_SESSION['admin_option'] = 0;
				}
			}
			if (!$_POST['admin_option'] && !$_SESSION['admin_option']) {
					echo "<p class='adminFunctions'>Функции админ-панели:</p>";
					?>
					<form method="POST" class='adminButtons'>
						<button type='submit' class='adminButton' name='admin_option' value="add">Добавление Видео</button>
					</form>
					<?php
			}
			elseif (($_POST['admin_option'] && !$_SESSION['admin_option']) || ($_POST['admin_option'] && $_SESSION['admin_option']) || ($_POST['admin_option'] == NULL && $_SESSION['admin_option'])) {
					if ($_POST['admin_option'] != NULL) {
						$_SESSION['admin_option'] = $_POST['admin_option'];
					}
					echo "<form method='POST' class='adminButtons'>";
					echo "<button type='submit' name='admin_option' class='adminButton' value=0>Вернуться</button>";
					echo "</form>";
			}
			if ($_SESSION['admin_option']) {
				$option = $_SESSION['admin_option'];
				switch ($option) {
				 	case 'add':
				 		$date = date('o').'-'.date('n').'-'.date('j');
				 		if ($_POST['title'] && $_FILES["video"]['fin_Upl_Dir'] && ($_POST['show'] == '0' || $_POST['show'] == '1')) {
				 			require "lib/db.php";
							$query = "INSERT INTO `files` (`id`, `title`, `description`, `preview`, `location`, `author`, `main_genre`, `creator`, `upload_date`, `views`, `showing`, `moderating`) VALUES (NULL, ?, ?, ? , ?, ?, '1' , ?, ?, '0', ?, '0')";
						    $stmt = mysqli_prepare($GLOBALS['dbc'],$query);
						    mysqli_stmt_bind_param($stmt, 'sssssisi', $_POST['title'], $_POST['description'], $_FILES["preview"]['fin_Upl_Dir'], $_FILES["video"]['fin_Upl_Dir'], $_POST['author'], $_SESSION['user_id'], $date, $_POST['show']);
						    /*var_dump($_POST['title']);
						    echo "<br>";
						    var_dump($_POST['description']);
						    echo "<br>";
						    var_dump($_FILES["preview"]['fin_Upl_Dir']);
						    echo "<br>";
						    var_dump($_FILES["video"]['fin_Upl_Dir']);
						    echo "<br>";						    
						    var_dump($_POST['author']);
						    echo "<br>";
						    var_dump($_SESSION['user_username']);
						    echo "<br>";
						    var_dump($date);
						    echo "<br>";*/
						    if (!mysqli_stmt_execute($stmt)) {
				      			echo "Error:" . mysqli_error($GLOBALS['dbc']);
				      		}						

						}

						?>
						<form enctype="multipart/form-data"  method="POST" class="videomake">
						<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
						<label class="registrationLabels">Название видео</label>
						<input type="text" name="title" placeholder="..." class="registrationInputs" maxlength=200 required>
						<label class="registrationLabels" >Описание видео</label>
				    	<textarea name="description" cols ="50" class="adminTextarea"></textarea>
				    	<label class="registrationLabels">Превью</label>
				    	<input name="preview" type="file" />
				    	<label class="registrationLabels">Видео</label>
				    	<input name="video" type="file" required/>
				    	<label class="registrationLabels">Автор</label>
						<input type="text" name="author" placeholder="..." class="registrationInputs" maxlength=150>
						<div>
						<input type="radio" name="show" class="adminRadio" value="1" checked>
						<label >Показывать</label>
						<input type="radio" name="show" class="adminRadio" value="0" >
						<label >Не показывать</label>
						</div>
				    	<input type="submit" name="submit" value="Создать видео" />
						</form>
						<?php
				 		break;
				 	
				 	default:
				 		echo "<p id='message'>Извините,такой опции не существует.</p>";
				 		break;
				
				}
			}
	}
	else{
		echo "<p id='message'>Извините,у вас недостаточно прав для доступа к этому месту.</p>";
	}
?>