<?php
if ($_GET['search']) {
	if ($_SESSION['searchall'] == NULL) {
		$_SESSION['searchall'] = 1;
	}
	if (!mb_substr($_GET['search'],2)) {
		exit("<p id='message'>Слишком короткий поисковый запрос</p>");
	}
	if ($_SESSION['searchall'] == 1) {
		require "lib/db.php";
		$query = "SELECT * FROM `files` WHERE `title` LIKE ? ORDER BY `files`.`views` DESC";
		$stmt = mysqli_prepare($GLOBALS['dbc'],$query);
		$search = '%'.$_GET['search'].'%';
        mysqli_stmt_bind_param($stmt, 's', $search);
        mysqli_stmt_execute($stmt);
       	$result = mysqli_stmt_get_result($stmt);
       	$first = 1;
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if (!$row) {
				echo "<p id='about'>Извините,сейчас тут ничего нет.</p>";
			}
        while ($row){
        	if ($first) {
        		echo "<h1 id='about'>По названию</h1>";
        		echo "<div class='videos'>";
        		$first = 0;
        	}
        	draw_video(0,0,-1,$row);
        	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        echo "</div>";
		#users.username genres.genre genre_assotiation.genre_id,video_id files.title,author //To do (for future)
	}

}
else {
	exit("<p id='about'>Введите поисковый запрос</p>");
}
?>



