 <?php 
 session_start();
if(!empty($_SESSION['idetd'])&&empty($_SESSION['idprof'])){
require('../../config.php');
$etdid=$_SESSION['idetd'];$sqletd="";$fname="";$lname="";$numinsetd="";$h=0;$m=0;$sqlmod="";
$modulename="";
$levedeg="";$durexam="";$drtime="";$question="";$formeetd="";$gquestion="";$typeques="";
$cont=0;$nameques="";$correctans="";$etdnote=0;$ntch=0;$ntque=0;$etdans="";$sqlnote="";
$subbtn="";$sqlver="";$correctrep="";$etdrep="";$recivebool='false';
    $sqletd="SELECT etudiante.idniv,etudiante.num_inscription,user.prenom,user.nom FROM etudiante INNER JOIN user ON etudiante.iduser = user.iduser WHERE etudiante.idetd=".$etdid;
    $sqletd=$db->prepare($sqletd);$sqletd->execute();$sqletd=$sqletd->fetch();
    $sqlmod="SELECT 
             CONCAT(
            HOUR(examen.dur_exam)-(HOUR(CURTIME())-HOUR(examen.temp_exam)),'-',
            MINUTE(examen.dur_exam)-( MINUTE(CURTIME())-MINUTE(examen.temp_exam)),    
            SECOND(examen.dur_exam)-( SECOND(CURTIME())-SECOND(examen.temp_exam))
            ) 
             AS THE_REST
             ,module.nom_module ,examen.dur_exam ,examen.idexam FROM module 
             INNER JOIN niveau ON niveau.idniv = module.idniv 
             INNER JOIN examen ON examen.idmod = module.idmod 
             WHERE CURTIME()+0 >= examen.`temp_exam` 
             AND CURTIME()+0<= (examen.`temp_exam` +examen.`dur_exam`)
             AND CURDATE() = examen.`date_exam` AND module.idniv=".$sqletd['idniv'];
    $sqlmod=$db->prepare($sqlmod);$sqlmod->execute();$sqlmod=$sqlmod->fetch();
    $modulename=$sqlmod['nom_module'];$drtime=$sqlmod['dur_exam'];
    switch ($sqletd['idniv']) {
        case '1':
            $levedeg="اولى ليسانس";
            break;
        case '2':
            $levedeg="ثانية ليسانس";
            break;
        case '3':
            $levedeg="ثالثة ليسانس";
            break;
        case '4':
            $levedeg="اولى ماستر";
            break;
        case '5':
            $levedeg="ثانية ماستر";
            break;
    
    }

    $lname=$sqletd['prenom'];$fname=$sqletd['nom'];$numinsetd=$sqletd['num_inscription'];
    $durexam=explode("-",$sqlmod['THE_REST']);
    $question="SELECT question.* FROM examen 
               INNER JOIN module ON examen.idmod = module.idmod 
               INNER JOIN question ON question.idexam = examen.idexam 
               WHERE module.nom_module='".$sqlmod['nom_module']."'";
    $question=$db->prepare($question);$question->execute();$question=$question->fetchAll();
    $subbtn="block";
    if($question==''){$subbtn="none";}
    $formeetd="<form action='' method='post' class='formetd' id ='divetd' onload='etdcont(this.id);' >";
    foreach ($question as $value) {
    $formeetd.="<div class='divetd'><h2><span style='margin-left:30px;'></span>".$value['text_ques'].'</h2><br>';
    switch ($value['type_ques']) {
        case 'vrai_faux':$typeques="radio";$nameques=$cont."ques";
            break;
        case 'seule_choix':$typeques="radio";$nameques=$cont."ques";
            break;
        case 'multi_choix':$typeques="checkbox";$nameques=$cont."ques[]";
            break;        
    }                
    $formeetd.="<div style='margin-left:50px;'></span><span class='gchiox'>";$gquestion=explode(",",$value['choix']);
    foreach ($gquestion as $value2) {
    $formeetd.="<span><label>".$value2."</label><span style='margin-left:20px;'></span>"."<input type='".$typeques."' name='".$nameques."' value='".$value2."'><span style='margin-left:20px;'></span></span>";
    }
    $formeetd.="</div></div>";  
    $cont++;
    }

    $formeetd.='<div class="confirm" id="confirm">
    <h1 style="margin-right:80px;margin-top:30px;">هل أنت متأكد </h1><br>
    
    <button type="button" onclick=\'hide("confirm")\' class=" btnc btn btn-danger no"  id="refuse" name="refuse" >لا</button>

   <button type="submit" class=" btnc btn btn-success yes" id="accepte" id="sendrep" name="sendrep">نعم</button>
    </div>
    <button type="button" onclick=\'show("confirm")\' class=" btnc btn btn-success sumbitetd"   style="display:'.$subbtn.'" >ارسال الاجوبة</button>';
    $formeetd.="</form>";
    $h=$durexam[0];$m=$durexam[1];$cont=0;
     if($question==NULL){$h=0;$m=0;}
     if($sqlmod['idexam']=="")$sqlmod['idexam']='null';
    $sqlver="SELECT * FROM `note` WHERE idetd =".$etdid." AND idexam=".$sqlmod['idexam'];
    $sqlver=$db->prepare($sqlver);$sqlver->execute();$sqlver=$sqlver->fetch();
       if($sqlver!=""){
      $h=0;$m=0;
      $modulename="";$drtime="";
       }
    if(isset($_POST['sendrep'])){ 
    while ($_POST[$cont.'ques']!=""){
        $ntque=0;
        $correctans= explode(",",$question[$cont]['corpns']);
        $ntch=$question[$cont]['note_ques']/count($correctans);
        $etdans=$_POST[$cont.'ques'];
        if(!is_array($etdans)){$etdans=explode(",",$etdans);}
         foreach ($etdans as $ans) {
             foreach ($correctans as $corans) {
             if($ans==$corans)$ntque+=$ntch;
             
             }
          }
          if(count($etdans)>count($correctans))$ntque=0;
          $etdnote+=$ntque;
    $cont++;}

    $sqlnote="INSERT INTO `note` (`note`, `idetd`, `idexam`) VALUES ('".$etdnote."', '".$etdid."', '".
    $sqlmod['idexam']."')";
    $sqlnote=$db->prepare($sqlnote);$sqlnote->execute();
          $recivebool="true";$h=0;$m=0;
          $modulename="";$drtime="";
    }

}elseif(!empty($_SESSION['idprof'])){
  header('Refresh: 0; URL = ../../main-p-prof/page/main-p-prof.php');
}elseif(!empty($_SESSION['idadmin'])){
  header('Refresh: 0; URL = ../../admin/page/admin.php');
}
else{
  header('Refresh: 0; URL = ../../singin/page/index.php');
  }

