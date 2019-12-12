<?php
	//File add system
	if ($_FILES['userfile']) {
		$uploaddir = "\\..\\users\\".$_SESSION['user_username']."\\";
		define ('SITE_ROOT', realpath(dirname(__FILE__)));
		$filename = basename($_FILES['userfile']['name']);
		$dir = SITE_ROOT.$uploaddir;
		if (!file_exists($dir) && !is_dir($dir) ) {
			$usersdir = SITE_ROOT."\\..\\users\\";
			if (!file_exists($usersdir) && !is_dir($usersdir) ) {
				mkdir( $usersdir );
			}
		 			mkdir( $dir );       
		} 
		echo "<pre>";
		$upload = move_uploaded_file($_FILES['userfile']['tmp_name'], $dir.$filename);
		if ($upload){
			echo "Файл корректен и был успешно загружен.\n";
		}
		else {
			$error = $_FILES['userfile']['error'];
			if ($error) {
				if ($error == 1 || $error == 2) {
					echo "Размер принятого файла превысил максимально допустимый размер.\n";
				}
				elseif ($error == 3) {
					echo "Загружаемый файл был получен только частично.\n";
				}
				elseif ($error == 4) {
					echo "Файл не был загружен.\n";
				}
				elseif ($error == 6) {
					echo "Отсутствует временная папка.\n";
				}
				elseif ($error == 7) {
					echo "Не удалось записать файл на диск.\n";
				}
				elseif ($error == 8) {
					echo "PHP-расширение остановило загрузку файла. PHP не предоставляет способа определить, какое расширение остановило загрузку файла; в этом может помочь просмотр списка загруженных расширений с помощью phpinfo().\n";
				}
			}
		    echo "Ошибка при загрузке,проверьте правильность пути.\n";
		    echo 'Некоторая отладочная информация:';
		    print_r($_FILES);
		}
		print "</pre>";			
	}