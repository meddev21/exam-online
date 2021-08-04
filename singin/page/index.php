<?php 

require('../../config.php');
session_start();
if(!empty($_SESSION['idetd'])){
  header('Refresh: 10; URL = ../../main-p-etudient/page/main-p-etudinet.php');
 
}
elseif(!empty($_SESSION['idprof'])){
  header('Refresh: 0; URL = ../../main-p-prof/page/main-p-prof.php');
}else{
 $modul='';$modulp='';$dis="none";$idqerry="";

$licence1="SELECT `nom_module` FROM `module` WHERE `idniv`=1 ORDER BY `idmod`";
$licence1=$db->prepare($licence1);$licence1->execute();
$licence1=$licence1->fetchAll(PDO::FETCH_COLUMN);
foreach ($licence1 as $modullevel){$modul =$modul.$modullevel.',';}$modul=rtrim($modul,',');
   if(isset($_POST['signin2'])){
$result = $db->prepare("SELECT `iduser`,`type` FROM `user` WHERE `username`='".$_POST['usernames']."' AND `password`='".$_POST['passwords']."'");
$result->execute();
$iresult = $result->fetch(PDO::FETCH_NUM);
if($iresult!=''){
if($iresult[1]=='etudiant'){
    $idqerry="SELECT etudiante.idetd 
              FROM etudiante 
              INNER JOIN user ON user.iduser = etudiante.iduser
              WHERE user.username = '".$_POST['usernames']."' AND user.password ='".$_POST['passwords']."'";
  $idqerry=$db->prepare($idqerry);$idqerry->execute();$idqerry=$idqerry->fetch();
  session_start();
  $_SESSION['idetd']=$idqerry[0];
  header('Refresh: 0; URL = ../../main-p-etudient/page/main-p-etudinet.php');

}

if($iresult[1]=='professeur'){
  $idqerry="SELECT professeur.idprof 
            FROM professeur 
            INNER JOIN user ON user.iduser = professeur.iduser
            WHERE user.username = '".$_POST['usernames']."' AND user.password ='".$_POST['passwords']."'";
  $idqerry=$db->prepare($idqerry);$idqerry->execute();$idqerry=$idqerry->fetch();
  session_start();
  $_SESSION['idprof']=$idqerry[0];
  header('Refresh: 0; URL = ../../main-p-prof/page/main-p-prof.php');
}

if($iresult[1]=='administrator'){
  $idqerry="SELECT user.iduser 
            FROM user
            WHERE user.username = '".$_POST['usernames']."' AND user.password ='".$_POST['passwords']."' ";
  $idqerry=$db->prepare($idqerry);$idqerry->execute();$idqerry=$idqerry->fetch();
  session_start();
  $_SESSION['idadmin']=$idqerry[0];
  header('Refresh: 0; URL = ../../admin/page/admin.php');

}
}else{

$res = "you have to sing in first";
$dis ="block";
}}
if(isset($_POST['Sign_Up'])){

 
 if($_POST['typeetdpe']=='etd'){
  $typeetdp1='etudiant';
$order="INSERT INTO `orders` (`idorders`,`username`, `password`, `type`, `nom`, `prenom`, `num_inscription_etd`, `num_inscription_prof`, `group_etd`, `module-prof`, `niveau_etd`) VALUES 
(NULL,'".$_POST['username']."', '".$_POST['password']."', '".$typeetdp1."', '".$_POST['lname']."', '".$_POST['fname']."','".$_POST['numberre']."', NULL,'".$_POST['group']."', NULL,'".$_POST['LMD']."')";

}else{

foreach ($_POST['levelp'] as $value11) {$md='modul'.$value11;
 foreach ($_POST[$md] as $value22) {
 $modulp=$modulp.$value22.',';
 } }
 $licence11='';$modulid='';
  $licence11="SELECT * FROM `module` WHERE `idniv`=1 ORDER BY `idmod`";
$licence11=$db->prepare($licence11);$licence11->execute();
$licence11=$licence11->fetchAll();
  $modulp=rtrim($modulp,',');
  $modulp=explode(',',$modulp);
  for ($i=0; $i <count($modulp); $i++) {$j=0; 
    while($modulp[$i]!=$licence11[$j][2]&&$j!=17){
      $j++;
    }
    if($modulp[$i]==$licence11[$j][2]){
      $modulid=$modulid.$licence11[$j][0].",";
    }
  }$order="";
$modulid=rtrim($modulid,',');

$typeetdp1='professeur';
$order="INSERT INTO `orders` (`idorders`,`username`, `password`, `type`, `nom`, `prenom`, `num_inscription_etd`, `num_inscription_prof`, `group_etd`, `module-prof`, `niveau_etd`) VALUES 
(NULL,'".$_POST['username']."', '".$_POST['password']."', '".$typeetdp1."', '".$_POST['lname']."', '".$_POST['fname']."',NULL, '".$_POST['numberrp']."',NULL, '".$modulid."',NULL)"; 
}
$order = $db->prepare($order);$order->execute();
}}
?>
<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>الامتحان على الخط</title>

    <link href="../../bootstrap/bootstrap.css" rel="stylesheet"> 
    <link href="../CSS/sing-in.css?<?php echo time(); ?>" rel="stylesheet">
  </head>
