<?php
//Picture of woodmean is from site: https://www.artstation.com/artist/kazakov
session_start();
ob_start();
if(!isset($_SESSION['zalogowany']))                     // is the person is logged?
  { //This content is only for logged user
    //if the person is not logged move it to
    header('Location: index.php');
    exit(); // Immediatley!
  }
include "functions.php";

$login=$_SESSION['login'];
$logindrwal=$login."drwal_w_las";

//Create New workerk/Character in The game: // This guy will bring stone
$kamieniarz= new worker();
$kamieniarz->setName("Stoneman");
$kamieniarz->SetResources("stone");
$kamieniarz->CreateTable("Stoneman",'DATETIME');
$kamieniarz->CreateTable("stone",'INT NOT NULL');
$kamieniarz->CreateTable("stone_cap",'INT NOT NULL');
$kamieniarz->CreateTable("Stoneman_lvl",'INT NOT NULL');
$kamieniarz->CreateTable("Stoneman_start",'DATETIME');
$kamieniarz->SetImage("stoneman.jpg");
$kamieniarz->productionTime(2,30);


//This Guy will bring wood
$woodman= new worker("Woodman");
$woodman->setName("Woodman");
$woodman->CreateTable("Woodman",'DATETIME'); //in case You dont have him in mysql You need to use this functions Once;
$woodman->SetResources("wood");
$woodman->CreateTable("wood_cap",'INT NOT NULL');
$woodman->CreateTable("wood",'INT NOT NULL');
$woodman->CreateTable("Woodman_lvl",'INT NOT NULL');
$woodman->CreateTable("Woodman_start",'DATETIME');
$woodman->SetImage("woodman.jpg");
$woodman->productionTime(3,25);
//Coal
$coalminer= new worker("CoalMiner");
$coalminer->setName("CoalMiner");
$coalminer->CreateTable("CoalMiner",'DATETIME'); //in case You dont have him in mysql You need to use this functions Once;
$coalminer->SetResources("coal");
$coalminer->CreateTable("coal_cap",'INT NOT NULL');
$coalminer->CreateTable("coal",'INT NOT NULL');
$coalminer->CreateTable("CoalMiner_lvl",'INT NOT NULL');
$coalminer->CreateTable("CoalMiner_start",'DATETIME');
$coalminer->SetImage("coalminer.jpg");
$coalminer->productionTime(7,40);

$goldminer= new worker("GoldMiner");
$goldminer->setName("GoldMiner");
$goldminer->CreateTable("GoldMiner",'DATETIME'); //in case You dont have him in mysql You need to use this functions Once;
$goldminer->SetResources("gold");
$goldminer->CreateTable("gold_cap",'INT NOT NULL');
$goldminer->CreateTable("gold",'INT NOT NULL');
$goldminer->CreateTable("GoldMiner_lvl",'INT NOT NULL');
$goldminer->CreateTable("GoldMiner_start",'DATETIME');
$goldminer->SetImage("goldminer.jpg");
$goldminer->productionTime(10,50);

$coalminer->Cost(15,5,0,10);
$kamieniarz->Cost(24,0,5,17);
$woodman->Cost(2,5,6,0);
$goldminer->Cost(56,70,65,0);

$kamieniarz->isHeworking();   //ADDING NEW RESOURCES TO MYSQL AND CHEKING IS HE FINISHED UPGRADING
$goldminer->isHeWorking();
$woodman->isHeWorking();
$coalminer->isHeworking();

///////////////////////////// Here trying to do Buildings
// $woodstorage = new worker("woodstorage");
// $woodstorage-> setName("woodstorage");
// $woodstorage->CreateTable("woodstorage",'DATETIME');
// $woodstorage->CreateTable("woodstorage_start",'DATETIME');
// $woodstorage->CreateTable("woodstorage_lvl",'INT NOT NULL');
// $woodstorage->SetResources("wood");
// $woodstorage->SetImage("image/tlo2.jpg");
// $woodstorage->Cost(136,234,100,32);
// $woodstorage->productionTime(10,45);

//refresh_resources_from_database($_SESSION['login']); //Getting All variables in $_SESSION['wood,stone,etc']
 $woodman->ButtonOnClick();
 $kamieniarz->ButtonOnClick();
 $goldminer->ButtonOnClick();
 $coalminer->ButtonOnClick();
 refresh_resources_from_database($_SESSION['login']);
