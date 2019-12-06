<?php

$url = $_GET['url'];

require 'blocks/header.php';

switch ($url) {
	case '':
		require 'blocks/home.php';
		break;
	case 'home':
		require 'blocks/home.php';
		break;
	case 'account':
		require 'blocks/account.php';
		break;
	case 'register':
		require 'blocks/register.php';
		break;
	default:
		require 'blocks/404.php';
		break;
}

require 'blocks/footer.php';
?>