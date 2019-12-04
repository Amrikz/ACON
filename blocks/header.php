<?php session_start(); ?>
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
             <a href="#" class="topLinks" id=accountLink>Аккаунт</a>
      </div>
  </header>
      <div id=wrapper>
        <!--Поле поиска-->
          <form action="" method="GET" id=search>
          <input name="search" placeholder="Искать здесь..." type="search">
          <button type="submit" id="searchbutton"></button>
        </form>
        <!--Content-->
        <content>
            <div class="container">