//
// if (isset($_POST[$kamieniarz->name])){  //Function On Click
// refresh_resources_from_database($_SESSION['login']);
// $kamieniarz->SendHimToWork();        // WRITING TIME WHEN HE STARTED UPGRADING
// $kamieniarz->LevelUp(); // CHEKING DO WE HAVE ENAUGH OF RESOURCES
// $kamieniarz->IncreaseCapacity();                                  //  AND TAKING RESOURCES FROM MYSQL AND LEVELING UP
// }
//

 // REFRESH RESOURCES IN $_SESSION['wood']
                                                    // CAP_RESOURCES IN $_SESSION['wood_cap']
// $_SESSION['wood_cap']=$woodman->Capacity();
// $_SESSION['stone_cap']=$kamieniarz->Capacity();
// $_SESSION['coal_cap']=$coalminer->Capacity();
// $_SESSION['gold_cap']=$goldminer->Capacity();
//
// echo $_SESSION['wood']." ";
// echo $_SESSION['wood_cap']."<br>";
//
// echo $_SESSION['stone']." ";
// echo $_SESSION['stone_cap']."<br>";
//
// echo $_SESSION['coal']." ";
// echo $_SESSION['coal_cap']."<br>";
//
// echo $_SESSION['gold']." ";
// echo $_SESSION['gold_cap']."<br>";
 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
   <meta charset="ASCI"/>
   <title> Super Duper Game </title>

<?php $javaon=1 ?>
   <script type="text/javascript">   ////// JAVA SCRIPT

    var startTime = new Date();
  //  newvalue=0;


    function get(element,production_speed,capacity,resources){
      var dzisiaj = new Date();
      var red=capacity;
      var newvalue=0;

            //  newvalue=resources;
                //  if(true){ //if he is not upgrading
              if (capacity<=newvalue)  { newvalue=capacity; //newvalue=String(capacity);
                                        //newvalue=newvalue.fontcolor("red");
                                        var red;  red=String(capacity); red.fontcolor("red");

                                      }
              if (capacity>newvalue)  { newvalue=String(resources); // newvalue=newvalue.fontcolor("lightgreen");
                                      newvalue=(((Math.round((dzisiaj-startTime)/1000/production_speed)+resources)));

                                      }

            //  if (capacity>newvalue) { newvalue=(((Math.round((dzisiaj-startTime)/1000/production_speed)+resources))); }
            //    else { newvalue=capacity;newvalue=String(capacity); newvalue=newvalue.fontcolor("red");}

              //  } //else newvalue=resources;
if (production_speed!=999) {
  if (capacity==resources )  {  //red=String(capacity); red.fontcolor("red");    //document.getElementById(element).innerHTML= newvalue;
               red=String(capacity);red=red.fontcolor("red");
        document.getElementById(element).innerHTML= red; } else
         document.getElementById(element).innerHTML= newvalue;
       }

       if (production_speed==999) { var counter=capacity-Math.round((dzisiaj-startTime)/1000);

                              if (capacity<=3600 && capacity>60) {
                               counter=Math.round(counter/60);
                                 document.getElementById(element).innerHTML=counter+" min";
                              }

                              if (capacity<=60)  {
                                counter=capacity-Math.round((dzisiaj-startTime)/1000);
                                document.getElementById(element).innerHTML=counter+" sec";
                              }



                                    if (counter<=0) {document.getElementById(element).innerHTML="Upgrade Complete!".fontcolor("green");}

                                 }
        return newvalue;
      }

function all(){

if (<?php if($woodman->IsHeWorking()=="Is not working") echo "true"; else echo"false";?>) {
  var wood=get('wood',<?php echo $woodman->production_speed; ?>,<?php echo $_SESSION['wood_cap']; ?>,<?php echo $_SESSION['wood']; ?>);
  if(wood > <?php echo $_SESSION['wood_cap']; ?>){get('wood',3,<?php echo $_SESSION['wood_cap']; ?>,<?php echo $_SESSION['wood_cap']; ?>); }
} else {

      get('Woodman_timer',999,<?php echo $woodman->timeleft; ?>,0);
      }

if (<?php if($kamieniarz->IsHeWorking()=="Is not working") echo "true";else echo"false"; ?>) {
  var stone=get('stone',<?php echo $kamieniarz->production_speed; ?>,<?php echo $_SESSION['stone_cap']; ?>,<?php echo $_SESSION['stone']; ?>);
   if(stone> <?php echo $_SESSION['stone_cap']; ?>){get('stone',2,<?php echo $_SESSION['stone_cap']; ?>,<?php echo $_SESSION['stone_cap']; ?>); }
                                                  }else {

                                                  get('Stoneman_timer',999,<?php echo $kamieniarz->timeleft; ?>,0);
                                                  }

if (<?php if($coalminer->IsHeWorking()=="Is not working") echo "true";else echo"false"; ?>) {
  var coal =get('coal',<?php echo $coalminer->production_speed; ?>,<?php echo $_SESSION['coal_cap']; ?>,<?php echo $_SESSION['coal']; ?>);
     if(coal> <?php echo $_SESSION['coal_cap']; ?>){get('coal',7,<?php echo $_SESSION['coal_cap']; ?>,<?php echo $_SESSION['coal_cap']; ?>); }
                                                          }else {

                                                          get('CoalMiner_timer',999,<?php echo $coalminer->timeleft; ?>,0);
                                                          }

if (<?php if($goldminer->IsHeWorking()=="Is not working") echo "true";else echo"false";?>) {
  var gold =get('gold',<?php echo $goldminer->production_speed; ?>,<?php echo $_SESSION['gold_cap']; ?>,<?php echo $_SESSION['gold']; ?>)  ;
     if(gold> <?php echo $_SESSION['gold_cap']; ?>){get('gold',10,<?php echo $_SESSION['gold_cap']; ?>,<?php echo $_SESSION['gold_cap']; ?>); }
                                                }else {

                                                get('GoldMiner_timer',999,<?php echo $goldminer->timeleft; ?>,0);
                                                }

}