?> 
<!DOCTYPE html>
<html  dir="rtl">  
	<head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Modal html</title>
    <link rel="stylesheet" href="../../bootstrap/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="../Css/answer.css?<?php echo time(); ?>" />
    </head>
    <body style="background-color: white;" onload="myFunction(<?php echo $h ; ?>,<?php echo $m ; ?>,<?php echo $etdnote ; ?>,<?php echo $recivebool ; ?>)">
    <nav class="navbar navbar-inverse navbar-fixed-top navbarcss">
      <div class="container header">
        <div class="navbar-header ">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span  >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="infoetd">
            <table>
                <tr>
                <td><span class="texttd">الاسم  : </span></td>
                <td><span class="texttd"><?php  echo $lname; ?></span></td>
                </tr>
                
                <tr>
                <td><span class="texttd">اللقب  : </span></td>
                <td><span class="texttd"><?php  echo $fname; ?></span></td>
                </tr>
                
                 <tr>
                <td><span class="texttd">رقم التسجيل   : </span></td>
                <td><span class="texttd"><?php  echo $numinsetd; ?></span></td>
                </tr>
                </table>
 
            </div>
            
                <div class="infomod">
            <table>
                <tr>
                <td><span class="texttd">المقياس  : </span></td>
                <td><span class="texttd"><?php  echo $modulename; ?></span></td>
                </tr>
                
                <tr>
                <td><span class="texttd">المستوى  : </span></td>
                <td><span class="texttd"><?php  echo $levedeg; ?></span></td>
                </tr>
                
                 <tr>
                <td><span class="texttd">المدة   : </span></td>
                <td><span class="texttd"><?php  echo $drtime; ?></span></td>
                </tr>
                </table>
 
            </div>
                   <div id="timer" class="timer">
         
  <span class="distime" id="seconds"></span>
  <span class="distime" id="minutes"></span>
  <span class="distime" id="hours"></span>
 
</div>    
        </div>
         <div class="content">
          
        <div><?php  echo $formeetd; ?></div>    </div>    
      </div>
    </nav>
        <script src="../../bootstrap/bootstrap.js"></script>
        <script src="../../bootstrap/jquery-3.1.1.js"></script>   
        <script src="../js/answer.js?<?php echo time(); ?>"></script>
    </body></html>
