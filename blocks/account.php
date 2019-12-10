<?php
	if (!$_SESSION['user_id']) {
	 	$_SESSION['mainRedirect'] = '1';
		exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
	 } 
	echo "<p class='accountname'>".$_SESSION['user_username']."</p>";
	if (level() == "Creator") {
		echo "<p id='Creator'>".level()."</p>";
	}
	if (level() == "Admin") {
		echo "<p id='Admin'>".level()."</p>";
	}
	if (level() == "Moderator") {
		echo "<p id='Mondiator'>".level()."</p>";
	}
	?>
	<div></div>
	<?php
?>