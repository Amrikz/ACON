<?php
session_start();

//PHP функция для обратимого шифрования
  function encode($String, $Password = 'P@SSW0RD'){
     $Salt='BGuxLWQtKweKEMV4';
     $StrLen = strlen($String);
     $Seq = $Password;
     $Gamma = '';
     while (strlen($Gamma)<$StrLen){
         $Seq = pack("H*",sha1($Gamma.$Seq.$Salt));
         $Gamma.=substr($Seq,0,8);
     }
      return $String^$Gamma;
  }

if (!$_SESSION['user_id']) {
  if ($_POST['submit']) {
    $dbc = mysqli_connect("127.0.0.1", "root", "", "acon") OR DIE("Error with database connection");
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
    if(!empty($username) && !empty($password)) {
      $query = "SELECT username,password FROM 'users' WHERE username = $username AND password = $password";
      //Work in progress
      $_SESSION['user_id'] = $_POST['username'];
      $_SESSION['user_password'] = $_POST['password'];
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
                    <form method="post" id="loginForm">
                      <input type="text" name="username" placeholder="Имя пользователя" class="loginInputs" maxlength="30">
                      <input type="password" name="password" placeholder="Пароль" class="loginInputs">
                      <input type="submit" name="submit" value="Войти" class="loginButton">
                      <a href="register" name="register" class="loginButton" id="registerButton">Зарегистрироваться</a>
                    </form>
                  <?php
                }
              else{
                  ?>
                    <form method="post">
                      <a href="account" id=accountLink><?= $_SESSION['user_id']?></a>
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
          <button type="submit" id="searchbutton"></button>
        </form>
        <?php if ($fillforms) echo "<p id='about'>Пожалуйста,заполните поля</p>"?>
        <!--Content-->
        <content>
            <div class="container">
