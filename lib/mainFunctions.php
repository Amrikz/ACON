<?php
//Redirect
  if ($_SESSION['mainRedirect']) {
    $_SESSION['mainRedirect'] = 0;
    $home_url = 'http://' . $_SERVER['HTTP_HOST'];
    header('Location: '. $home_url);
  }

  //Логгинг пользователей
  if (!$_SESSION['user_id']) {
    if ($_POST['submit']) {
      $user_username = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['username']));
      $user_password = mysqli_real_escape_string($GLOBALS['dbc'], trim(crypt($_POST['password'],'$1$'.$_POST['password'].'$')));
      if(!empty($user_username) && !empty($_POST['password'])) {
        $user_password = substr($user_password, 12); 
        $query = "SELECT id,username FROM `users` WHERE username = ? AND password = ? LIMIT 1";
        $stmt = mysqli_prepare($GLOBALS['dbc'],$query);
        mysqli_stmt_bind_param($stmt, 'ss', $user_username, $user_password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$id,$user);
        while (mysqli_stmt_fetch($stmt)) {
          $fetched_id[] = $id;
          $fetched_username[] = $user;
        }
        if($id) {
          $_SESSION['user_id'] = $fetched_id[0];
          $_SESSION['user_username'] = $fetched_username[0];
          $_SESSION['user_role'] = level();
        }
        else {
          $wrongLogin = 1;
        }
      }
      else{
        $fillforms = 1;
      }
    }
  }
  elseif ($_POST['exit']) {
    session_unset();
    session_destroy();
    echo "<meta http-equiv='refresh' content=0;>";
  }
  //Выход из аккаунта при его отсутсвии в базе данных
  elseif ($_SESSION['user_id']) {    
    $query = "SELECT id,username FROM `users` WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($GLOBALS['dbc'],$query);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,$id,$user);
    mysqli_stmt_fetch($stmt);
    if (!$id) {
      $_SESSION['user_id'] = 0;
      $_SESSION['user_username'] = 0;
	  $_SESSION['user_role'] = 0;
    }
  }

  //Функция проверки уровня пользователя
  function level($user = 0, $id_view = 0 ) {
    require "lib/db.php";
    if (!$user) {
    	$user = $_SESSION["user_username"];
    }
    if ($id_view) {
      $query = "SELECT users.username AS username, roles.id 
        FROM users INNER JOIN roles 
         ON users.role = roles.id WHERE username = '$user'";
      $data = mysqli_query($dbc,$query);
      $info = mysqli_fetch_assoc($data);
      return $info['id'];
    }
    else{
      $query = "SELECT users.username AS username, roles.role 
        FROM users INNER JOIN roles 
         ON users.role = roles.id WHERE username = '$user'";
      $data = mysqli_query($dbc,$query);
      $info = mysqli_fetch_assoc($data);
      return $info['role'];
    }
  }

  //Функция получения имени из id
  function NameByid($id = 0) {
    if (!$id) {
      return ;
    }
    else {
      require "lib/db.php";
      $query = "SELECT username FROM `users` WHERE id = ? LIMIT 1";
      $stmt = mysqli_prepare($dbc,$query);
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt,$user);
      mysqli_stmt_fetch($stmt);
      return $user;
    }
  }
  

  function accountButton($id,$text = '') {
    return "<button type='submit' id='idNameButton' name='user_link' value=".$id.">".$text."<i class='line_under'>".NameByid($id)."</i></button>";
  }
  

  function draw_video($query = 0, $showmoderating = 0, $limit = -1, $info = 0) {
	if ($query || $info) {
		if ($info == 0) {
			require "lib/db.php";
			$data = mysqli_query($dbc,$query);
			$info = mysqli_fetch_assoc($data);
			echo "<div class='videos'>";
			if (!$info) {
				echo "<p id='about'>Извините,сейчас тут ничего нет.</p>";
			}
			$selfdb = 1;
		}
		$counter = 0;
		while ($info) {
			if ($counter == $limit) {
				break;
			}
			if ((!$info['moderating']) || ($info['moderating'] && $showmoderating == 1)) {
				if (!$info['preview'] || !file_exists($info['preview'])) {
					$info['preview'] = "images\\vid_paceholder.jpg";
				}
				if (!$info['middle_rating']) {
					$info['middle_rating'] = "Не оценено";
				}

		        if ($info['showing'] == 0 && $info['showing'] != NULL) {
		          echo "
		            <div class='video' style='border: 3px #615f57 solid;'>";
		        }
		        else{
		          echo "
		            <div class='video'>";
		        }
				echo "
		        	<form method='GET' action='watch'>
		            <button class='videoButton' name='vid' value=".$info['id']."><img class='videoPreview' src=".$info['preview'].">
		            <h5>".$info['title']."</h5>
		            </button></form>
		            <form method='GET' action='account'>
		            <p>".accountButton($info['creator'])."</p>
		            </form>
		            <i id='homeViews'>Просмотры: ".$info['views']."</i>
		            <h6 id='homeAddInfo'>Загружено: ".$info['upload_date']."<i>".$info['middle_rating']."/10</i></h6>
		        </div>";
		        $counter++;
		    }
		    elseif ($counter == 0 && $showmoderating == 1) {
		    	echo "<p id='about'>Извините,сейчас тут ничего нет.</p>";
		    }
		    if ($selfdb) {
		    	$info = mysqli_fetch_assoc($data);
		    }
		    else{
		    	$info = 0;
		    }
		}
		if ($selfdb) {
			echo "</div>";
		}
	}
}
?>