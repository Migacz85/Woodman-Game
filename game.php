<?php
//Picture of woodmean is from site: https://www.artstation.com/artist/kazakov
session_start();

if(!isset($_SESSION['zalogowany']))                     // is the person is logged?
  { //This content is only for logged user
    //if the person is not logged move it to
    header('Location: index.php');
    exit(); // Immediatley!
  }
include "functions.php";
refresh_data_from_database($_SESSION['login'],$_SESSION['pass']);             //This function is taking all the new information from the mysqldatabese. You can find int in functions.php

//PRESS BUTTON SEND LUMBERJACK TO THE WOOD
if (isset($_POST['button'])){
wyslij_drwala(  $_SESSION['login'],$_SESSION['pass'],$_SESSION['login']."drwal_w_las",round(34*$_SESSION['lvl_drwal'],0),$_SESSION['lvl_drwal']*1.3); //This function is in functions.php

lvl_up_drwal( $_SESSION['login'],$_SESSION['pass']);
$login=$_SESSION['login'];
//ask_sql($_SESSION['login'],$_SESSION['pass'],"UPDATE uzytkownicy SET lvl_drwal =lvl_drwal+1 WHERE login = '$login'")   ;                                                                                       //is sending a LumberJack to the wood for 7 units of wood.
}

$login=$_SESSION['login'];
$logindrwal=$login."drwal_w_las";

$powrot_drwala=execute_at($_SESSION['login'],$_SESSION['pass']);  // execute_at is in functions.php // in variable $powrot_drwala we now when LuberJack will comeback with wood!

$page = $_SERVER['PHP_SELF'];                                     //we know at what time woodman will comeback
$sec=60*1;
header("Refresh: $sec; url=$page");                           //This tree lines of code are refreshing a page, its works fine when person is
                                                              //all the time on page but is buggy when not. Refresh page need to be a sekund after LumberJack will combeback.
                                                              //This need to be coded.

$powrot = new DateTime($powrot_drwala);                      //in this 3 lines we are edyting date_time. $powrot meen when he will combeback
$now =new DateTime("Europe/Warsaw");
$powrot_to_java=$powrot->format('M d, Y H:i:s');            //and we changing format of date for java
 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
   <meta charset="utf-8"/>
   <title> Super Duper Game </title>
   <script>                                             //Java script for countDown the time
   // Set the date we're counting down to
   var countDownDate = new Date("<?php
  echo $powrot_to_java;
   ?>").getTime();
   // Update the count down every 1 second
   var x = setInterval(function() {
     // Get todays date and time
     var now = new Date().getTime();
     // Find the distance between now an the count down date
     var distance = countDownDate - now;
     // Time calculations for days, hours, minutes and seconds
     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
     var seconds = Math.floor((distance % (1000 * 60)) / 1000);
     // Display the result in the element with id="demo"
     document.getElementById("demo").innerHTML = days + "d " + hours + "h "
     + minutes + "m " + seconds + "s ";
     // If the count down is finished, write some text
     if (distance < 0) {
       clearInterval(x);
       document.getElementById("demo").innerHTML = "Woodman just arrived";
     }
   }, 1000);
   </script>
 </head>
<body>
<?php
echo "Hi ".$_SESSION['login'];
echo '<a href="logout.php"> wyloguj</a> </br>';
echo  "Your email is:".$_SESSION['email'];
echo "</br>";
echo "Wood: ".$_SESSION['drewno']."| Stone: ".$_SESSION['kamien']." |";
echo "</br>";
$dataczas = new DateTime();
$koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);
echo "</br>";
 ?>
 </br>
 <div id="drwal">
 <form  action="game.php" method="Post">
 <button  class="btn"    type="submit"
<?php if (isset($powrot_drwala)) echo "disabled";  ?>
 name='button' value="Send woodman" >
 </form>
 <?php
//When woodman is in the forest
 if(isset($powrot_drwala) ) {
   echo 'Woodman is in forest he will comeback in: <div id="demo"></div>'; //id = demo is connected with javascript
   echo '<img src="woodman.jpg" height=100> </img>';
   echo "</br> lvl: ".$_SESSION['lvl_drwal'];
   echo "</br> He will bring ".$_SESSION['lvl_drwal']*2.7." units of wood";
   echo "</br> Total time of work on this level is: ".(gmdate("H:i:s",round(34*$_SESSION['lvl_drwal'],0) ));
  //
   unset($_SESSION['drwal']);
 }
//When woodman is doing nothing
if (!isset($powrot_drwala)) {echo 'Woodman is bored </br>Send him to forest </br>';
    echo '<img src="woodman.jpg" height=100> </img>';
    echo "</br> Woodman lvl: ".$_SESSION['lvl_drwal'];
    echo "</br> Wood production: ".$_SESSION['lvl_drwal']*2.7;
    echo "</br> Time of work: ".(gmdate("H:i:s",round(34*$_SESSION['lvl_drwal'],0) ));
    echo "</br>";

  }
 ?>
</button>
 </div>

</body>
</html>
