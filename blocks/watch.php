<?php
	if ($_GET['vid']) {
		require "lib/db.php";
		$query = "SELECT id,title,description,location,author,main_genre,creator,upload_date,views,showing FROM `files` WHERE id = ? LIMIT 1";
		$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
		mysqli_stmt_bind_param($stmt, 'i', $_GET['vid']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$id,$title,$description,$location,$author,$main_genre,$creator,$upload_date,$views,$showing);

		if (!mysqli_stmt_fetch($stmt) || !$showing) {
			exit("<p class='user404'>Видео не доступно</p>");
		}
		if ($author) {
				$author = '<br>'.$author;
			}

		require "lib/db.php";
		$query = "UPDATE files SET views = views + 1 WHERE id = $id";
		mysqli_query($dbc,$query);
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

		echo "
		<video src=$location controls autoplay id='video'></video>
		<h2 id='videoTitle'>$title$author <i id='views'>$views</i></h2>
		<form method='GET' action='account'>
	        <p id='videoAccountbutton'>".accountButton($creator)."</p>
	    </form>
	    <div id='description'>
	    <p>$description</p>
	    </div>
		";
	}
	else {
		echo "<p class='user404'>Видео не доступно</p>";
	}
?>