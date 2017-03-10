<?php

function lvl_up_drwal($logi,$pas) {
  include "connect.php";
    $connect = new mysqli($host,$db_user,$db_password,$db_name);
    if ($connect->connect_errno!=0){
      echo "Bład".$connect->connect_errno;
    } else {
      $login =$logi;
      $password =$pas;
    //  echo "Połączyłem się z sukcesem z mysql:) </br>";
    //    $sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND BINARY haslo='$password'";
      if($result=@$connect->query(
      sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",
      //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
      mysqli_real_escape_string($connect,$login)
      )))
      {
        $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
        $ilu_userow = $result->num_rows;
        if($ilu_userow>0){
          // echo $password."</br>";
          // echo $hashhaslo."</br>";
          // echo $wiersz['haslo']; exit();
        //  if ($wiersz['haslo']==$pas )
          {$login=$_SESSION['login'];
        //  $logindrwal=$login."drwal_w_las";
            if( $result=$connect->query("UPDATE uzytkownicy SET lvl_drwal =lvl_drwal+1 WHERE login = '$login' "))
              {
       //$wiersz = $result->fetch_assoc();

          //    header('Location: game.php');
        } else { $_SESSION['drwal']="zapytanie padło :/";
             throw new Exception($connect->error);
            }
              //  $_SESSION['zalogowany']=true;
            //    $result->free(); //close{}; free(); free_result();
            //    header('Location: game.php');
              }
        } else {
          //bledny login lub haslo
          $_SESSION['blad']="Nieprawidlowy login lub haslo, (sprawdź czy nie masz czasem włączonego Caps Locka)";
        //  header('Location: index.php');
        }
      }
      $connect->close();
    }

//return $wiersz['EXECUTE_AT'];
}

function execute_at($logi,$pas) {
  include "connect.php";
    $connect = new mysqli($host,$db_user,$db_password,$db_name);
    if ($connect->connect_errno!=0){
      echo "Bład".$connect->connect_errno;
    } else {
      $login =$logi;
      $password =$pas;
    //  echo "Połączyłem się z sukcesem z mysql:) </br>";
    //    $sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND BINARY haslo='$password'";
      if($result=@$connect->query(
      sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",
      //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
      mysqli_real_escape_string($connect,$login)
      )))
      {
        $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
        $ilu_userow = $result->num_rows;
        if($ilu_userow>0){
          // echo $password."</br>";
          // echo $hashhaslo."</br>";
          // echo $wiersz['haslo']; exit();
        //  if ($wiersz['haslo']==$pas )
          {$login=$_SESSION['login'];
          $logindrwal=$login."drwal_w_las";
            if( $result=$connect->query("SELECT EXECUTE_AT FROM INFORMATION_SCHEMA.EVENTS
               WHERE EVENT_NAME = '$logindrwal'   "))
              {
       $wiersz = $result->fetch_assoc();

          //    header('Location: game.php');
        } else { $_SESSION['drwal']="zapytanie padło :/";
             throw new Exception($connect->error);
            }
              //  $_SESSION['zalogowany']=true;
                $result->free(); //close{}; free(); free_result();
            //    header('Location: game.php');
              }
        } else {
          //bledny login lub haslo
          $_SESSION['blad']="Nieprawidlowy login lub haslo, (sprawdź czy nie masz czasem włączonego Caps Locka)";
        //  header('Location: index.php');
        }
      }
      $connect->close();
    }

return $wiersz['EXECUTE_AT'];
}


function wyslij_drwala($logi, $pas, $nazwa, $czas, $ile_drewna) {
include "connect.php";
  $connect = new mysqli($host,$db_user,$db_password,$db_name);
  if ($connect->connect_errno!=0){
    echo "Bład".$connect->connect_errno;
  } else {
    $login =$logi;
    $password =$pas;
  //  echo "Połączyłem się z sukcesem z mysql:) </br>";
  //    $sql = "SELECT * FROM uzytkownicy WHERE login='$login' AND BINARY haslo='$password'";
    if($result=@$connect->query(
    sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",
    //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
    mysqli_real_escape_string($connect,$login)
    )))
    {
      $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
      $ilu_userow = $result->num_rows;
      if($ilu_userow>0){
        // echo $password."</br>";
        // echo $hashhaslo."</br>";
        // echo $wiersz['haslo']; exit();
      //  if ($wiersz['haslo']==$pas )
        {
          if( $connect->query("CREATE EVENT $nazwa ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL '$czas' SECOND DO
         UPDATE uzytkownicy SET drewno =drewno+'$ile_drewna' WHERE login = '$login' "))
            {
        //    header('Location: game.php');
      } else { // $_SESSION['drwal']="Drwal jest w lesie";
        //    throw new Exception($connect->error);
          }
              $_SESSION['zalogowany']=true;
              $result->free(); //close{}; free(); free_result();
          //    header('Location: game.php');
            }
      } else {
        //bledny login lub haslo
        $_SESSION['blad']="Nieprawidlowy login lub haslo, (sprawdź czy nie masz czasem włączonego Caps Locka)";
      //  header('Location: index.php');
      }
    }
    $connect->close();
  }
}

function refresh_data_from_database($logi,$pas)
{
  include "connect.php";
$connect = new mysqli($host,$db_user,$db_password,$db_name);
if ($connect->connect_errno!=0){
  echo "Bład".$connect->connect_errno;
} else {

  $login =$logi;
  $password =$pas;

  if($result=@$connect->query(
  sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",

  mysqli_real_escape_string($connect,$login)
  )))
  {
    $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej


    $ilu_userow = $result->num_rows;
    if($ilu_userow>0){
            $_SESSION['id']= $wiersz['id'];
            $_SESSION['login'] = $wiersz['login'];
            $_SESSION['drewno'] = $wiersz['drewno'];
            $_SESSION['kamien'] = $wiersz['kamien'];
          //  $_SESSION['dnipremium'] = $wiersz['dnipremium'];
            $_SESSION['email'] = $wiersz['email'];
          //  $_SESSION['data_zalozenie_konta']=$wiersz['data_zalozenie_konta'];
            $_SESSION['pass']=$wiersz['haslo'];
            $_SESSION['lvl_drwal']=$wiersz['lvl_drwal'];


            unset($_SESSION['blad'])  ;


            $result->free(); //close{}; free(); free_result();
          //  header('Location: game.php');

      //polaczony
    } else {
      //bledny login lub haslo
      $_SESSION['blad']="Nieprawidlowy login lub haslo, (sprawdź czy nie masz czasem włączonego Caps Locka)";

    }


  }

  $connect->close();
}


}


?>
