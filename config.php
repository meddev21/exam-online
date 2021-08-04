<?php 
$dns ='mysql:host=localhost;dbname=examonline';
$user = 'root';
$pass = '';
$option='';
 try {
$option= array(PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'");
$db = new PDO($dns,$user,$pass,$option);
$db ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 

    }
    catch (PDOException $e) {
        die('unable to connect to database ' . $e->getMessage());
    }

?>