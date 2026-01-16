<?php 
$host="localhost:3306";
$user="root";
$password="";
$database="hercules";
/*$host="localhost";
$user="mantis65";
$password="comacates1999";
$database="mantis";*/
$enlace = mysql_connect($host,$user,$password) or die(mysql_error());
mysql_select_db($database,$enlace);
mysql_query("SET NAMES 'utf8'");
?>
