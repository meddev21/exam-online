<?php 
session_start();
if(empty($_SESSION['idetd'])&&!empty($_SESSION['idprof'])){
require('../../config.php');
$idprof=$_SESSION['idprof'];$modulprof="";$mpsql="";$tbodyres="";$tbodypub="";$pubsql="";$indice=0;
$resulte="";$selected="";$idprof=2;
$mpsql="SELECT module.nom_module 
            FROM moduprof 
            INNER JOIN module ON moduprof.idmod = module.idmod
            WHERE moduprof.idprof =".$idprof;
$mpsql=$db->prepare($mpsql);$mpsql->execute();$mpsql=$mpsql->fetchAll(PDO::FETCH_ASSOC);
foreach ($mpsql as $value){
$modulprof.="<option value=".$indice.">".$value['nom_module']."</option>";$indice++;
}
$resultsql="SELECT etudiante.num_inscription , user.prenom , user.nom , note.note
            FROM etudiante 
            INNER JOIN user ON etudiante.iduser=user.iduser 
            INNER JOIN note ON etudiante.idetd=note.idetd 
            WHERE note.idexam IN (SELECT examen.idexam 
                      FROM examen 
                      INNER JOIN module ON examen.idmod=module.idmod 
                      WHERE module.nom_module= ? AND examen.idprof=".$idprof.")";
$resultsql=$db->prepare($resultsql);
$resultsql->execute(array($mpsql[0]['nom_module']));
$resulte=$resultsql->fetchAll(PDO::FETCH_ASSOC);
$tbodyres="<tr>";                                                        
foreach ($resulte as $value) {
foreach ($value as $value2) {
$tbodyres.="<td>".$value2."</td>";}}
$tbodyres.="</tr>";
if(isset($_POST['show'])){
$modulprof="";$indice=0;
foreach ($mpsql as $value){
if($indice==$_POST['modulch']){$selected="selected";}else{$selected="";}
$modulprof.="<option ".$selected." value=".$indice.">".$value['nom_module']."</option>";$indice++;
}

$resultsql->execute(array($mpsql[$_POST['modulch']]['nom_module']));
$resulte=$resultsql->fetchAll(PDO::FETCH_ASSOC);
                                                        
foreach ($resulte as $value) {
  $tbodyres.="<tr>";
foreach ($value as $value2) {
$tbodyres.="<td>".$value2."</td>";}$tbodyres.="</tr>";}

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
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>الامتحان على الخط</title>

    <link href="../../bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../Css/main-p-prof.css?<?php echo time(); ?>" rel="stylesheet">
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
                    <li><a href="../../edit_exam/page/edit.php">تعديل امتحان</a></li>
                    <li><a href="../../createexam/page/createexam.php">انشاء امتحان</a></li>
                  </ul>
            <div class="image">
              <img src='../img/a0.jpg'>
              </div>
       
        </div><!--/.navbar-collapse -->    
      </div>
    </nav>
    
    <div class="firstdiv" id="up">
		<img src ="../img/aa1.jpg" style="width:100%; height:100%"/> 
    </div>
      <div class="seconddiv" id="result">
    <h1 class="titre"> نتاج الطلبة  </h1>
           <div class="arrowbac">
			<a class="up-arrow" href="#up" data-toggle="tooltip" title="الى الأعلى">
               <img src="../img/icon.png"/>
			</a>
          </div>  
         
          <div class="resultat">
       <div class="action">  
           <form action="" method="post">
              <select style=" width: 102px;margin-bottom: 20px;" name="modulch">
           <?php echo $modulprof; ?>
           </select>
  <button style="padding-top: 1px;padding-bottom: 2px;margin-right: 20px;" type="submit" class=" btn btn-primary" name="show"> عرض</button>
             </form>
              </div> 
            <table class="table table-condensed first">
    <thead>
      <tr>
        <th>رقم تسجيل الطالب</th>
        <th>اسم الطالب</th>
        <th>لقب الطالب</th>
        <th>نقطة الطالب</th>
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
			<img src ="../img/images.jpg" style="width:100%; height:100%"/> 
          
            <div class="arrowback">
          <a class="up-arrow" href="#up" data-toggle="tooltip" title="الى الأعلى">
                <img src="../img/icon.png"/>
              </a>
          </div>  
          
          
    </div>
    </body>
    
</html>
