<?php
	if (!$_SESSION['user_id'] && !$_GET['user_link']) {
	 	$_SESSION['mainRedirect'] = '1';
		exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
	}
	elseif (!$_SESSION['user_id'] && $_GET['user_link']) {
	 	$_SESSION['guest'] = 1;
		$_SESSION['user_username'] = idName($_GET['user_link']);
		if (!$_SESSION['user_username']) {
			echo "<p class='user404'>Пользователь не найден!</p>";
		}
	} 
	echo "<p class='accountname'>".$_SESSION['user_username']."</p>";
	$role = level();
	if ($role == "Creator") {
		echo "<p id='Creator'>".$role."</p>";
	}
	if ($role == "Admin") {
		echo "<p id='Admin'>".$role."</p>";
	}
	if ($role == "Moderator") {
		echo "<p id='Mondiator'>".$role."</p></a>";
	}
	?>
	<div></div>
	<?php
?>