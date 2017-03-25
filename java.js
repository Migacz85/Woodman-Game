
    var startTime = new Date();
function czas() {

    resources=<?php echo $_SESSION['wood'] ?>

   var dzisiaj = new Date();
    var sekunda = dzisiaj.getSeconds();
   var minuta = dzisiaj.getMinutes();
   var godzina = dzisiaj.getHours();
   var dzien = dzisiaj.getDate();
   var miesiac = dzisiaj.getMonth();
   var rok = dzisiaj.getYear();

   if (<?php if($woodman->IsHeWorking()=="Is not working") {echo "true"; } else echo "false";?>){ //if is not upgrading ?
   newvalue=(((Math.round((dzisiaj-startTime)/1000/3)))+resources);} else    //Here number 3 is a speed of producing wood
   {newvalue=<?php echo $_SESSION['wood'];?>}

   if (<?php echo $_SESSION['wood_cap'] ?> < newvalue )  //if to much resources red color
   {newvalue= String(  <?php echo $_SESSION['wood_cap']; ?>); newvalue=newvalue.fontcolor("red"); }
   document.getElementById("wood").innerHTML=newvalue;



   setTimeout("czas()",1000);
}

setTimeout("get('wood',3,<?php echo $_SESSION['wood_cap']; ?>,<?php echo $_SESSION['wood']; ?>)",1000);
setTimeout("get('stone',2,<?php echo $_SESSION['stone_cap']; ?>,<?php echo $_SESSION['stone']; ?>)",1000);
setTimeout("get('coal',7,<?php echo $_SESSION['coal_cap']; ?>,<?php echo $_SESSION['coal']; ?>)",1000);
setTimeout("get('gold',10,<?php echo $_SESSION['gold_cap']; ?>,<?php echo $_SESSION['gold']; ?>)",1000);
