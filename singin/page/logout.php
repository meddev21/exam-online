<?php
session_start();



if(!empty($_SESSION['idetd'])){
unset($_SESSION['idetd']);	
}elseif (!empty($_SESSION['idprof'])) {
unset($_SESSION['idprof']);
}elseif (!empty($_SESSION['idadmin'])) {
unset($_SESSION['idadmin']);
}
session_unset();
session_destroy();

header('Refresh: 0; URL = ../../singin/page/index.php');
?>