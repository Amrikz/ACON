<?php

function draw_video($query = 0) {
	if ($query) {
		require "lib/db.php";
		$data = mysqli_query($dbc,$query);
		$info = mysqli_fetch_assoc($data);
		echo "<div class='videos'>";
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
		echo "</div>";
	}
}
?>
<!--<h1 id="about">Welcome to home.</h1>-->
<form method="GET" action="account">
<p id="flex_center"><?php accountButton(1); ?></p>
</form>
<h1 id='about'>Новое</h1>
		<?php 
		$query = "SELECT id,title,preview,creator,upload_date,views,middle_rating FROM `files` WHERE showing = 1 ORDER BY `files`.`upload_date` DESC LIMIT 10";
		draw_video($query);
		?>
	</div>
<?php

?>
