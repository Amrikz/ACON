<?php
	if (!$_SESSION['user_id']) {
	 	$_SESSION['mainRedirect'] = '1';
		exit("<meta http-equiv='refresh' content='0; url= $_SERVER[PHP_SELF]'>");
	}
	$role = level($_SESSION['view_username']);
?>