<body >
    <nav class="navbar navbar-inverse navbar-fixed-top">
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
          <form method="post" class="navbar-form navbar-right" action="">
            <div class="form-group">
              <input type="text" placeholder="اسم المستخدم" class="form-control" name="usernames" id="username">
            </div>
            <div class="form-group"> 
              <input type="password" placeholder="كلمة السر" class="form-control" name="passwords" id="password">
            </div>
            <button type="submit" name="signin2" id="sub" class="btn btn-success" onmouseover="signin(this.id)">تسجيل الدخول</button>
             <span class="tooltiptext" id ="singintool">الرجاء ملئ الحقول</span>
          <span><a class="sing-up" href="#crumbs"  onclick="displayit()">ليس لدي حساب</a></span>
            </form>
       
        </div><!--/.navbar-collapse -->    
      </div>
    </nav>
     <div style="background: red;width: 500px;position: relative;top: 50px;right: 30px; display: <?php echo $dis;?>;"> <?php echo $res ; ?></div>


                  <div id="crumbs" class=" ed">
  <ul>
    <li><span class="crumbs" id="f"><span class="crumbsfont">الخطوة الثالثة</span></span></li>
    <li><span class="crumbs" id="s" ><span class="crumbsfont">الخطوة الثانية</span></span></li>
    <li><span class="crumbs" id="t" ><span class="crumbsfont">الخطوة الأولى</span></span></li>
  </ul>
     
