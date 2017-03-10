<?php
session_start();
if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true) )
  {  header('Location: game.php');
    exit();
  }

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
   <meta charset="utf-8"/>
   <title> Super Game </title>
<link rel="stylesheet" type="text/css" href="style.css">
 </head>

<body id="indextlo">
  Welcom in super game where you can immerse yourself:)
  <?php
 if(isset($_SESSION['Udana_rejestracja']) ) { echo "</br> Z powodzeniem założyłeś konto. Możesz się logowac :) </br>";
  unset( $_SESSION['Udana_rejestracja'] );
 }
  ?>
  <form action="login.php" method="post">

  Login: <br/> <input type="text" name="login" /> </br>
  Password: <br/> <input type="password" name="pass" /> </br>

  <input type="submit", value="Zaloguj się"/>
  <a href="registration.php"> Register </a>
</form>

  <?php
  if(isset($_SESSION['blad'])) echo $_SESSION['blad']; unset($_SESSION['blad']);

  ?>

  <?php
  /*
  $to = "marcin.mrugacz.85@gmail.com";
  $subject = "Hej ho! Rejestracja;
  $txt = "Wystarczy tylko ze klikniesz w link i bedziesz zarejestrowany";
  $headers = "From: SuperDuperGame" . "\r\n" .
  "CC: somebodyelse@zarki-letnisko.com";

  mail($to,$subject,$txt,$headers);
  */
  ?>



</body>
</html>
