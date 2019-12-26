<form method="GET" action="account">
<p id="flex_center"><?php accountButton(1); ?></p>
</form>
<h1 id='about'>Новое</h1>
		<?php 
		$query = "SELECT * FROM `files` WHERE showing = 1 ORDER BY `files`.`upload_date` DESC LIMIT 20";
		draw_video($query,0,10);
		echo "<h1 id='about'>Самый высокий рейтинг</h1>";
		$query = "SELECT * FROM `files` WHERE showing = 1 ORDER BY `files`.`middle_rating` DESC LIMIT 20";
		draw_video($query,0,10);
		echo "<h1 id='about'>Самое популярное</h1>";
		$query = "SELECT * FROM `files` WHERE showing = 1 ORDER BY `files`.`views` DESC";
		draw_video($query);
		?>
	</div>
<?php

?>