function start(){
setInterval("all()",1000);
}

   </script>
 </head>
<body onload=' start(); ' id="game" >

<?php
echo "<div class='top_menu'>";


echo "<div class='menu_tlo'>";
echo "<div class='menu_inside'>";
echo "Hi ".$_SESSION['login'];
echo '<a href="logout.php"> logout</a> </br>';
echo  "Your email is:".$_SESSION['email']."</br>";
echo '</br>';
if ($javaon==1){
  $wood_ico="<img id='ico_res' src='image/wood.png' > </img>";
  $stone_ico="<img id='ico_res' src='image/stone.jpg' > </img>";
  $coal_ico="<img id='ico_res' src='image/coal.jpg' > </img>";
  $gold_ico="<img id='ico_res' src='image/gold.gif' > </img>";
echo '<div class="resources">';

echo '<div class="Label_wood">   Wood:<div  id="wood">'.$_SESSION['wood'].'</div></div>';
echo '<div class="Label_stone">   ', $wood_ico, 'Stone:&nbsp <div  id="stone">'.$_SESSION['stone'].' </div></div>';
echo '<div class="Label_coal">    ', $stone_ico, 'Coal:&nbsp <div  id="coal">'.$_SESSION['coal'].'</div></div>';
echo '<div class="Label_gold">    ',$coal_ico ,'Gold:&nbsp <div  id="gold">'.$_SESSION['gold'].'</div></div>';
echo $gold_ico;
echo '</div>';
}
//echo "</br>";
//echo  "Wood: ".$_SESSION['wood']."| Stone: ".$_SESSION['stone']." | Coal ".$_SESSION['coal']." | Gold ".$_SESSION['gold'];


echo "</div>";
echo "</div>";

$rand=rand(1,7);
echo '<div id="tip">';
echo '<div id="text_tip">';
if ($rand==1) echo  "Interesting facts: When you will refresh the site you will see new resources comming ";
if ($rand==2) echo  "Interesting facts: When characters are working resources increasing. ";
if ($rand==3) echo  "Interesting facts: This simple game was developed by Marcin Mrugacz. ";
if ($rand==4) echo  "Interesting facts: The higher level of each character the higher capacity he have. ";
if ($rand==5) echo "Interesting facts: Resources are coded in java script ";
if ($rand==6) echo "Interesting facts: Main programing language here is PHP";
if ($rand==7) echo "Interesting facts: Database used here is MySql";
echo "</div>";
echo "</div>";



echo "</div>"; // END OF TOP MENU

//$dataczas = new DateTime();
//$koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);

 ?>


<div id=wrapper>
<?php

echo '<div id="left">';
echo "<div id='Label_characters'> Characters: </div>";
//Drawing Workers :)
echo "<div class='characters'>";
$woodman->DrawWorker();
$kamieniarz->DrawWorker();
$coalminer->DrawWorker();
$goldminer->DrawWorker();
echo "</div>";
echo "<div id='Label_characters'> Buildings: </div>";

//$woodstorage->DrawWorker();
echo "</div>";//div left


echo '<div id="right">';

echo " Hey here will be some extra informations"."</br>";
echo " about autor and game itself"."</br>";
echo " and what methods was used here"."</br>";
echo "</div>";

echo "</div>";


$page = $_SERVER['PHP_SELF'];
$sec = "10";
//header("Refresh: 2; url=$page");
?>
</div>

 </div>

</body>
</html>
