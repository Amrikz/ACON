<form method="GET" action="account">
<p id="flex_center"><?php accountButton(1); ?></p>
</form>
<h1 id='about'>Фильмы</h1>
	<div class="videos">
		<?php 
		require "lib/db.php";
		$query = "SELECT id,title,preview,creator,upload_date,views,middle_rating FROM `files` WHERE showing = 1 AND main_genre = 1 ORDER BY `files`.`upload_date` DESC ";
		$data = mysqli_query($GLOBALS['dbc'],$query);
		$info = mysqli_fetch_assoc($data);
		if (!$info) {
			echo "<p id='about'>Извините,сейчас тут ничего нет.</p>";
		}
		while ($info) {
			if (!$info['preview'] || !file_exists($info['preview'])) {
				$info['preview'] = "images\\vid_paceholder.jpg";
			}
			if (!$info['middle_rating']) {
				$info['middle_rating'] = "Не оценено";
			}
			echo "
	        <div class='video'>
	        	<form method='GET' action='watch'>
	            <button class='videoButton' name='vid' value=".$info['id']."><img class='videoPreview' src=".$info['preview'].">
	            <h5>".$info['title']."</h5>
	            </button></form>
	            <form method='GET' action='account'>
	            <p>".accountButton($info['creator'])."</p>
	            </form>
	            <i id='homeViews'>Просмотры: ".$info['views']."</i>
	            <h6 id='homeAddInfo'>Загружено: ".$info['upload_date']."<i>".$info['middle_rating']."/10</i></h6>
	        </div>";
	        $info = mysqli_fetch_assoc($data);
		}
		?>
	</div>