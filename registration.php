<?php
session_start();

$a=7; $b=2;
$_SESSION['a']=$a;$_SESSION['b']=$b;
if (isset($_POST['Remail'])) //sprawdza czy submit zostal wyslany
{                          //i czy zmienne w ogole zostaly stworzone
//udana walidacja
 $OKform=true;
//////////////

 $nick=$_POST['Rnick'];
$_SESSION['nick']=$nick;
/////////////////NICK
 if(strlen($nick)<3 || strlen($nick)>20)
 {
   $OKform=false;
   $_SESSION['e_nick']="Nick musi posiadac od 3 do 20";
 }
 //Poprawny nick
 if(strlen($nick)>2 && strlen($nick)<21)
 {
   $_SESSION['e_nick']="Nick Ok ";
 }

 if(ctype_alnum($nick)==false) {
   $_SESSION['e_nick']="Nick może składac się tylko z liter i cyfr bez spacji";
    $OKform=false;
 }
///////////////email
$_SESSION['email']=$_POST['Remail'];
$email=$_POST['Remail'];
$emailB=filter_var($email,FILTER_SANITIZE_EMAIL);

if(filter_var($emailB,FILTER_VALIDATE_EMAIL)==false || $emailB!=$email )
{
$_SESSION['e_email']="Podany email jest niepoprawny";
 $OKform=false;
} else {$_SESSION['e_email']='Email Ok';}

$pass1=$_POST['Rpass'];
$pass2=$_POST['Rpass2'];

if(isset($pass1) || isset($pass2) )
{
  if($pass1!=$pass2) {$_SESSION['e_pass']='Podane hasła się nie zgadzały'; unset($_SESSION['pass']);  $OKform=false; }
  if(strlen($pass1)<=5 ) {$_SESSION['e_pass']='Hasło musi miec minimalnie 6 znakow i mniej niz 20 znakow'; unset($_SESSION['pass']);  $OKform=false;}
  if(strlen($pass1)==strlen($pass2) && strlen($pass1)>=6) {$_SESSION['e_pass']="Hasło Ok";
    $_SESSION['pass']=$pass1;
   }
}

if (!isset($_POST['regulamin'])) {
$_SESSION['e_regulamin']="Musisz potwierdzic regulamin"; $OKform=false;
} else {unset($_SESSION['e_regulamin']);}

if(isset($_POST['test']) ) {

//$_SESSION['e_test']="Rozwiąż proste zadanie";
$wynikusera=$_POST['test'];
if($wynikusera!=($a+$b)) {$_SESSION['e_test']="Wynik nie poprawny"; $OKform=false;  }
if($wynikusera==($a+$b))  $_SESSION['e_test']="Wynik poprawny";

 //$a=rand(1,10); $b=rand(1,10);
}

require_once "connect.php";
try {
$polaczenie= new mysqli($host,$db_user,$db_password,$db_name);

  if($polaczenie->connect_errno!=0) {
    throw new Exception(mysqli_connect_errno() ) ;
  } else {
 //POLACZONY Z DATABASE :)
 //Sprawdzam czy email juz istnieje:
    $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
    if(!$rezultat) throw new Exception($polaczenie->error);
    $ile_takich_maili=$rezultat->num_rows;
    if($ile_takich_maili>0) {
      $_SESSION['e_email']="Podany email jest już zarejestrowany";
      $OKform=false;
    }
//Sprawdzam czy w bazie jest juz nick
    $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE login='$nick'");
    if(!$rezultat) throw new Exception($polaczenie->error);
    $ile_nickow=$rezultat->num_rows;
    if($ile_nickow>0) {
      $OKform=false;
      $_SESSION['e_nick']="Podany nick jest juz zajety";
    }
    if($OKform==true && $wynikusera==$a+$b){ $pass=md5($pass1);
    //  $aktualna_data=date("Y-m-d",time());
    //  $data_wygasniecia=Date('y:m:d', strtotime("+30 days"));
        if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,'$nick','$email','$pass',100,100,1,now()+INTERVAL 14 DAY,NULL)"))
          {
          $_SESSION['Udana_rejestracja']=true;
          header('Location: login.php');
          } else {
          throw new Exception($polaczenie->error);
        }
        //zwolnienie pamieci
        unset($_SESSION['e_test']);
        unset($_SESSION['test']);
        unset($_SESSION['R_email']);
        unset($_SESSION['R_nick']);
        unset($_SESSION['nick']);
        unset($_SESSION['email']);
        unset($_SESSION['Remail']);
        unset($_SESSION['e_email']);
        unset($_SESSION['Rpass']);
        unset($_SESSION['Rpass2']);
        unset($_SESSION['pass']);
        unset($_SESSION['e_pass']);
        unset($_SESSION['e_regulamin']);
        unset($_SESSION['regulamin']);
      }

    $polaczenie->close();
  }

}
catch(Exception $e)
{
  echo "Błąd serwera";
  echo "Informacja developerska".$e;
}

}// w nawiasach wykonuje sie tylko po nacisnieciu przycisku
 ?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
   <meta charset="utf-8"/>
   <title> SuperDuperGra </title>
<link rel="stylesheet" type="text/css" href="style.css">
 </head>

<body>
  <!-- REJESTRACJA  -->
  Zarejestruj się: </br>

  <form action="registration.php" method="post">

   nick: <br /> <input type="text" name="Rnick" value="<?php
   if(isset($_SESSION['nick'])) echo $_SESSION['nick'];unset($_SESSION['nick']);  ?>"/> </br>
 <?php if(isset($_SESSION['e_nick'])==true) {
   echo $_SESSION['e_nick']; unset($_SESSION['e_nick']); }
   ?>
 </br>

   email: <br /> <input type="text" name="Remail" value="<?php
   if(isset($_SESSION['email'])==true) {
     echo $_SESSION['email']; unset($_SESSION['email']); }
     ?>"
   /> </br>
   <?php if(isset($_SESSION['e_email'])) {
     echo $_SESSION['e_email']; unset($_SESSION['e_email']); } ?>
</br>
   Password <br /> <input type="password" name="Rpass" value="<?php if( isset($_SESSION['pass']) ) echo $_SESSION['pass'];   ?>"/> </br>
   Repeat pass: <br /> <input type="password" name="Rpass2" value="<?php if( isset($_SESSION['pass']) ) echo $_SESSION['pass'];  unset($_SESSION['pass']); ?>"/> </br>
  <?php

  if (isset($_SESSION['e_pass'])==true )echo $_SESSION['e_pass'];
  unset($_SESSION['e_pass']); ?>
</br>
  <label>
   <input type="checkbox" name="regulamin" <?php
   if (isset($_POST['regulamin'])) { echo "checked"; } else echo "";
  unset($_SESSION['regulamin']);
   ?>
   " /> Akceptuje regulamin
 </br>
   <?php if (isset($_SESSION['e_regulamin'])) echo $_SESSION['e_regulamin']; unset($_SESSION['regulamin']); ?>
</br>
 </label>

 Udowodnij że nie jestes robotem:
 <?php
 echo "Ile jest ".$a."+".$b." ?";
 ?>
 </br> <input type="text" name="test" >  </br>

 <?php
if(isset($_SESSION['e_test'])) echo $_SESSION['e_test']; unset($_SESSION['e_test']);

 ?>

  <input type="submit", value="Zarejestruj sie"/>
  </form>


</body>
</html>