<button type="button" class="btn btn-danger btn-sm closebt" onclick="closeit()" >
          <span >&times;</span>  
        </button>     <hr class="line">
     <form class="forme" action="" method="post">
         
     <div id="first"><div class="form-group">
              <input type="text" placeholder="الاسم " class="form-control" id="name" name="fname">
            </div>
         <div class="form-group">
             <input type="text" placeholder="اللقب " class="form-control" name="lname"></div>
         <div class="form-group">
              <input type="text" placeholder="اسم المستخدم " class="form-control" name="username">
            </div>
          <div class="form-group">
              <input type="password" placeholder="كلمة السر" class="form-control" name="password">
            </div>
          <div class="form-group">
              <span>الطالب</span><input type="radio" name="typeetdpe" id="rd1" value="etd">
              <span>الأستاذ</span><input type="radio" name="typeetdpe" id="rd2" value="prof" checked>
            </div>
         </div>
     <div id="second1"><div class="form-group">
              <input type="number" placeholder="رقم تسجيل الطالب" name="numberre" class="form-control" step=0.00000000001 >
            </div>
            <div class="form-group">
              <input type="number" placeholder="الغوج" class="form-control" name="group">
            </div>
         <div class="form-group">
                <span class="fonth">المستوى الذي تدرسه</span><br><br>
                <div class="levelborder" style="width: 325px;"><span class="fonttext">اولى ليسانس</span>
                <input type="radio" value="L1" id="l1e" name="LMD" >
                <span class="fonttext">ثانية ليسانس</span>
                <input type="radio" value="L2" id="l2e" name="LMD" >
                <span class="fonttext">ثالثة ليسانس</span>
                <input type="radio" value="L3" id="l3e" name="LMD" ></div>
                <div class="levelborder" style="width: 325px;">
                 <span class="fonttext">اولى ماستر</span>
                <input type="radio" value="M1" id="m1e" name="LMD" >
                <span class="fonttext">ثانية ماستر</span>
                <input type="radio" value="M2" id="m2e" name="LMD" >
            </div></div>
         </div>
         <div id="second2"><div class="form-group">
              <input type="number" placeholder="رقم تسجيل الاستاذ" class="form-control" name="numberrp" step=0.00000000001>
            </div>
            <div class="form-group">
                <span class="fonth">المستويات التي تدرسها</span><br><br><div class="levelborder">
                <span class="fonttext">اولى ليسانس</span>
                <input type="checkbox" value="L1" name="levelp[]" id="L1" onchange="levell(this.id,'<?php echo $modul ; ?>')">
                <span class="fonttext">ثانية ليسانس</span>
                <input type="checkbox" value="L2" name="levelp[]" id="L2" onchange="levell(this.id,'<?php echo $modul ; ?>')">
                <span class="fonttext">ثالثة ليسانس</span>
                <input type="checkbox" value="L3" name="levelp[]" id="L3" onchange="levell(this.id,'<?php echo $modul ; ?>')"></div>
                <div class="levelborder">
                 <span class="fonttext">اولى ماستر</span>
                <input type="checkbox" value="M1" name="levelp[]" id="M1" onchange="levell(this.id,'<?php echo $modul ; ?>')"/>
                <span class="fonttext">ثانية ماستر</span>
                <input type="checkbox" value="M2" name="levelp[]" id="M2" onchange="levell(this.id,'<?php echo $modul ; ?>')"></div>
            </div>
             <div class="form-group">
                <span class="fonth">المقاييس التي تدرسها</span>
                 <div id="modules" ></div>
            </div>
         </div> 
     <div id="third">
       <h2>بعد الضغط على زر التسجيل سيتم مراجعة طلبكم بالقبول او الرفض عن طريق مدير التطبيق ...... وشكرًا <span>😊 
</span>  </h2>
         
         <button type="submit" class="btn btn-danger signup" name="Sign_Up">تسجيل</button>
         
         </div></form>
      <hr class="line2">
     <button class="btn btn-success po" id="next" >التالي</button>
     <button class="btn btn-success po" id="previous" disabled>السابق</button>
     
        </div> 
    <div class="jumbotron">
        <div class="container"> 
                <img style = "position: absolute; width: 35%; margin-right: 50%" 
                     src="../image/benefits-5-mobile.png"/>
            <h1>معلومات حول التطبيق</h1>
            <h2>برنامج يدعم كل الاجهزة</h2> 
            <p style="margin-right:25px">يمكنك الوصول إلى مستنداتك وإنشاؤها وتعديلها أينما ذهبت<br/> سواء أكان ذلك من الهاتف أو الجهاز اللوحي أو الكمبيوتر               <br/> شرط ان تكون متصل بالانترنات</p>    
        </div>
    </div>
        
    <div class="container">
    <div class="row">
        </div>
        <div class="row">
         <div class="col-lg-5 col-xm-12 xm"> 
             <h1>الإنشاء أو الرد أثناء التنقل</h1> 
             <img src="../image/img1.JPG"/>
        </div>
      <div class="col-lg-5 col-xm-12 xm"> 
          <h1>الحصول على النقطة بسرعة</h1> 
          <h3>
              يتم عرض النقطة مباشرة بعد الإنتهاء من الامتحان 
          </h3>
          <img src="../image/img2.jpg" />
        </div>
        </div>
    </div>

      <script src="../../bootstrap/jquery-3.1.1.js"></script>  
        <script src="../../bootstrap/bootstrap.js"></script>
        <script src="../JavaScripts/sing-in.js?<?php echo time(); ?>"></script> 
    </body>
    
</html>