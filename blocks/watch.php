<?php
//Проверки валидности перехода по ссылке
	if ($_GET['vid']) {
		require "lib/db.php";
		$query = "SELECT id,title,description,location,author,main_genre,creator,upload_date,views,middle_rating,showing FROM `files` WHERE id = ? LIMIT 1";
		$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
		mysqli_stmt_bind_param($stmt, 'i', $_GET['vid']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$id,$title,$description,$location,$author,$main_genre,$creator,$upload_date,$views,$middle_rating,$showing);
		$role = level('',1); (!$role <= 3 || $role != NULL);
		if (!mysqli_stmt_fetch($stmt)) {
			exit("<p class='user404'>Видео не доступно</p>");
		}
		elseif (!$showing && ($role >= 4 || $role == NULL)) {
			exit("<p class='user404'>Видео не доступно</p>");
		}


//THRESH
		if ($_POST['trash']) {
			require "lib/db.php";
			$query = "SELECT id FROM `comments` WHERE `id` = '$_POST[trash]' AND `user_id` = '$_SESSION[user_id]' LIMIT 1";
			$data = mysqli_query($dbc,$query);
      		$info = mysqli_fetch_assoc($data);
			if (($role <= 3 && $role != NULL) || ($info['id'] && $info['id'] != NULL)) {
				$query = "DELETE FROM `comments` WHERE comments.id = '$info[id]'";
				if (!mysqli_query($GLOBALS['dbc'],$query)) {
					echo "Error:" . mysqli_error($GLOBALS['dbc']);
				}
			}
			else{
				echo "<p id='message'>Извините,что-то пошло не так</p>";
			}
		}


//Счетчик просмотров
		require "lib/db.php";
		if (!$_POST['rating']) {
			$query = "UPDATE files SET views = views + 1 WHERE id = $id";
			mysqli_query($dbc,$query);
		}
		if ($views < 5 && $views != 0) {
			if ($views < 2) {
				$views = $views." просмотр";
			}
			else{
				$views = $views." просмотрa";
			}
		}
		else {
			$views = $views." просмотров";
		}


//Система рейтингов
		if ($_POST['rating']) {
			require "lib/db.php";
			if ($_POST['rating'] > 0 && $_POST['rating'] <= 10) {
				if ($_SESSION['user_id']) {
					$query = "SELECT id,rating FROM `ratings` WHERE video_id = '$_GET[vid]' AND user_id = '$_SESSION[user_id]'";
					$data = mysqli_query($GLOBALS['dbc'],$query);
	      			$info = mysqli_fetch_assoc($data);
	      			//var_dump($info);
	      			if ($info == NULL) {
	      				$query = "INSERT INTO `ratings` (`id`, `video_id`, `user_id`, `rating`) VALUES (NULL, ?, ?, ?)";
						$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
	    				mysqli_stmt_bind_param($stmt, 'iii', $_GET['vid'], $_SESSION['user_id'], $_POST['rating']);
	      				if (!mysqli_stmt_execute($stmt)) {
					      	echo "Error:" . mysqli_error($GLOBALS['dbc']);
					    }
					     else {
					     	//Система обновления рейтинга в бд
					    	$query = "SELECT rating FROM `ratings` WHERE video_id = '$_GET[vid]'";
							$data = mysqli_query($GLOBALS['dbc'],$query);
							$info = mysqli_fetch_assoc($data);
							//var_dump($info);
							while ($info) {
								$totalRating += $info['rating'];
								$count++;
								$info = mysqli_fetch_assoc($data);
								//var_dump($info);
							}
							$rating = $totalRating/$count;
							if ($rating) {
								$rating = round($rating, 1); 
								//var_dump($rating);
								$query = "UPDATE `files` SET `middle_rating` = '$rating' WHERE `files`.`id`='$_GET[vid]'";
								mysqli_query($GLOBALS['dbc'],$query);
							}
					    	echo "<p id='about'>Спасибо за оценку!</p>";
					    }
	      			}
	      			elseif ($_POST['rating'] != $info['rating']) {
	      				$query = "UPDATE `ratings` SET `rating` = '$_POST[rating]' WHERE `ratings`.`id` = '$info[id]'";
	      				if (!mysqli_query($GLOBALS['dbc'],$query)) {
					      	echo "Error:" . mysqli_error($GLOBALS['dbc']);
					    }
					    else {
					    	//Система обновления рейтинга в бд
					    	$query = "SELECT rating FROM `ratings` WHERE video_id = '$_GET[vid]'";
							$data = mysqli_query($GLOBALS['dbc'],$query);
							$info = mysqli_fetch_assoc($data);
							//var_dump($info);
							while ($info) {
								$totalRating += $info['rating'];
								$count++;
								$info = mysqli_fetch_assoc($data);
								//var_dump($info);
							}
							$rating = $totalRating/$count;
							if ($rating) {
								$rating = round($rating, 1); 
								//var_dump($rating);
								$query = "UPDATE `files` SET `middle_rating` = '$rating' WHERE `files`.`id`='$_GET[vid]'";
								mysqli_query($GLOBALS['dbc'],$query);
							}
					    	echo "<p id='about'>Спасибо за оценку!</p>";
					    }
	      			}
	      			else {
	      				echo "<p id='about'>Спасибо за оценку! Но вы уже голосовали точно так же :)</p>";
	      			}
				}
				else {
					echo "<p id='message'>Войдите или зарегистрируйтесь,чтобы выполнить это действие</p>";
				}
			}
			else{
				echo "<p id='message'>Извините,что-то пошло не так</p>";
			}
		}

//Комментарии
		if ($_POST['createComment']):
			if ($_POST['comment']) {
				$rawdate = date('c');
				$date = substr($rawdate,0,10).' '.substr($rawdate,11,8);
				$query = "INSERT INTO `comments` (`id`, `file_id`, `user_id`, `text`, `time`) VALUES (NULL, ?, ?, ?, ?)";
				$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
		    	mysqli_stmt_bind_param($stmt, 'iiss', $_GET['vid'], $_SESSION['user_id'], $_POST['comment'], $date);
		    	if (!mysqli_stmt_execute($stmt)) {
					echo "Error:" . mysqli_error($GLOBALS['dbc']);
				}
			}
			else{
				echo "<p id='message'>Извините,комментарий не может быть пустым</p>";
			}
		endif;

//Проверки всякие
		if (!$description) {
			$description = "
				К этому видео нет описания.
			";
		}


		if ($author) {
			$author = '<br>'.$author;
		}


		if ($_POST['rating'] && $_SESSION['user_id']) {
			$query = "SELECT middle_rating FROM `files` WHERE id = ? LIMIT 1";
			$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
			mysqli_stmt_bind_param($stmt, 'i', $_GET['vid']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$middle_rating);
			mysqli_stmt_fetch($stmt);
		}


//Само видео
		echo "
		<video src=$location controls autoplay id='video'></video>
		<h2 id='videoTitle'><p>$title$author </p><i id='views'>$views</i></h2>
		<form method='GET' action='account'>
	        <p id='videoAccountbutton'>".accountButton($creator)."<i id='views'>$middle_rating/10 - Средний рейтинг</i></p>
	    </form>
	    <form method='POST'>
	    <p id='ratevideo'>Оцените видеоролик:</p>
	    <div id='buttondiv'>";
	    //Кнопки с рейтингами
	    	for ($i=1; $i <= 10; $i++) { 
	    		echo "<button class='ratingButton' name='rating' value='$i'>$i</button>";
	    	}	
	    echo "
	    </div>
	    </form>
	    <b id='OPISANIE'>Описание:</b>
	    <div id='descriptiondiv'>
	    <p id='description'>$description</p>
	    </div>
	    <b id='OPISANIE'>Комментарии:</b>";
	    if ($_SESSION['user_id']): 
	    	?>
	    	<p id='leavecomment'>Оставьте свой комментарий!</p>
	    	<form method='POST'>
	    	<textarea id='leavecommentarea' name='comment'></textarea>
	    	<button type='submit' name='createComment' id='createComment' value="1">Написать</button>
	    	</form>
	    	<?
	    endif;
	    echo "<div id='commentdiv'>";
	    //Комментарии
		   	require "lib/db.php";
			$query = "SELECT * FROM `comments` WHERE file_id = '$_GET[vid]'";
			$data = mysqli_query($GLOBALS['dbc'],$query);
			$info = mysqli_fetch_assoc($data);
			$count = 1;
			while ($info) {
				//Thrash button
				$role = level('',1);
				if (($role <= 3 && $role != NULL) || ($info['user_id'] == $_SESSION['user_id'])) {
					$trashButton = "<form method='POST'><button id='trashButton' value=".$info['id']." name='trash'><i class='fas fa-trash-alt'></i></button></form>";
				}
				else {
					$trashButton = NULL;
				}
				//Rating user
				$query = "SELECT ratings.rating FROM ratings INNER JOIN comments ON comments.user_id = ratings.user_id WHERE comments.user_id = '$info[user_id]'";
      			$rating_data = mysqli_query($dbc,$query);
      			$rating_info = mysqli_fetch_assoc($rating_data);
      			if ($rating_info['rating']) {
      				$db_rating = $rating_info['rating']."/10";
      			}
      			else{
      				$db_rating = NULL;
      			}
				?>

				<div id='exactComment'>
	    			<div id="commenthead">
	    				<form method='GET' action='account'>
	    					<?php echo"#$count"." $db_rating ".accountButton($info['user_id']);?>
	    				</form>
	    				<div id="head2"><?php echo $info['time'].$trashButton?></div>
	    			</div>
	    			<p id="commentText">
	    				<?=$info['text']?>
	    			</p>
				</div>

				<?php
				$count++;
				$info = mysqli_fetch_assoc($data);
			}
	    echo"</div>";
	}
	else {
		echo "<p class='user404'>Видео не доступно</p>";
	}
?>
