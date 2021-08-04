<?php 
session_start();
if(!empty($_SESSION['idadmin'])){
require('../../config.php');
$deletfun="a";
$option= array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'");
$db = new PDO($dns,$user,$pass,$option);
$db ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
$ord="SELECT `type`,`num_inscription_etd`,`num_inscription_prof`,`prenom`,`nom` FROM `orders`";
$ord=$db->prepare($ord);$ord->execute();
$ord=$ord->fetchAll();
$filltable='';$buttons='';$j=0;
if(count($ord)!=0){
for ($i=0;$i<count($ord); $i++){
if($ord[$i][0]=='etudiant'){$j=1;}else{$j=2;}  
    $filltable=$filltable.'    <tr id="tr'.$i.'"> 
                        <td style="width: 4%;padding-left: 0px;padding-r<?php echo $filltable; ?>ight: 0px;"><input type="checkbox" id="chek'.$i.'" name="select[]" value="'.$i.'" onclick="check()"></td>
                      <td>'.$ord[$i][0].'<input type="hidden" value="'.$ord[$i][0].'" name="type'.$i.'" ></td>
                      <td>'.$ord[$i][$j].'<input type="hidden" value="'.$ord[$i][$j].'" name="numberins'.$i.'" ></td>
                      <td>'.$ord[$i][3].'<input type="hidden" value="'.$ord[$i][3].'" name="lname'.$i.'" ></td>
                      <td>'.$ord[$i][4].'<input type="hidden" value="'.$ord[$i][4].'" name="fname'.$i.'" ></td>
                 </tr>'; 
}
$buttons='<button type="submit" class=" btnc btn btn-danger"  id="refuse" name="refuse">رفض</button>

        <button type="submit" class=" btnc btn btn-success" id="accepte" name="accepte">قبول</button>';
if(isset($_POST['refuse'])){
foreach ($_POST['select'] as $value) {
  $numberinsep=$_POST['numberins'.$value];
$typeep = $_POST['type'.$value];
if($typeep =='etudiant'){$etdprof='num_inscription_etd';}else {$etdprof='num_inscription_prof';}
$delet='DELETE FROM `orders` WHERE `type`="'.$typeep.'" AND `'.$etdprof.'` ="'.$numberinsep.'"';
$delet=$db->prepare($delet);$delet->execute();
}

header("Refresh:0");
}
if(isset($_POST['accepte'])){

foreach ($_POST['select'] as $value) {
  $numberinsep=$_POST['numberins'.$value];
$typeep = $_POST['type'.$value];
if($typeep =='etudiant'){
 $etdprof='num_inscription_etd';}else {$etdprof='num_inscription_prof';}
 $ordaccept=$db->prepare("SELECT * FROM `orders`");$ordaccept->execute();
 $ordaccept=$ordaccept->fetchAll();
 $usersql="INSERT INTO `user` (`iduser`, `username`, `password`, `type`, `nom`, `prenom`) 
 VALUES (NULL, '".$ordaccept[$value]['username']."', '".$ordaccept[$value]['password']."', '".$ordaccept[$value]['type']."', '".$ordaccept[$value]['nom']."', '".$ordaccept[$value]['prenom']."')";

$usersql=$db->prepare($usersql);$usersql->execute();
$ID = $db->lastInsertId(); 

if($typeep =='etudiant'){
$level=$db->prepare("SELECT `idniv` FROM `niveau` WHERE `nom_niveau`='".$ordaccept[$value]['niveau_etd']."'");$level->execute();$level= $level->fetch();
$etdsql="INSERT INTO `etudiante` (`idetd`, `iduser`, `idniv`, `num_inscription`, `groupe`) 
VALUES (NULL, '".$ID."', '".$level[0]."', '".$ordaccept[$value]['num_inscription_etd']."', '".$ordaccept[$value]['group_etd']."')";echo $etdsql;
$etdsql=$db->prepare($etdsql);$etdsql->execute();echo "fininnnnnnsh";
}else{
$profsql="INSERT INTO `professeur` (`idprof`, `iduser`, `num_inscription_prof`) VALUES (NULL, '".$ID."', '".$ordaccept[$value]['num_inscription_prof']."')";//echo $profsql."AND ";
$profsql=$db->prepare($profsql);$profsql->execute();
$ID = $db->lastInsertId();
$insertmodprof=$ordaccept[$value]['module-prof'];$insertmodprof=rtrim($insertmodprof,',');
$insertmodprof=split(",",$insertmodprof);             
foreach ($insertmodprof as $idmodval) {
$moduprof=$db->prepare("INSERT INTO `moduprof` (`idprof`, `idmod`) VALUES ('".$ID."', '".$idmodval."')");
$moduprof->execute();
}
}
}

foreach ($_POST['select'] as $value) {
  $numberinsep=$_POST['numberins'.$value];
$typeep = $_POST['type'.$value];
if($typeep =='etudiant'){$etdprof='num_inscription_etd';}else {$etdprof='num_inscription_prof';}
$delet='DELETE FROM `orders` WHERE `type`="'.$typeep.'" AND `'.$etdprof.'` ="'.$numberinsep.'"';
$delet=$db->prepare($delet);$delet->execute();
}
header("Refresh:0");

}

 }
}elseif(!empty($_SESSION['idetd'])){
  header('Refresh: 0; URL = ../../main-p-etudient/page/main-p-etudinet.php');
}elseif(!empty($_SESSION['idprof'])){
  header('Refresh: 0; URL = ../../main-p-prof/page/main-p-prof.php');
}
else{
  header('Refresh: 0; URL = ../../singin/page/index.php');
  } 
?>
<!DOCTYPE html> 
<html lang="ar">
    <head>
        <meta charset="utf-8"/>
        <title>ADMIN</title> 
      
           <link rel="stylesheet" href="../../bootstrap/bootstrap.css"/>
          <link rel="stylesheet" href="../CSS/admin.css?<?php echo time(); ?>"/> 
    </head>
    <body>
        
        <nav class="navbar navbar-inverse navbar-fixed-top navbarc">
      <div class="container">
        <div class="navbar-header ">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar2" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span>
          </button>
    </div>
        
          <div id="navbar2" class="navbar-collapse collapse">
      
              <ul class="nav navbar-nav navbar-right">
                    <li><a href="#result">تسجيل الخروج</a></li>
                  </ul>
            <div class="image">
              <img src="../image/proveyourself3.png">
              </div>
 
       
        </div><!--/.navbar-collapse -->    
      </div>
    </nav><br><br>
        
        <header>
            <h1>المدير</h1>
            <br/> 
            <h4>لوحة التحكم</h4>
        </header>
        <nav>
            <ul>
                <li></li>
            </ul>
        </nav>
        <form action="" method="post"> 
        <article>

            <section class="tableContainer">
              <table>
                <thead>
                    <tr>
          <th style="width: 40px;padding-left: 0px;padding-right: 22px;"><input type="checkbox" id="chekall" name="selectall" value="all" onclick="checkall()"></th>    
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;النوع</th>
                        <th>رقم التسجيل</th>
                        <th>الاسم</th>
                        <th>اللقب</th>
                    </tr> </thead>
                  <tbody name="neworder" class="orders" style="background: white;">  
       
                    <?php echo $filltable; ?>
                     </tbody>
                </table>
            </section> 
            <section>
            
            </section>
        </article>
        <?php echo $buttons; ?>
        </form>


        <script src="../JavaScript/admin.js?<?php echo time(); ?>"></script>
    </body> 
</html>

