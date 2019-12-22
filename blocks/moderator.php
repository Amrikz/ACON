<?php
	if (!$_SESSION['user_id']) {
		exit("<meta http-equiv='refresh' content='0; url= home'>");
	}
	$role = level('',1);
	if ($role <= 2) {
		require "lib/adminFunc.php";
			if (!$_POST['moder_option'] && $_SESSION['moder_option']) {
				if ($_POST['moder_option'] != NULL) {
					$_SESSION['moder_option'] = 0;
				}
			}
			if (!$_POST['moder_option'] && !$_SESSION['moder_option']) {
					echo "<p class='adminFunctions'>Функции модератор-панели:</p>";
					?>
					<form method="POST" class='adminButtons'>
						<button type='submit' class='adminButton' name='moder_option' value="add">Отбор видео</button>
					</form>
					<?php
			}
			elseif (($_POST['moder_option'] && !$_SESSION['moder_option']) || ($_POST['moder_option'] && $_SESSION['moder_option']) || ($_POST['moder_option'] == NULL && $_SESSION['moder_option'])) {
					if ($_POST['moder_option'] != NULL) {
						$_SESSION['moder_option'] = $_POST['moder_option'];
					}
					echo "<form method='POST' class='adminButtons'>";
					echo "<button type='submit' name='moder_option' class='adminButton' value=0>Вернуться</button>";
					echo "</form>";
			}
			if ($_SESSION['moder_option']) {
				$option = $_SESSION['moder_option'];
				switch ($option) {
				 	case 'add':
				 		#somecase
				 		break;
				 	
				 	default:
				 		echo "<p id='message'>Извините,такой опции не существует.</p>";
				 		break;
				
				}
			}
	}
	else{
		echo "<p id='message'>Извините,у вас недостаточно прав для доступа к этому месту.</p>";
	}
?>