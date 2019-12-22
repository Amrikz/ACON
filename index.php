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
	//Забыли пароль? (Надеюсь когда-нибудь доделать)
	/*case 'forgot':
		require 'blocks/forgpass.php';
		break;*/
	case 'watch':
		require 'blocks/watch.php';
		break;
	case 'films':
		require 'blocks/film.php';
		break;
	case 'mults':
		require 'blocks/mult.php';
		break;
	case 'serials':
		require 'blocks/serial.php';
		break;
	case 'account':
		require 'blocks/account.php';
		break;
	case 'videoadd':
		require 'blocks/videoadd.php';
		break;
	case 'register':
		require 'blocks/register.php';
		break;
	case 'moderator':
		require 'blocks/moderator.php';
		break;
	case 'admin':
		require 'blocks/admin.php';
		break;	
	default:
		require 'blocks/404.php';
		break;
}

require 'blocks/footer.php';
?>