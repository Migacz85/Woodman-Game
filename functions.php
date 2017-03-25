<?php

class worker{
    public $name;
    public $resource;
    public $lvl;
    public $isworking;
    public $endtime;
    public $image;
    public $tableExists;
    public $login;
    public $name_event;
    public $how_long;
    public $production;
    public $timeS;
    public $teraz;
    public $actual_R;
    public $capacity;
    public $cost_wood;
    public $cost_stone;
    public $cost_coal;
    public $cost_gold;
    public $wood;
    public $stone;
    public $coal;
    public $gold;
    public $global_speed;
    public $timeleft; //$this->timeleft - showing when upgrading will be finish

  public function _construct($x){
      $login=$_SESSION['login'];
      //$this->IsHeWorking();
      $now =new DateTime("Europe/London");
      $now->format('Y:m:d H:i:s');
      $this->$teraz=date_format($now, 'Y-m-d H:i:s');
    }
    public function GlobalSpeed($global_speed){ // GLOBAL SPPED CONTROL GLOBAL SPPED OF
        $this->global_speed=$global_speed;     //THE GAME
      return  $this->global_speed;            //rTHIS VARIABLE IS GLOBAL YOU SPEEDING ALL THE PROCES BY INCREASING THE NUMBER
      }
    public function ProductionTime($prod,$time){ //THIS FUNCTION IS FOR INDIVIDUAL SPEED OF
    //  $production=$this->GetLevel()*$time;       //CREATING RESOURCES FOR EACH CHARACTER
    $timeS=round(($time*$this->GetLevel()*7)/$this->GlobalSpeed(20) );
    $this->timeS=$timeS/$this->GlobalSpeed(10); //Round($time/$this->GlobalSpeed(1),0);
    $this->production_speed=$prod/$this->GlobalSpeed(10); //$this->production_speed USE THIS TO CREATE INDIVIDUAL CHARACTER
    }
    public function Cost($cost_wood, $cost_stone,$cost_coal,$cost_gold){
      $progres=1;
      if($progres==1){
      $this->cost_wood=$cost_wood*$this->GetLevel();
      $this->cost_stone=$cost_stone*$this->GetLevel();
      $this->cost_coal=$cost_coal*$this->GetLevel();
      $this->cost_gold=$cost_gold*$this->GetLevel();
                      }
    }
    public function Capacity(){

       return  $this->capacity=$this->GetLevel()*46;

    }

    public function IncreaseCapacity(){
      $newcap=$this->capacity;
      $resources=$this->resources.'_cap';
      $login=$_SESSION['login'];
      $this->WriteSql("UPDATE characters SET $resources = $newcap WHERE login='$login'");
      }

    public function ButtonOnClick(){

      if (isset($_POST[$this->name])){  //Function On Click

        refresh_resources_from_database($_SESSION['login']);
        $this->SendHimToWork();        // WRITING TIME WHEN HE STARTED UPGRADING
        $this->LevelUp(); // CHEKING DO WE HAVE ENAUGH OF RESOURCES
        $this->IncreaseCapacity();                                  //  AND TAKING RESOURCES FROM MYSQL AND LEVELING UP
      }
    }

