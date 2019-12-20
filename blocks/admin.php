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
				 		if ($_POST['title'] && $_FILES["video"]['fin_Upl_Dir'] && ($_POST['show'] == '0' || $_POST['show'] == '1') && ($_POST['maingenre'] >= 1 && $_POST['maingenre'] <= 3)) {
				 			require "lib/db.php";
							$query = "INSERT INTO `files` (`id`, `title`, `description`, `preview`, `location`, `author`, `main_genre`, `creator`, `upload_date`, `views`, `showing`, `moderating`) VALUES (NULL, ?, ?, ? , ?, ?, ? , ?, ?, '0', ?, '0')";
						    $stmt = mysqli_prepare($GLOBALS['dbc'],$query);
						    mysqli_stmt_bind_param($stmt, 'sssssiisi', $_POST['title'], $_POST['description'], $_FILES["preview"]['fin_Upl_Dir'], $_FILES["video"]['fin_Upl_Dir'], $_POST['author'], $_POST['maingenre'], $_SESSION['user_id'], $date, $_POST['show']);
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
				      		//Жанры						
 							elseif ($_POST['genre']) {
 								$video_id = mysqli_stmt_insert_id($stmt);
 								foreach ($_POST['genre'] as $key => $value) {
 									require "lib/db.php";
 									$query = "SELECT id FROM `genres` WHERE id = ?";
 									$stmt = mysqli_prepare($dbc,$query);
						    		mysqli_stmt_bind_param($stmt, 'i', $value);
						    		if (!mysqli_stmt_execute($stmt)) {
				      					echo "Error:" . mysqli_error($GLOBALS['dbc']);
				      				}
				      				else {
				      					mysqli_stmt_bind_result($stmt,$id);
				      					mysqli_stmt_fetch($stmt);
				      					if ($id) {
				      						$query = "INSERT INTO `genre_association` (`id`, `genre_id`, `video_id`) VALUES (NULL, $id, '$video_id')";
				      						require "lib/db.php";
				      						mysqli_query($dbc,$query);
				      					}				      					
				      				}
 								}
 							}
						}
						elseif ($_POST['title'] || $_FILES["video"]['fin_Upl_Dir'] || $_POST['maingenre']) {
							echo "<p id='message'>Не заполнены все необходимые поля</p>";
						}

						?>
						<form enctype="multipart/form-data"  method="POST" class="videomake">
						<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
						<label class="registrationLabels">Название видео</label>
						<input type="text" name="title" placeholder="..." class="registrationInputs" maxlength=200 > <!--required-->
						<label class="registrationLabels" >Описание видео</label>
				    	<textarea name="description" cols ="50" class="adminTextarea"></textarea>
				    	<label class="registrationLabels">Превью</label>
				    	<input name="preview" type="file" />
				    	<label class="registrationLabels">Видео</label>
				    	<input name="video" type="file" /> <!--required-->
				    	<label class="registrationLabels">Автор</label>
						<input type="text" name="author" placeholder="..." class="registrationInputs" maxlength=150>
						<div>
						<input type="radio" name="show" class="adminRadio" value="1" checked>
						<label >Показывать</label>
						<input type="radio" name="show" class="adminRadio" value="0" >
						<label >Не показывать</label>
						</div>
						<div>
							<?php
							require "lib/db.php";
							$query = "SELECT * FROM `genres` LIMIT 3";
							$data = mysqli_query($GLOBALS['dbc'],$query);
							$info = mysqli_fetch_assoc($data);
							$info['id'] = $info['id']." checked";
							//var_dump($info);
							while ($info) {
								echo "<input type='radio' name='maingenre' class='adminGenreRadio' value=".$info['id'].">
								<label class='adminGenreRadioLabel'>".$info['genre']."</label>";
								$info = mysqli_fetch_assoc($data);
							}
							?>
						</div>
						<div id="checkboxes">
							<?php
							require "lib/db.php";
							$query = "SELECT * FROM `genres`";
							$data = mysqli_query($GLOBALS['dbc'],$query);
							$info = mysqli_fetch_assoc($data);
							$info['id'] = $info['id']." checked";
							$count = 0;
							while ($info) {
								$count++;
								if ($count > 3) {
									echo "<div id='checkBoxDiv'>";
									echo "<input type='checkbox' name='genre[]' class='adminGenreCheckbox' value=".$info['id'].">
									<label class='adminGenreCheckboxLabel'>".$info['genre']."</label>";
									echo "</div>";
								}
								$info = mysqli_fetch_assoc($data);
							}
							?>
						</div>
				    	<input type="submit" name="submit" value="Создать видео" id="makeVideoButton" />
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