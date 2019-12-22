<form method="GET" action="account">
<p id="flex_center"><?php accountButton(1); ?></p>
</form>
<h1 id='about'>Сериалы</h1>
	<div class="videos">
		<?php 
		$query = "SELECT * FROM `files` WHERE showing = 1 AND main_genre = 2 ORDER BY `files`.`upload_date` DESC";
		draw_video($query);
		?>
	</div>