<!DOCTYPE HTML>
<html lang="pl">
<head>
   <meta charset="utf-8"/>
   <title> Super Duper Game </title>
 </head>
<body>
  <?php
  session_start();
  if(!isset($_POST['login']) || (!isset($_POST['pass'])) )
   {

       unset($_SESSION['blad'])  ;
     header('Location: index.php');
     exit();
   }

  require_once "connect.php";
  $connect = @new mysqli($host,$db_user,$db_password,$db_name);
  if ($connect->connect_errno!=0){
    echo "Bład".$connect->connect_errno;
  } else {

    $login =$_POST['login'];
    $password =$_POST['pass'];
  // zabezpieczenie przed wstrzykiwaniem mysql
  //traktuje wszystko jako string do wyswietlenia
  //sanityzacja kodu ENT_QUOTES - cu
  //  $login = htmlentities($login,ENT_QUOTES,"UTF-8");
  //  $haslo = htmlentities($haslo,ENT_QUOTES,"UTF-8");
  //encje htmla, < &lt; < &gt;

  //  echo "Połączyłem się z sukcesem z mysql:) </br>";
//    $sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND BINARY haslo='$password'";
    if($result=$connect->query(
    sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",
    //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
    mysqli_real_escape_string($connect,$login)
    )))
    {
      $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej


      $ilu_userow = $result->num_rows;
      if($ilu_userow>0){
         $hashhaslo=md5($password);
        // echo $password."</br>";
        // echo $hashhaslo."</br>";
        // echo $wiersz['haslo']; exit();
        if ($wiersz['haslo']==$hashhaslo ) {

              $_SESSION['zalogowany']=true;


              $_SESSION['id']= $wiersz['id'];
              $_SESSION['login'] = $wiersz['login'];
              $_SESSION['drewno'] = $wiersz['drewno'];
              $_SESSION['kamien'] = $wiersz['kamien'];
              $_SESSION['dnipremium'] = $wiersz['dnipremium'];
              $_SESSION['email'] = $wiersz['email'];
              $_SESSION['data_zalozenie_konta']=$wiersz['data_zalozenie_konta'];
              $_SESSION['pass']=$wiersz['haslo'];


              unset($_SESSION['blad'])  ;


              $result->free(); //close{}; free(); free_result();
              header('Location: game.php');
            }else {   $_SESSION['blad']="Błedne haslo";}header('Location: index.php');
        //polaczony
      } else {
        //bledny login lub haslo
        $_SESSION['blad']="Nieprawidlowy login lub haslo, (sprawdź czy nie masz czasem włączonego Caps Locka)";
        header('Location: index.php');
      }


    }

    $connect->close();
  }



echo <<< END
Twoj login to: $login </br>
Twoje haslo to: $password </br>
Kamien: $kamien </br>
Drewno: $drewno </br>
Dni Premium: $premium </br>


END;
  ?>
</body>
</html>
