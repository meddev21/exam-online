<?php 
session_start();
if(empty($_SESSION['idetd'])&&!empty($_SESSION['idprof'])){
require('../../config.php');
$idproff=2;$idmodd="";$examsql="";$contid=0;$choix="";$yes_nocor="";$yes_noinc="";
$multicor="";$multiinc="";$onechcor="";$onechinc="";$yesno="vrai_faux";$ID=0;
$multich="multi_choix";$onech="seule_choix";$id=0;$infoques="none";$infomod="block";$vermulti=true;

    $mod="SELECT module.`nom_module`
          FROM module
          INNER JOIN moduprof ON moduprof.`idmod`=module.`idmod` AND moduprof.`idprof`=".$idproff." ";
    $mod=$db->prepare($mod);$mod->execute();$mod=$mod->fetchAll();
    
    $cont=0;
    $chmodules ='<select name="modsel" class="select-type" name="selectmod"  onchange="subject(this.value,\'moduleE\')">';
    foreach ($mod as $value) { 
      	$chmodules=$chmodules.'<option value="'.$value[0].'">'.$value[0].'</option>'; $cont++;}
                 $chmodules .='</select>';
    
    if(isset($_POST['createxame'])){
     $idmodd="SELECT `idmod` FROM `module` WHERE `nom_module`='".$_POST['modsel']."'"; 
     $idmodd=$db->prepare($idmodd);$idmodd->execute();$idmodd=$idmodd->fetchAll();
     $examsql="INSERT INTO `examen` (`idexam`, `idprof`, `idmod`, `dur_exam`, `temp_exam`, `date_exam`) 
               VALUES (NULL, '".$idproff."', '".$idmodd[0][0]."', '".$_POST['examduration']."', '".$_POST['examtime']."', '".$_POST['examdate']."')";
  
 
    $examsql=$db->prepare($examsql);$examsql->execute();
    $infoques="block";$infomod="none";
    } 
    if(isset($_POST['addques'])){
    	$ID =$db->prepare("SELECT `idexam` FROM examen ORDER BY `idexam` DESC LIMIT 1");$ID->execute();
    	$ID = $ID ->fetchAll();
    	$sqlqeus="INSERT INTO `question` (`idques`, `idexam`, `type_ques`, `text_ques`, `note_ques`, `corpns`, `choix`) VALUES (NULL, '".$ID[0][0]."', ?, '".$_POST['titleexam']."', '".$_POST['pointexam']."', ?, ?)"; 
         $sqlqeus=$db->prepare($sqlqeus);
      if($_POST['selectquesch']=='yas_no'){
          if($_POST['yes_no']=="صحيح"){$yes_nocor="صحيح";}
          else{$yes_nocor="خطا";}
          $yes_noinc="صحيح,خطا";
           $sqlqeus->execute(array($yesno,$yes_nocor,$yes_noinc));
              
      }
       if($_POST['selectquesch']=='un'){
          foreach ($_POST['quesinfo'] as $value1) { 
              if($value1!=$_POST['quesinfo'][$_POST['onechoise']]){$onechinc.=$value1.',';}
              else{$onechcor=$value1;
                  $onechinc.=$value1.',';
              }
            }
                   $onechinc=rtrim($onechinc,',');
                   $sqlqeus->execute(array($onech,$onechcor,$onechinc));
       }
       if($_POST['selectquesch']=='deux'){
        foreach ($_POST['quesinfo'] as $value) {
        	foreach ($_POST['multi'] as $valuec) {
                  if($value==$_POST['quesinfo'][$valuec]){$multicor.=$value.',';}
        	                 }}
             $multiinc=implode(",",$_POST['quesinfo']);
            $multicor=rtrim($multicor,',');
        	  $sqlqeus->execute(array($multich,$multicor,$multiinc));           
              
        	             }

$infoques="block";$infomod="none";
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
<html>
	<head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Modal html</title>
        <link href="../../bootstrap/bootstrap.css" rel="stylesheet" />
        <link type="text/css" rel="stylesheet" href="../Css/style.css?<?php echo time(); ?>" />
        <link type="text/css" rel="stylesheet" href="../Css/styleContent.css?<?php echo time(); ?>" /> 
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
      
              <ul class="nav navbar-nav navbar-right" style="
    height: 65px;
">
                    <li><a href="../../singin/page/logout.php">تسجيل الخروج</a></li>
                    <li><a href="../../main-p-prof/page/main-p-prof.php">الصفحة الرئيسية</a></li>
                    <li><a href="../../edit_exam/page/edit.php">تعديل امتحان</a></li>
                  </ul>
            <div class="image">
              <img src="../image/proveyourself3.png">
              </div>
 
       
        </div><!--/.navbar-collapse -->    
      </div>
    </nav>
        
    <footer class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        </div>
        
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">

            <div >
                
                <div class="navbar-form navbar-right" style="display:<?php echo $infomod; ?>">
                   <form method="POST" action="">
                    <label><h3 class="qs" >إسم المقياس</h3></label>
                    <span style="margin-left:57px;"></span><abbr title="أدخل إسم مادة الامتحان">
                        <?php echo $chmodules; ?>

                    </abbr>    
                    <br>
                    
                    <label><h3 class="qs"  >تاريخ الامتحان</h3></label>
                    <span style="margin-left:57px;"></span><abbr title="أدخل تاريخ الإمتحان">
                        <input type="date" name="examdate" id="data" oninput="subject(this.value,'dateE')">
                    </abbr>    
                    <br>
                    
                    <label><h3 class="qs" >وقت اجراء الامتحان</h3></label>
                    <abbr title="أدخل وقت الإمتحان">
                        <input type="time" name="examtime" id="timeex" oninput="subject(this.value,'dateE')">
                    </abbr>    
                    <br>
                    
                    <label><h3 class="qs"  >مدة الامتحان</h3></label>
                    <span style="margin-left:69px;"></span><abbr title="أدخل مدة الامتحان">
                        <input type="time" name="examduration" id="time" oninput="subject(this.value,'timeE')">
                    </abbr>    
                    <br>
                    <span style="margin-left:350px;"></span>
                        <button name="createxame" disabled class="btn btn-success"  id="buttonexam" type ="submit">

                        انشاء امتحان
                        </button> 
                </form> 
                </div>
              
                <div class="navbar-form navbar-left" id="leftside" style="display:<?php echo $infoques; ?>">
                   <form method="POST" action="">
                    <label><h3 class="qs" >عنوان السؤال</h3></label>
                    <abbr title="أدخل عنوان السؤال">
                        <input type="text" id="titleQus" class="form-title" placeholder="ادخل السؤال..." name="titleexam"/>
                    </abbr>
                    <br>
                    
                    <label><h3 class="qs" >نقطة السؤال</h3></label>
                    <span style="margin-left:10px;"></span>
                    <abbr title="أدخل نقطة السؤال">
                        <input name="pointexam" type="number" id="notQus" placeholder="أدخل نقطة السؤال...">
                    </abbr>    
                    <br>    

                    <button class="btn btn-success" id="conform" type="button">
                        <span class="glyphicon glyphicon-pencil"></span> تمارين...
                    </button>                    
                    <br>
                    
                    <label><h3 class="qs" >نوع السؤال</h3></label>
                    <span style="margin-left:30px;"></span>
                    <abbr title="إختر نوع السؤال">
                        <select class="select-type" id="Type-question" name="selectquesch">
                            <option value="no" style="background-color:blue">إختر نوع السؤال</option>
                            <option value="un">إختيار واحد</option>
                            <option value="deux">إختيار متعدد</option>
                            <option value="yas_no">صح ام خطئ</option>
                        </select>
                    </abbr>    

                    <div id="a1"></div>
                    <br>
                    
                    <button class="btn btn-success" type="button" id="add">
                        <span class="glyphicon glyphicon-plus"></span> إضافة سؤال
                    </button>

                    <button class="btn btn-success" name="addques" type="submit" id="net">
                        <span class="glyphicon glyphicon-plus"></span> إضافة الامتحان
                    </button>
                    </form> 

                </div>
            
            </div> 
                
          </div>  
        </div>
        </footer>
        
        <div class="content">
            <div class="Brand">وزارة التعليم العالي والبحث العلمي<br>جامعة الشهيد حمة لخضر - الوادي</div>
            <span class="titleModel" >المقياس : <span id="moduleE"></span></span>
            <span class="titleModel" >التاريخ : <span id="dateE"></span></span>
            <span class="titleModel" >الوقت : <span id="timeE"></span></span>
            
            <hr/>
            
            <div id="exam">
            </div>
            
        </div>
        
 <script src="../../bootstrap/bootstrap.js"></script>
        <script src="../../bootstrap/jquery-3.1.1.js"></script>   
        <script src="../js/create_exam.js?<?php echo time(); ?>"></script>
    </body>
</html>
