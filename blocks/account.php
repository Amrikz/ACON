<?php
//Проверки валидности ссылоки перехода
	if (!$_SESSION['user_id'] && !$_GET['user_link']) {
	 	$_SESSION['mainRedirect'] = '1';
		exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
	}
	elseif (!$_SESSION['user_id'] && $_GET['user_link']) {
		$_SESSION['guest'] = 1;
		$_SESSION['view_username'] = NameByid($_GET['user_link']);
		if (!$_SESSION['view_username']) {
			echo "<p class='user404'>Пользователь не найден!</p>";
		}
		else{
			$role = level($_SESSION['view_username']);
		}
	}
	elseif ($_SESSION['user_id'] && !$_GET['user_link']) {
		$_SESSION['guest'] = 0;
		$_SESSION['view_username'] = $_SESSION['user_username'];
		$role = $_SESSION['user_role'];
	}
	elseif ($_SESSION['user_id'] && $_GET['user_link']) {
		if ($_SESSION['user_id'] == $_GET['user_link']) {
			$_SESSION['guest'] = 0;
			$_SESSION['view_username'] = $_SESSION['user_username'];
			$role = $_SESSION['user_role'];
		}
		elseif ($_SESSION['user_id'] != $_GET['user_link']) {
			$_SESSION['guest'] = 1;
			$_SESSION['view_username'] = NameByid($_GET['user_link']);
			$role = level($_SESSION['view_username']);
		}
		if (!$_SESSION['view_username']) {
			echo "<p class='user404'>Пользователь не найден!</p>";
		}
	}
	echo "<p class='accountname'>".$_SESSION['view_username']."</p>";
	if ($role == "Creator") {
		if ($_SESSION['guest'] == 0) {
			echo "<a href='admin'> <p id='Creator'>".$role."</p></a>";
		}
		else{
			echo "<p id='Creator'>".$role."</p>";
		}
	}
	if ($role == "Admin") {
		if ($_SESSION['guest'] == 0) {
			echo "<a href='admin'> <p id='Admin'>".$role."</p></a>";
		}
		else {
			echo "<p id='Admin'>".$role."</p>";
		}
	}
	if ($role == "Moderator") {
		if ($_SESSION['guest'] == 0) {
			echo "<a href='moderator'> <p id='Mondiator'>".$role."</p></a>";
		}
		else {
			echo "<p id='Mondiator'>".$role."</p>";
		}	
	}
//Костыль,сори,переделывать долго
$role = level('',1);
echo "<h1 id='about'>Видео пользователя:</h1>";
	if ($_SESSION['guest'] == 0) {
		echo "<a href='videoadd'><p id='about' style='font-size: 35px;'>Добавить видео</p></a>";
		$query = "SELECT * FROM `files` WHERE creator = '$_SESSION[user_id]' ORDER BY `files`.`upload_date` DESC ";
		draw_video($query,1);
	}
	elseif ($_SESSION['guest'] == 1 && ($role <= 3 && $role != NULL)) {
		$query = "SELECT * FROM `files` WHERE creator = '$_GET[user_link]' ORDER BY `files`.`upload_date` DESC ";
		draw_video($query,1);
	}
	elseif ($_SESSION['guest'] == 1) {
		$query = "SELECT * FROM `files` WHERE showing = 1 AND creator = '$_GET[user_link]' ORDER BY `files`.`upload_date` DESC ";
		draw_video($query,0);
	}
?>