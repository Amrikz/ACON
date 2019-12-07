<?php
session_start();

require "lib/db.php";

//Логгинг пользователей
if (!$_SESSION['user_id']) {
  if ($_POST['submit']) {
    $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $user_password = mysqli_real_escape_string($dbc, trim(crypt($_POST['password'],'DFB781F170EF30A1')));
    if(!empty($user_username) && !empty($_POST['password'])) {
      $query = "SELECT id,username FROM `users` WHERE username = '$user_username' AND password = '$user_password'";
      $data = mysqli_query($dbc,$query);
      if(mysqli_num_rows($data) == 1) {
      	$row = mysqli_fetch_array($data);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_username'] = $row['username'];
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Action Online</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7d59cbd2d7.js" crossorigin="anonymous"></script>
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
            <button type="submit" id="searchbutton" name="search"></button>
          </form>
        <?php
        if ($fillforms) echo "<p id='about'>Пожалуйста,заполните поля</p>";
        if ($wrongLogin) echo "<p id='about'>Извините, вы должны ввести правильные имя пользователя и пароль</p>
        						<a href='forgot' id='forgot'>Забыли пароль?</a>";
        ?>
        <!--Content-->
        <content>
            <div class="container">
