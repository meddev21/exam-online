<?php 
session_start();
if(!empty($_SESSION['idetd'])&&empty($_SESSION['idprof'])){
require('../../config.php');
$idetd=$_SESSION['idetd'];$resultsql="";$tbodyres="";$tbodypub="";$pubsql="";$note0="";$setnote0="";
$sqlnote="";$notever="";
$note0="SELECT examen.dur_exam ,module.nom_module,examen.idexam
FROM module 
INNER JOIN examen ON examen.idmod=module.idmod 
WHERE module.idniv IN (SELECT etudiante.idniv 
                       FROM etudiante 
                       WHERE etudiante.idetd=".$idetd.") 
AND IF(CURDATE() = examen.`date_exam` ,examen.`temp_exam`+examen.`temp_exam`,
CURDATE() > examen.`date_exam` )";
$note0=$db->prepare($note0);$note0->execute();$note0=$note0->fetchAll(PDO::FETCH_ASSOC);
if($note0!=''){
  foreach ($note0 as $value) {
    $notever="SELECT * FROM note WHERE note.idetd=".$idetd." AND note.idexam=".$value['idexam'];
    $notever=$db->prepare($notever);$notever->execute();$notever=$notever->fetchAll(PDO::FETCH_ASSOC);
    if(empty($notever)){
    $sqlnote="INSERT INTO `note` (`note`, `idetd`, `idexam`) VALUES ('0', '".$idetd."', '".
    $value['idexam']."')";
    $sqlnote=$db->prepare($sqlnote);$sqlnote->execute();
    }
}
}
$resultsql="SELECT module.nom_module,note.note,module.coeff_modul
            FROM examen 
            INNER JOIN note ON examen.idexam=note.idexam
            INNER JOIN module ON examen.idmod=module.idmod
            WHERE note.idetd =".$idetd;
$resultsql=$db->prepare($resultsql);$resultsql->execute();$resultsql=$resultsql->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultsql as $value){
$tbodyres.="<tr>";                                                      
foreach ($value as $value2) {
$tbodyres.="<td>".$value2."</td>";
}
$tbodyres.="<td>".$value['note']*$value['coeff_modul']."</td>";
$tbodyres.="</tr>";
}
echo $tbodyres;
$pubsql="SELECT module.nom_module,examen.date_exam,examen.temp_exam 
         FROM examen
         INNER JOIN module ON examen.idmod = module.idmod
         WHERE module.idniv IN (SELECT etudiante.idniv FROM etudiante WHERE etudiante.idetd=1)
         AND  examen.date_exam > CURDATE();";
$pubsql=$db->prepare($pubsql);$pubsql->execute();$pubsql=$pubsql->fetchAll(PDO::FETCH_ASSOC);
foreach ($pubsql as $value){
$tbodypub.="<tr>";                                                        
foreach ($value as $value2) {
$tbodypub.="<td>".$value2."</td>";
}
$tbodypub.="</tr>";
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
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>الامتحان على الخط</title>

    <link rel="stylesheet" href="../../bootstrap/bootstrap.css"/>
    <link href="../Css/main-p-etudinet.css?<?php echo time(); ?>" rel="stylesheet">
  </head>
<body >
    <nav class="navbar navbar-inverse navbar-fixed-top navbarc" >
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
                    <li><a href="../../singin/page/logout.php" >تسجيل الخروج</a></li>
                    <li><a href="#result" >معاينة النتائج</a></li>
                    <li><a href="#pub">الاعلانات</a></li>
                    <li><a href="../../answer/page/answer.php">اجراء امتحان</a></li>
                  </ul>
            <div class="image">
              <img src='../img/a0.jpg'>
              </div>
 
       
        </div><!--/.navbar-collapse -->    
      </div>
    </nav>
    
    <div class="firstdiv" id="up">
     <img src="../img/a1.jpg" style="width:100%; height:100%"/>
    </div>
      <div class="seconddiv" id="result">
    <h1 class="titre"> نتاج الامتحانات  </h1>
          
          <div class="arrowback">
          <a class="up-arrow" href="#up" data-toggle="tooltip" title="الى الأعلى">
                <img src="../img/icon.png"/>
              </a>
          </div>  
          <div class="resultat">

            <table class="table table-condensed first">
    <thead>
      <tr>
        <th>اسم المقياس</th>
        <th>نقطة الامتحان</th>
        <th>المعامل</th>
        <th>معدل المقياس</th>
        </tr>
    </thead>
    <tbody>
      <?php  echo $tbodyres; ?>
    </tbody>
  </table>
            
        
       

          </div>
          
    </div>
      <div class="thirddiv" id="pub">
    <h1 class="titre2"> الاعلانات</h1>
          
            <div class="arrowback">
          <a class="up-arrow" href="#up" data-toggle="tooltip" title="الى الأعلى">
                <img src="../img/icon.png"/>
              </a>
          </div>  
          
             <div class="resultat">

            <table class="table table-condensed second">
    <thead>
      <tr>
        <th>اسم المقياس</th>
        <th>تاريخ الامتحان</th>
        <th>توقيت الامتحان</th>
        </tr>
    </thead>
    <tbody >
      <?php  echo $tbodypub; ?>
    </tbody>
  </table>
          

          </div>
          
    </div>
    
    </body>
    
</html>
