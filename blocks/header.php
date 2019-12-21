<?php
  session_start();

  require "lib/db.php";
  require "lib/mainFunctions.php";

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
              <a href="films" class="topLinks">Фильмы</a>
              <a href="serials" class="topLinks">Сериалы</a>
              <a href="mults" class="topLinks">Мультфильмы</a>
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
                      <div class="signUpDiv">
                      	<a href="account" id=accountLink><?= $_SESSION['user_username']?></a>
                      	<?php
                      		$role = level('',1);
	                      	if ($role <= 3) { 
	                          ?>
	                     		  <div class='dropdown-signup'>
								            <a href='moderator' name='register' class='managingButton'>Модерирование</a>
								            <?php
									        if ($role <= 2) {
										        echo "<a href='admin' name='register' class='managingButton'>Администрирование</a>";
									        } 
								          ?>
						  		        </div>
						  		        <?php
	                     	}
					  	          ?>
					            </div>
                      <input type="submit" name="exit" class="loginButton" id="logout" value="Выходишь?">
                    </form>
                  <?php
                }
              ?>
      </div>
  </header>
      <div id=wrapper>
        <!--Поле поиска-->
          <form action="search" method="GET" id=search>
            <input name="search" placeholder="Искать здесь..." type="search" id="searchinput">
            <button type="submit" id="searchbutton" name="search_query" value="1" ><i class="fas fa-search" id="searchsymbol"></i></button>
          </form>
        <?php
        if ($fillforms) echo "<p id='message'>Пожалуйста,заполните поля</p>";
        if ($wrongLogin) echo "<p id='message'>Извините, вы должны ввести правильные имя пользователя и пароль</p>";
        						//<a href='forgot' id='forgot'>Забыли пароль?</a>";
        ?>
        <!--Content-->
        <content>
            <div class="container">
