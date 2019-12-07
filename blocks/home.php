<h1 id="about">Welcome to home.</h1>
<?
if ($_SESSION['user_id']){
    echo $_SESSION['user_password'];
    echo "<p id='about'>Password length: ".strlen($_POST['password'])."</p>";
    echo encode($_SESSION['user_password']);
}
?>