    public function CreateTable($name,$type){
      include "connect.php";
      $connect = new mysqli($host,$db_user,$db_password,$db_name);
      if ($connect->connect_errno!=0){
        echo "Error on connection to Database, Login or Password is wrong".$connect->connect_errno;
      } else {
        //  echo "Connected :) </br>";
        $login=$_SESSION['login'];
        if($result=@$connect->query(
        sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",
        //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
        mysqli_real_escape_string($connect,$login)
        )))
        {
          $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
          $ilu_userow = $result->num_rows;
          if($ilu_userow>0){

          $result=$connect->query(  "SHOW COLUMNS FROM `characters` LIKE '$name'");
            $tableExists=$result->num_rows;
              if($tableExists==0) //if table dont exists
              {
                      if( $result=$connect->query("ALTER TABLE `characters`  ADD `$name` $type "))
                      {
                              $this->tableExists="Character '$name' added with Succes to MysqlDB";
                      } else  { $this->tableExists="This Sql question is wrong";
                                throw new Exception($connect->error);
                                }
              } else { $this->tableExists="Table already exists";}
        }
        $connect->close();
      }
  return $this->tableExists;
  }
}
    public function AskSql($sql) {
                                  //Function is asking sql question and return num_rows
        include "connect.php";
        $connect = new mysqli($host,$db_user,$db_password,$db_name);
        if ($connect->connect_errno!=0){
          echo "Error on connection to Database, Login or Password is wrong".$connect->connect_errno;
        } else {
          //  echo "Connected :) </br>";
          $login=$_SESSION['login'];

          if($result=@$connect->query(
          sprintf("SELECT * FROM characters WHERE login='%s' ",
          //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
          mysqli_real_escape_string($connect,$login)
          )))
          {
            $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
            $ilu_userow = $result->num_rows;
            if($ilu_userow>0){
              {
            //  $logindrwal=$login."drwal_w_las";
                if( $result=$connect->query($sql))
                  {
                      $ilerekordow=$result->num_rows;
                      $this->tableExists=$ilerekordow;
                  } else { $this->tableExists="This Sql question is wrong";
                 throw new Exception($connect->error);
                }
                  //  $_SESSION['zalogowany']=true;
                //    $result->free(); //close{}; free(); free_result();
                //    header('Location: game.php');
                  }
            } else {
              //bledny login lub haslo

            //  header('Location: index.php');
            }
          }
          $connect->close();
        }
    return $this->tableExists;
    }
    public function WriteSql($sql) {
                                  //Function is asking sql question and return num_rows
        include "connect.php";
        $connect = new mysqli($host,$db_user,$db_password,$db_name);
        if ($connect->connect_errno!=0){
          echo "Error on connection to Database, Login or Password is wrong".$connect->connect_errno;
        } else {
          //  echo "Connected :) </br>";
          $login=$_SESSION['login'];

          if($result=@$connect->query(
          sprintf("SELECT * FROM characters WHERE login='%s' ",
          //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
          mysqli_real_escape_string($connect,$login)
          )))
          {
            $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
            $ilu_userow = $result->num_rows;
            if($ilu_userow>0){
              {
            //  $logindrwal=$login."drwal_w_las";
                if( $result=$connect->query($sql))
                  {
                     //echo "Done!";
                    //    $ilerekordow=$result->num_rows;
                    //  $this->tableExists=$ilerekordow;
                  } else { $this->tableExists="This Sql question is wrong";
                 throw new Exception($connect->error);
                }
                  //  $_SESSION['zalogowany']=true;
                //    $result->free(); //close{}; free(); free_result();
                //    header('Location: game.php');
                  }
            } else {
              //bledny login lub haslo

            //  header('Location: index.php');
            }
          }
          $connect->close();
        }
  ///  return $this->tableExists;
    }
    public function SetResources($x){
      $this->resources=$x;
    }
    public function SetName($x){
      $this->name =$x;
    }
    public function GetName (){
      echo $this->name;
    }
    public function LevelUp(){
        $cost_wood=$this->cost_wood;
        $cost_stone=$this->cost_stone;
        $cost_coal=$this->cost_coal;
        $cost_gold= $this->cost_gold;

          if($cost_wood<=$_SESSION['wood'] && $cost_stone<=$_SESSION['stone'] && $cost_coal<=$_SESSION['coal'] && $cost_gold<=$_SESSION['gold']  ){
          include "connect.php";
          $connect = new mysqli($host,$db_user,$db_password,$db_name);
          if ($connect->connect_errno!=0){
            echo "Error on connection to Database, Login or Password is wrong".$connect->connect_errno;
          } else {
            //  echo "Connected :) </br>";
            $login=$_SESSION['login'];
            if($result=@$connect->query(
            sprintf("SELECT * FROM uzytkownicy WHERE login='%s' ",
            //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
            mysqli_real_escape_string($connect,$login)
            )))
            {
              $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
              $ilu_userow = $result->num_rows;

              if($ilu_userow>0){
                { $levelname=$this->name.'_lvl';
                    $result=$connect->query(  "SHOW COLUMNS FROM `characters` LIKE '$levelname' ");
                    $IsCreated = $result->num_rows;
                    if($IsCreated>0){
                        if( $result=$connect->query(
                          "UPDATE characters SET $levelname=$levelname+1 WHERE login = '$login' "
                        ))
                          {
                            $this->tableExists="Level Up Succes";
                          } else { $this->tableExists="This Sql question is wrong";

                         throw new Exception($connect->error);
                        }
                        $cost=$this->GetLevel()*12;
                        $resources=$this->resources.'_cap';
                        if(  $connect->query(
                          "UPDATE characters SET gold = gold - $cost_gold, coal = coal - $cost_coal, stone = stone - $cost_stone, wood = wood - $cost_wood   WHERE login='$login' " )
                          //UPDATE characters SET wood=0, stone=0,coal=0,gold=0 WHERE login = 'dexter
                        ) { //echo "query ok"f
                          }else { throw new Exception($connect->error);}
                          //  echo $this->actual_R;


                }  else $this->tableExists="Create character in MysqlDb first";
                    //  $_SESSION['zalogowany']=true;
                  //    $result->free(); //close{}; free(); free_result();
                  //    header('Location: game.php');
                    }
              } else {
                //bledny login lub haslo

              //  header('Location: index.php');
              }
            }
            $connect->close();

      //UPDATE `uzytkownicy` SET `superDrwal` = '1' WHERE `uzytkownicy`.`id` = 1;
     return  $this->tableExists;
   }} else echo "Not enaugh resources ";
 }

    public function GetLevel(){

        include "connect.php";
      $connect = new mysqli($host,$db_user,$db_password,$db_name);
      if ($connect->connect_errno!=0){
        echo "Bład".$connect->connect_errno;
      } else {
        if($result=@$connect->query(
        sprintf("SELECT * FROM characters WHERE login='%s' ",
        mysqli_real_escape_string($connect,$_SESSION['login'])
        )))
        {
          $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
          $ilu_userow = $result->num_rows;
          if($ilu_userow>0){
                  $this->lvl=$wiersz[$this->name."_lvl"];
                  $result->free(); //close{}; free(); free_result();
            //polaczony
          } else {
            //bledny login lub haslo
            $this->lvl="Login dosent exist";
          }
        }
        $connect->close();
      }

     return $this-> lvl;
    }
    public function DateIntervalToSec($start,$end){ // as datetime object returns difference in seconds
            $diff = $end->diff($start);
            $diff_sec = $diff->format('%r').( // prepend the sign - if negative, change it to R if you want the +, too
                        ($diff->s)+ // seconds (no errors)
                        (60*($diff->i))+ // minutes (no errors)
                        (60*60*($diff->h))+ // hours (no errors)
                        (24*60*60*($diff->d))+ // days (no errors)
                        (30*24*60*60*($diff->m))+ // months (???)
                        (365*24*60*60*($diff->y)) // years (???)
                        );
            return $diff_sec;
        }

