<!--<h1 id="about">Welcome to home.</h1>-->
<form method="GET" action="account">
<p id="flex_center"><?php accountButton(1); ?></p>
</form>
<h1 id='about'>Новое</h1>
		<?php 
		$query = "SELECT id,title,preview,creator,upload_date,views,middle_rating FROM `files` WHERE showing = 1 ORDER BY `files`.`upload_date` DESC LIMIT 10";
		draw_video($query);
		echo "<h1 id='about'>Самый высокий рейтинг</h1>";
		$query = "SELECT id,title,preview,creator,upload_date,views,middle_rating FROM `files` WHERE showing = 1 ORDER BY `files`.`middle_rating` DESC LIMIT 10";
		draw_video($query);
		echo "<h1 id='about'>По просмотрам</h1>";
		$query = "SELECT id,title,preview,creator,upload_date,views,middle_rating FROM `files` WHERE showing = 1 ORDER BY `files`.`views` DESC";
		draw_video($query);
		?>
	</div>
<?php

?>
