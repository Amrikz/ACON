<?php
	//File add system
	if ($_FILES) {
		foreach ($_FILES as $key => $value) {
			$uploaddir = "\\..\\users\\".$_SESSION['user_username']."\\";
			define ('SITE_ROOT', realpath(dirname(__FILE__)));
			$filename = str_replace(' ', '_', basename($_FILES["$key"]['name']));
			if (!$filename) $filename = ' . . %$$_';
			$dir = SITE_ROOT.$uploaddir;
			if (!file_exists($dir) && !is_dir($dir) ) {
				$usersdir = SITE_ROOT."\\..\\users\\";
				if (!file_exists($usersdir) && !is_dir($usersdir) ) {
					mkdir( $usersdir );
				}
			 			mkdir( $dir );       
			} 
			echo "<pre>";
			/*print_r($_FILES);
			print_r($dir.$filename);*/
			if ($key  == 'video') {
				if ($_FILES["$key"]['type'] == 'video/mp4') {
					$upload = move_uploaded_file($_FILES["$key"]['tmp_name'], $dir.$filename);
				}
				else{
					echo "<p id='message'>Загрузка не выполнена.Вы пытаетесь загрузить не видеофайл.</p>";
				}
			}
			elseif (!file_exists($dir.$filename)) {
				$upload = move_uploaded_file($_FILES["$key"]['tmp_name'], $dir.$filename);
			}
			else {
				echo "Файл с именем '$filename' уже существует.\n";
				echo "Файл загружен\n";
				$upload = move_uploaded_file($_FILES["$key"]['tmp_name'], $dir.$filename);
				$exist = 1;
			}
				if ($upload){
					$_FILES["$key"]['fin_Upl_Dir'] = "users\\".$_SESSION['user_username']."\\".$filename;
				}
				else {
					$error = $_FILES["$key"]['error'];
					if ($error) {
						if ($error == 1 || $error == 2) {
							echo "Размер принятого файла превысил максимально допустимый размер.\n";
						}
						elseif ($error == 3) {
							echo "Загружаемый файл был получен только частично.\n";
						}
						elseif ($error == 4) {
							echo "Файл $key не был загружен.\n";
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
				    if (!$_FILES['preview']['tmp_name'] && $_FILES['preview'] && !$exist) {
				    	echo "Файл preview не выбран\n";
				    }
				    elseif (!$exist) {
				    	echo "Ошибка при загрузке,проверьте правильность пути.\n";
					    echo 'Некоторая отладочная информация:';
					    print_r($_FILES);
					}
				}
			print "</pre>";			
		}
	}