public function IsHeWorking() {

      $login=$_SESSION['login'];
      $name_event=$this->name;
      $resources=$this->resources;
      $how_long=$this->GetLevel();
      $ile=$this->GetLevel();

      {
        include "connect.php";
          $connect = new mysqli($host,$db_user,$db_password,$db_name);
          if ($connect->connect_errno!=0){
            echo "Bład".$connect->connect_errno;
          } else {
          //  echo "Połączyłem się z sukcesem z mysql:) </br>";
            if($result=@$connect->query(
            sprintf("SELECT * FROM characters WHERE login='%s' ",
            //funkcja ta zabezpiecza przed wstrzykiwaniem mysql
            mysqli_real_escape_string($connect,$login)
            )))
            {
              $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej
              $ilu_userow = $result->num_rows;
              if($ilu_userow>0){

                              {$login=$_SESSION['login'];

                  if( $result=$connect->query(
                                "SELECT * FROM characters WHERE login='$login'"
                     ))
                    {
                    $wiersz = $result->fetch_assoc();
                    $finishdate=$wiersz[$name_event];
                    $startdate=$wiersz[$name_event."_start"]; // what is time when worker is started work ?
                    //$capacity=$wiersz[$this->resources."_cap"]; //capacity of resources;

                    $capacity=$this->capacity;
                    $actual_resource=$wiersz[$this->resources];
                    $this->actual_R=$actual_resource;

                    $this->wood=$wiersz['wood'];
                    $this->stone=$wiersz['stone'];
                    $this->coal=$wiersz['coal'];
                    $this->gold=$wiersz['gold'];

                    $this->Capacity(); // <- IN THIS FUNCTION ACTUAL CAPACITY IS COUNTED
                                          // exactly in VARIABLE $this->capacity

                    $_SESSION['wood_cap']=$this->Capacity();//$wiersz['wood_cap'];
                    $_SESSION['stone_cap']=$this->Capacity();//$wiersz['stone_cap'];
                    $_SESSION['coal_cap']=$this->Capacity();//$wiersz['coal_cap'];
                    $_SESSION['gold_cap']=$this->Capacity();//$wiersz['gold_cap'];


                    //what is time when worker will come back ?
                    $powrot = new DateTime($finishdate);
                    $output=$powrot->format('H:i:s');

                    //what is actual time ?
                    $now=new Datetime('Europe/London');
                    $now->format('Y:m:d H:i:s');
                    $now=date_format($now, 'Y-m-d H:i:s');

                //  $interval = $powrot->diff($now);
                  $datetime1 = date_create($finishdate);
                  $datetime3 = date_create($startdate);
                  $datetime2 = date_create($now);

                  $interval=    date_diff($datetime1, $datetime3);
                  $totaltime=    date_diff($datetime3, $datetime1);

                //  echo   $totaltime -> format('%h h %i m  %s s'  );
                //    echo "</br>";
                //  echo   $interval -> format('%h h %i m  %s s'  );

                 $timeleft=$this->DateIntervalToSec($datetime1,$datetime2); //TIME LEFT TO FINISH THE JOB
                 $this->timeleft=$timeleft;

                 $sec=$this->DateIntervalToSec($datetime2,$datetime3); //How many seconds from start he is working ?
                 $sec= round($sec/$this->production_speed,0);
                 $totaltimesec=$this->DateIntervalToSec($datetime1,$datetime3);//What is total time of work

                 $timeSpeed= 0.1*($this->GetLevel())+$this->GetLevel(); // SPEEDING PROCES OF RESOURCES
                // $newresources=round(($totaltimesec*$timeSpeed)/$this->production_speed,0);
              //  echo
               if($finishdate<$now) $timeleft=0;

             //////////////////////////////////////////////////////////////////////// ADDING RESOURCES TO DATABASE

               $this->actual_R;

          //  echo   $this->capacity;
              //  echo $timeleft;
               if($timeleft==0 && $this->capacity!=$this->actual_R ) {
           if($this->capacity>$this->actual_R+$sec)  {  //+$sec                                  //Cheking_capacity of resources;//!!!!
             $nameofguy=$this->name.'_start';
             $connect->query(
               "UPDATE characters SET $nameofguy = '$now' WHERE login='$login'"
             );
             if(  $connect->query(
               "UPDATE characters SET $this->resources = $this->resources + '$sec' WHERE login='$login' " )
             ) { //echo "query ok"
               ;}else { throw new Exception($connect->error);}

             }
             else {//echo "Capacity is on maximum level";
             if(  $connect->query(
               "UPDATE characters SET $this->resources = $this->capacity WHERE login='$login' " )
             ) { //echo "query ok"
               ;}  else { throw new Exception($connect->error);}
             }
           } else {

             $nameofguy=$this->name.'_start';
             $connect->query(
               "UPDATE characters SET $nameofguy = '$now' WHERE login='$login'"
             );
           }
             //////////////////////////////////////////////////////////////////////// LevelUPcharacter

                      //WORKER IS DOING NOTHING
                      if($finishdate<$now ) {$output="Is not working";
                                            if ($timeleft>0){//inotsworking




                                                            }

                                        }
                      //WORKER IS WORKING HARD :)
                      if($finishdate>$now ){
                        $this->time=$sec;
                    //    UPDATE characters SET stone=stone+23 WHERE login ='yater'





                                                   //in this 3 lines we are edyting date_time. $powrot meen when he will combeback

                       $output=$powrot->format('M d, Y H:i:s');
                        $output=$wiersz[$name_event];
                      }
                //    header('Location: game.php');
              } else { $output="zapytanie padło :/";
                   throw new Exception($connect->error);
                  }
                    //  $_SESSION['zalogowany']=true;
                      $result->free(); //close{}; free(); free_result();
                  //    header('Location: game.php');
                    }
              } else {
                //bledny login lub haslo
              $output="Nieprawidlowy login lub haslo, (sprawdź czy nie masz czasem włączonego Caps Locka)";
              //  header('Location: index.php');
              }
            }
            $connect->close();
          }
      }
      return $output;
    }

    public function SendHimToWork(){
      $now =new DateTime("Europe/London");
      $now=$now->format('Y:m:d H:i:s');

            //   $working=$this->IsHeWorking();
            //  if($working=="Is not working"){

              $resources=$this->resources;
              $login=$_SESSION['login'];
                  $name_event=$this->name."_is_working_".$login;
              $this->timeS;
              $how_long=round($this->timeS,0);
              $ile=$this->production;

              include "connect.php";
              $connect = new mysqli($host,$db_user,$db_password,$db_name);
              if ($connect->connect_errno!=0){
                echo "Bład".$connect->connect_errno;
              } else {
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
                    { // $how_long=$this->timeS;   //60*1;
                       $how_long=$how_long." seconds";
                        $date=new Datetime('Europe/London');
                       $date->add(DateInterval::createFromDateString($how_long));
                        $date->format('Y:m:d H:i:s');
                       $future=date_format($date, 'Y-m-d H:i:s');
                      $now=new Datetime('Europe/London');

                      $now->format('Y:m:d H:i:s');
                        $now=date_format($now, 'Y-m-d H:i:s');

                      if( $connect->query(
                    //    "CREATE EVENT $name_event ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL $how_long SECOND DO
                //     UPDATE characters SET $resources =$resources+$ile WHERE login = '$login' "
                    "UPDATE characters SET $this->name = '$future'
                      WHERE login='$login'"
                     ))
                        { $result="He is now working";
                              $nameofguy=$this->name.'_start';
                              $connect->query(
                           "UPDATE characters SET $nameofguy = '$now'  WHERE login='$login'"
                              );

                    //    header('Location: game.php');
                  } else { echo $result="Mysql Query: Something wrong";
                        throw new Exception($connect->error);
                      }
                      //    $_SESSION['zalogowany']=true;
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
        //  } else $result='he is already working! ';
      return $result;
    //  echo $this->isworking="zapierdzielam </br>";
    }

    public function DrawWorker(){
      if($this->cost_wood>$_SESSION['wood']+1 || $this->cost_stone>=$_SESSION['stone']+1 || $this->cost_coal>=$_SESSION['coal']+1|| $this->cost_gold>=$_SESSION['gold']+1 )
        {$ress=1;} else {$ress=0;}  //1you dont have 0 you have resources

      echo '<div class="worker">';
      echo '<form  action="game.php" method="Post">';
      $up='_upgrading';
      $res='_resources';

      if( $this->IsHeWorking()=="Is not working" && $ress==1  )
        {echo "<button  class='$res'  "; if($ress) echo "type='submit' disabled "; }

      if( $this->IsHeWorking()!="Is not working"  )
        {echo "<button  class='$up'  ";  echo "type='submit' disabled "; }

      if( $this->IsHeWorking()=="Is not working" && $ress==0  )
        {echo "<button  class='worker'  "; if($ress) echo "type='submit' disabled "; }

      echo "name='$this->name' value='$this->name' >";
      echo '</form>';

      if($this->IsHeWorking()!="Is not working" ) {
        echo $this->name;
        echo "</br>";
        echo "<img id='img_guys' src='$this->image'";
        echo 'height=100> </img>';
        echo "</br>";
        echo ' Upgrading to:';
        //echo $this->IsHeWorking();
        echo "</br><b> lvl: ".$this ->GetLevel();
        echo "</br></b> Upgrade complete in: ";//.(gmdate("H:i:s",$this->timeS ));

           $timer=$this->name."_timer";

        echo "<div id='$timer'>";
        //echo   $this->timeS;
        echo  "</div>";

        $page = $_SERVER['PHP_SELF'];
        $sec =  $this->timeleft+1;
        header("Refresh: $sec; url=$page");

      }
   if($this->IsHeWorking()=="Is not working") {
         echo "<img id='img_guys' src='$this->image'";
         echo 'height=100> </img>';
         echo "</br> <b>";
         echo $this->name;
         echo "  lvl: ".$this->lvl."</b></br>";
         echo "Actual capacity: ".$this->capacity; echo "</br>";
         echo "production: ".round(((1/$this ->production_speed)*60*10),0)." / 10 min </br>";
         echo "</br>";      echo "<b>Upgrade cost: </b>";echo "</br>";

         if ($_SESSION['wood']<$this->cost_wood) echo "<b>".($this->cost_wood)."</b> wood"; echo "";
         if ($_SESSION['wood']>=$this->cost_wood) echo "".($this->cost_wood)." wood"; echo "</br>";

         if ($_SESSION['stone']<$this->cost_stone) echo "<b>".($this->cost_stone)."</b> stone"; echo "";
         if ($_SESSION['stone']>=$this->cost_stone) echo "".($this->cost_stone)." stone"; echo "</br>";

         if ($_SESSION['coal']<$this->cost_coal) echo "<b>".($this->cost_coal)."</b> coal"; echo "";
         if ($_SESSION['coal']>=$this->cost_coal) echo "".($this->cost_coal)." coal"; echo "</br>";

         if ($_SESSION['gold']<$this->cost_gold) echo "<b>".($this->cost_gold)."</b> gold"; echo "";
         if ($_SESSION['gold']>=$this->cost_gold) echo "".($this->cost_gold)." gold"; echo "</br>";


         if ($ress) echo "You can't upgrade"; else echo "You can upgrade";
      //   echo "</br> Time of work: ".(gmdate("H:i:s",round($this->timeS ,0) ));
      //   echo "</br>";
      //In how many seconds he can start working again?



       }
 // ///////////////// Just working out when site can be refresh when resources are enaugh
 //       $timeWood=0;$timeStone=0;$timeCoal=0;$timeGold=0;
 //
 //       if ($_SESSION['wood']<$this->cost_wood) { $timeWood= ($this->cost_wood-$_SESSION['wood']); }
 //       if ($_SESSION['stone']<$this->cost_stone){ $timeStone= ($this->cost_stone-$_SESSION['stone']);}
 //       if ($_SESSION['coal']<$this->cost_coal){$timeCoal= ($this->cost_coal-$_SESSION['coal']); }
 //       if ($_SESSION['gold']<$this->cost_gold){ $timeGold= ($this->cost_gold-$_SESSION['gold']);}
 //
 //       echo "time wood: ".$timeWood*$this->production_speed."</br>";
 //       echo "time stone: ".$timeStone*$this->production_speed."</br>";
 //       echo "time coal: ".$timeCoal*$this->production_speed."</br>";
 //       echo "time gold: ".($timeGold*$this->production_speed)."</br>";
 //
 //       if ($timeGold>0){
 //      $page = $_SERVER['PHP_SELF'];
 //     $secc = $timeGold*($this->production_speed);
 //    header("Refresh: $secc; url=$page");
 // }
    echo " </button> </div>";



    }

    public function SetImage($x){
      $this->image=$x;
    }
    public function AtWhatTimeHeWillFinish(){
    echo $this ->endtime = "wroci jak wroci";
    }

}

function refresh_resources_from_database($logi)
{
  include "connect.php";

$connect = new mysqli($host,$db_user,$db_password,$db_name);
if ($connect->connect_errno!=0){
  echo "Bład".$connect->connect_errno;
} else {
  $login =$logi;
  if($result=@$connect->query(
  sprintf("SELECT * FROM characters WHERE login='%s' ",
  mysqli_real_escape_string($connect,$login)
  )))
  {
    $wiersz = $result->fetch_assoc(); //zapisz rekord do zmiennej

    $ilu_userow = $result->num_rows;
    if($ilu_userow>0){

            $_SESSION['wood'] = $wiersz['wood'];
            $_SESSION['stone'] = $wiersz['stone'];
            $_SESSION['coal'] = $wiersz['coal'];
            $_SESSION['gold'] = $wiersz['gold'];

        //    $_SESSION['wood_cap'] = $wiersz['wood_cap'];
      //      $_SESSION['stone_cap'] = $wiersz['stone_cap'];
      //      $_SESSION['coal_cap'] = $wiersz['coal_cap'];
      //      $_SESSION['gold_cap'] = $wiersz['gold_cap'];
          //  $_SESSION['dnipremium'] = $wiersz['dnipremium'];


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
function refresh_data_from_database($login)
{
  include "connect.php";
$connect = new mysqli($host,$db_user,$db_password,$db_name);
if ($connect->connect_errno!=0){
  echo "Bład".$connect->connect_errno;
} else {

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
            $_SESSION['email'] = $wiersz['email'];

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
