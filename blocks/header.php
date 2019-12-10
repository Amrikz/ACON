<?php
session_start();

require "lib/db.php";

//Redirect
if ($_SESSION['mainRedirect']) {
  $_SESSION['mainRedirect'] = 0;
  $home_url = 'http://' . $_SERVER['HTTP_HOST'];
  header('Location: '. $home_url);
}

//Логгинг пользователей
if (!$_SESSION['user_id']) {
  if ($_POST['submit']) {
    $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $user_password = mysqli_real_escape_string($dbc, trim(crypt($_POST['password'],'$1$'.$_POST['password'].'$')));
    if(!empty($user_username) && !empty($_POST['password'])) {
      $user_password = substr($user_password, 12); 
      $query = "SELECT id,username FROM `users` WHERE username = ? AND password = ? LIMIT 1";
      $stmt = mysqli_prepare($dbc,$query);
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
}
/*Выход из аккаунта при его отсутсвии в базе данных
elseif ($_SESSION['user_id']) {    
  $query = "SELECT id,username FROM `users` WHERE id = ? LIMIT 1";
  $stmt = mysqli_prepare($dbc,$query);
  mysqli_stmt_bind_param($stmt, 's', $_SESSION['user_id']);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt,$id,$user);
  mysqli_stmt_fetch($stmt);
  echo $id;
  if (!$id) {
    $_SESSION['user_id'] = 0;
    $_SESSION['user_username'] = 0;
  }
}*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Action Online</title>
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <link href="../style/fontawesome/css/all.css" rel="stylesheet">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
  <header>
      <div id=headWrapper>
             <a href="home" id=LOGO>ACON</a>
         <div class="links">
              <a href="#" class="topLinks">Фильмы</a>
              <a href="#" class="topLinks">Сериалы</a>
              <a href="#" class="topLinks">Мультфильмы</a>
              <a href="#" class="topLinks">Помощь</a>
         </div>
         <!--Logging-->
             <?php if (!$_SESSION['user_id']) { 
                  ?>
                    <form method="POST" id="loginForm">
                      <input type="text" name="username" placeholder="Имя пользователя" class="loginInputs" maxlength="30">
                      <input type="password" name="password" placeholder="Пароль" class="loginInputs" maxlength="60">
                      <input type="submit" name="submit" value="Войти" class="loginButton">
                      <a href="register" name="register" class="loginButton" id="registerButton">Зарегистрироваться</a>
                    </form>
                  <?php
                }
              else{
                  ?>
                    <form method="POST">
                      <a href="account" id=accountLink><?= $_SESSION['user_username']?></a>
                      <input type="submit" name="exit" class="loginButton" id="logout" value="Выходишь?">
                    </form>
                  <?php
                }
              ?>
      </div>
  </header>
      <div id=wrapper>
        <!--Поле поиска-->
          <form action="" method="GET" id=search>
            <input name="search" placeholder="Искать здесь..." type="search" id="searchinput">
            <button type="submit" id="searchbutton" name="search" ><i class="fas fa-search" id="searchsymbol"></i></button>
          </form>
        <?php
        if ($fillforms) echo "<p id='message'>Пожалуйста,заполните поля</p>";
        if ($wrongLogin) echo "<p id='message'>Извините, вы должны ввести правильные имя пользователя и пароль</p>
        						<a href='forgot' id='forgot'>Забыли пароль?</a>";
        ?>
        <!--Content-->
        <content>
            <div class="container">
