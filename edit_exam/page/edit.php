<?php 
 session_start();
if(empty($_SESSION['idetd'])&&!empty($_SESSION['idprof'])){
require('../../config.php');
$examsql="";$button="";$idprof=2;$i=0;$filltable="";$dateexam="";$timeexam="";$durexam="";$quesexam="";
$quessql="";$questions="";$question="";$cpannelvi="none";$sqlquesdelet="";$choosetype="";$sqlqeus="";
$idex="";$quesarr="";$selectch="";$selectchnew="";$yesno="";$yes_nocor="";$yes_noinc="";
$onech="";$onechcor="";$onechinc="";$multich="";$multicor="";$multiinc="";$updateexam="";$updatequest="";
$deletequery="";
$option= array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'");
$db = new PDO($dns,$user,$pass,$option);
$db ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
$examsql="SELECT examen.date_exam,examen.temp_exam,examen.dur_exam , module.nom_module,examen.idexam
          FROM examen 
          INNER JOIN module ON examen.idmod=module.idmod
          WHERE examen.idprof =  ".$idprof;
$examsql=$db->prepare($examsql);$examsql->execute();$examsql=$examsql->fetchAll(PDO::FETCH_NUM);
foreach ($examsql as $value){
  $filltable.='<tr id="tr'.$i.'"> 
                        <td style="width: 4%;padding-left: 0px;padding-right: 0px;"><input type="radio" name="select" value="'.$i.'" onclick="check()"></td>';
for ($in=0; $in <4 ; $in++) {
 $filltable.='<td>'.$value[$in].'<input type="hidden" value="'.$value[$in].'" name="numberins'.$i.'" ></td>';
}

$i++;}
$quessql="SELECT question.*  
          FROM question 
          WHERE question.idexam=?";
$questions=$db->prepare($quessql);

$buttons='<button type="submit" class=" btnc btn btn-danger"  id="delete" name="delete">حذف</button>
        <button type="submit" class=" btnc btn btn-warning" id="edit" name="edit">تعديل</button>';
if(isset($_POST['edit'])){
$dateexam=$examsql[$_POST['select']][0];$timeexam=$examsql[$_POST['select']][1];
$durexam=$examsql[$_POST['select']][2];
$questions->execute(array($examsql[$_POST['select']][4]));
$question=$questions->fetchAll(PDO::FETCH_NUM);
foreach ($question as $key => $value){
$quesexam.="<option value='".$key.$examsql[$_POST['select']][4]."'>".$value[3]."</option>";
}//echo json_encode($question,JSON_UNESCAPED_UNICODE);
$cpannelvi="block";
$choosetype='  <option value="none">إختر نوع السؤال</option>
               <option value="'.$examsql[$_POST['select']][4].'one">إختيار واحد</option>
               <option value="'.$examsql[$_POST['select']][4].'multi">إختيار متعدد</option>
               <option value="'.$examsql[$_POST['select']][4].'true_false">صح أو خطا</option>';

}
if(isset($_POST['delete'])){
$deletequery="DELETE FROM question WHERE question.idexam=".$examsql[$_POST['select']][4].";
DELETE FROM examen WHERE examen.idexam=".$examsql[$_POST['select']][4];
echo $deletequery;
$deletequery=$db->prepare($deletequery);$deletequery->execute();header("Refresh:0");
}
if(isset($_POST['deletequest'])){
$idex=(int)(substr($_POST['chooseques'],-2));
$quesarr=(int)(substr($_POST['chooseques'],0,1));
$questions->execute(array($idex));
$question=$questions->fetchAll(PDO::FETCH_NUM);
$sqlquesdelet="DELETE FROM question WHERE question.idques=".$question[$quesarr][0];

 $sqlquesdelet=$db->prepare($sqlquesdelet);
 $sqlquesdelet->execute();
}
if(isset($_POST['addd'])){
$dateexam=$_POST['examdate'];$timeexam=$_POST['examtime'];$durexam=$_POST['examduration'];

if($_POST['choose']!='none'){
$idex=(int)(preg_replace("/[^0-9]/","",$_POST['choose']));
$selectch=str_replace($idex,"",$_POST['choose']);
$updateexam="UPDATE examen SET examen.dur_exam='".$durexam."',examen.temp_exam='".$timeexam."',examen.date_exam='".$dateexam."' WHERE examen.idexam=".$idex;
$updateexam=$db->prepare($updateexam);$updateexam->execute();

switch ($selectch) {
  case 'one':
    $selectchnew='seule_choix';
    break;
  case 'multi':
    $selectchnew='multi_choix';
    break;
  case 'true_false':
    $selectchnew='vrai_faux';
    break;
  
}
$sqlqeus="INSERT INTO `question` (`idques`, `idexam`, `type_ques`, `text_ques`, `note_ques`, `corpns`, `choix`) VALUES (NULL, '".$idex."', ?, '".$_POST['textexam']."', '".$_POST['pointexam']."', ?, ?)"; 
         $sqlqeus=$db->prepare($sqlqeus);
      if($selectch=='true_false'){
          if($_POST['yes_no']==1){$yes_nocor="صحيح";}
          else{$yes_nocor="خطا";}
          $yes_noinc="صحيح,خطا";
           $sqlqeus->execute(array($selectchnew,$yes_nocor,$yes_noinc));
echo "INSERT INTO `question` (`idques`, `idexam`, `type_ques`, `text_ques`, `note_ques`, `corpns`, `choix`) VALUES (NULL, '".$idex."',".$selectchnew.", '".$_POST['textexam']."', '".$_POST['pointexam']."', ".$yes_nocor.", ".$yes_noinc.")";           
      }
       if($selectch=='one'){
          foreach ($_POST['quesinfo'] as $value1) { 
              if($value1!=$_POST['quesinfo'][$_POST['onechoise']]){$onechinc.=$value1.',';}
              else{$onechcor=$value1;
                  $onechinc.=$value1.',';
              }
            }
                   $onechinc=rtrim($onechinc,',');
                   $sqlqeus->execute(array($selectchnew,$onechcor,$onechinc));
echo "INSERT INTO `question` (`idques`, `idexam`, `type_ques`, `text_ques`, `note_ques`, `corpns`, `choix`) VALUES (NULL, '".$idex."',".$selectchnew.", '".$_POST['textexam']."', '".$_POST['pointexam']."', ".$onechcor.", ".$onechinc.")";
       }
       if($selectch=='multi'){
        foreach ($_POST['quesinfo'] as $value) {
          foreach ($_POST['multi'] as $valuec) {
                  if($value==$_POST['quesinfo'][$valuec]){$multicor.=$value.',';}
                           }}
             $multiinc=implode(",",$_POST['quesinfo']);
            $multicor=rtrim($multicor,',');
            $sqlqeus->execute(array($selectchnew,$multicor,$multiinc));           
echo "INSERT INTO `question` (`idques`, `idexam`, `type_ques`, `text_ques`, `note_ques`, `corpns`, `choix`) VALUES (NULL, '".$idex."',".$selectchnew.", '".$_POST['textexam']."', '".$_POST['pointexam']."', ".$multicor.", ".$multiinc.")";     
                       }
////////////////////////////////////////////////////////////////////////////////////////////////
}
else{
$idex=(int)(substr($_POST['chooseques'],-2));   
$quesarr=(int)(substr($_POST['chooseques'],0,1));
$questions->execute(array($idex));
$question=$questions->fetchAll(PDO::FETCH_NUM);
$selectchnew=$question[$quesarr][2];
//UPDATING EXAM
$updateexam="UPDATE examen SET examen.dur_exam='".$durexam."',examen.temp_exam='".$timeexam."',examen.date_exam='".$dateexam."'WHERE examen.idexam=".$idex;
echo $updateexam."   2";
$updateexam=$db->prepare($updateexam);$updateexam->execute();

$updatequest="UPDATE question set question.text_ques='".$_POST['choosequestion']."',question.note_ques=".$_POST['choosequestionn'].",question.corpns=?,question.choix=?  WHERE question.idques=".$question[$quesarr][0];
$updatequest = $db->prepare($updatequest);
 if($selectchnew=='vrai_faux'){
          if($_POST['yes_no']==1){$yes_nocor="صحيح";}
          else{$yes_nocor="خطا";}
          $yes_noinc="صحيح,خطا";

           $sqlqeus->execute(array($selectchnew,$yes_nocor,$yes_noinc));
          $updatequest->execute(array($onechcor,$yes_noinc));
echo "UPDATE question set question.text_ques='".$_POST['choosequestion']."',question.note_ques=".$_POST['choosequestionn'].",question.corpns='".$yes_nocor."',question.choix='".$yes_noinc."'  WHERE question.idques=".$question[$quesarr][0];
      }
       if($selectchnew=='seule_choix'){
          foreach ($_POST['quesinfo'] as $value1) { 
              if($value1!=$_POST['quesinfo'][$_POST['onechoise']]){$onechinc.=$value1.',';}
              else{$onechcor=$value1;
                  $onechinc.=$value1.',';
              }
            }
                   $onechinc=rtrim($onechinc,',');
                   $updatequest->execute(array($onechcor,$onechinc));
echo "UPDATE question set question.text_ques='".$_POST['choosequestion']."',question.note_ques=".$_POST['choosequestionn'].",question.corpns='".$onechcor."',question.choix='".$onechinc."'  WHERE question.idques=".$question[$quesarr][0];
       }
       if($selectchnew=='multi_choix'){
        foreach ($_POST['quesinfo'] as $value) {
          foreach ($_POST['multi'] as $valuec) {
                  if($value==$_POST['quesinfo'][$valuec]){$multicor.=$value.',';}
                           }}
             $multiinc=implode(",",$_POST['quesinfo']);
            $multicor=rtrim($multicor,',');
            $updatequest->execute(array($multicor,$multiinc));           

                       }


}header("Refresh:0");
} 

}elseif(!empty($_SESSION['idetd'])){
  header('Refresh: 0; URL = ../../main-p-etudient/page/main-p-etudinet.php');
}elseif(!empty($_SESSION['idadmin'])){
  header('Refresh: 0; URL = ../../admin/page/admin.php');
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
          <link rel="stylesheet" href="../CSS/edit.css?<?php echo time(); ?>"/> 
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
                    <li><a href="../../singin/page/logout.php">تسجيل الخروج</a></li>
                    <li><a href="../../main-p-prof/page/main-p-prof.php">الصفحة الرئيسية</a></li>
                    <li><a href="../../createexam/page/createexam.php">انشاء امتحان</a></li>
                  </ul>
            <div class="image">
              <img src="../image/proveyourself3.png">
              </div>
 
       
        </div><!--/.navbar-collapse -->    
      </div>
    </nav><br><br>

        <header>
            <h1>التعديل</h1>
            <br/> 
            
        </header>
        <nav>
            <ul>
               
            </ul>
        </nav>
        
        <form action="" method="post"> 
        <article>

            <section class="tableContainer">
              <table>
                <thead>
                    <tr>    
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;تاريخ الامتحان</th>
                        <th>توقيت الامتحان</th>
                        <th>مدة الامتحان</th>
                        <th>المقياس</th>
                    </tr> </thead>
                  <tbody name="neworder" class="orders" style="background: white;">  
                <?php echo $filltable; ?>
                     </tbody>
                </table></section> 
        </article>
                   <?php echo $buttons; ?>
        </form>
                <div class="cpannel" id="cpannel" style="display: <?php echo $cpannelvi; ?>">
                    <form action="" method="post">
                    <button type="button" class="btn btn-danger btn-sm closebt" onclick="closeit()">
                        <span>×</span></button>
        <div class="timeexam">
                    <span style="margin-left:87px;"></span><abbr title="أدخل تاريخ الإمتحان">
                        <input type="date" name="examdate" id="data" value=<?php echo $dateexam; ?>>
                    </abbr><span style="margin-left:27px;"></span>   
                    <abbr title="أدخل وقت الإمتحان">
                        <input type="time" name="examtime" id="timeex" value=<?php echo $timeexam; ?>>
                    </abbr> <span style="margin-left:27px;"></span>                               
                    <abbr title="أدخل مدة الامتحان">
                        <input type="time" name="examduration" id="time" value=<?php echo $durexam; ?>>
                    </abbr> 
            <button type="button" class=" btnc btn btn-warning" id="editquest" name="editquest"> تعديل السؤال</button>
         <button type="button" class=" btnc btn btn-success"  id="addingquest" name="addingquest">إضافة السؤال</button>
        
                   </div>
                    <div class="currentques" id="currentques">
                      <select class="selectpicker" id="chooseques" name="chooseques">
                      <?php echo $quesexam; ?>
                      </select><span style="margin-left:30px;"></span>
                    <button type="button" onclick='showch(<?php echo json_encode($question,JSON_UNESCAPED_UNICODE); ?>)' class=" btn btn-success" id="show" name="show">عرض</button>
            <button type="submit" class=" btnc btn btn-danger" id="deletequest" name="deletequest"> حذف السؤال</button>    
                           
                      <button class="btn btn-success" id="addchoise" type="button" id="addchose" style="display: block;margin-right:310px;margin-top:-9%;">
                        <span class="glyphicon glyphicon-plus" ></span> إضافة إختيار
                    </button> <br>
                        <abbr title="نص السؤال">
                        <input type="text" name="choosequestion" id="choosequestion">
                    </abbr>
                        <abbr title="نقطة السؤال">
                        <input type="number" name="choosequestionn" id="choosequestionn">
                    </abbr>
                    </div>
                    
                  <div class="texttype" id="texttype"><span style="margin-left:130px;"></span>   
                <select class="selectpicker" id="choose" name="choose">
  <?php echo $choosetype; ?>
</select>
  <span style="margin-left:87px;"></span><abbr title="أدخل نص السؤال ">
                        <input type="text" name="textexam" id="textexam" >
                    </abbr>
                        <span style="margin-left:87px;"></span><abbr title="أدخل نقطة السؤال ">
                        <input type="number" name="pointexam" id="pointexam" style="margin-right: 150px;margin-top: 10px;" >
                    </abbr>
                </div>
                  <div class="questool">
                    <div class="qeuscont" id="qeuscont"></div>             
                           
                    <button class="btn btn-success btntools1" type="button" id="addchose" style="display: block;">
                        <span class="glyphicon glyphicon-plus" ></span> إضافة إختيار
                    </button>
                        <button class="btn btn-success btntools2" type="submit" id="add" name="addd" style="display: block;">
                        <span class="glyphicon glyphicon-plus"></span> تغيير
                    </button>
                    </div>  
                 </form>
                    </div>               
        <script src="../../bootstrap/bootstrap.js"></script>
        <script src="../../bootstrap/jquery-3.1.1.js"></script>
        <script src="../JavaScript/edit.js?<?php echo time(); ?>"></script>
    </body> 
</html>

