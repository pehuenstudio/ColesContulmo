<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
//echo __FILE__."<br/>";

try{
$myPDO = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
    //echo "<br/>ÉXITO EN LA CONEXIÓN BBDD<BR/>";
    $myPDO->query("SET NAMES 'utf8';");


}catch(PDOException $e){
    print "<br/>ERROR: ".$e->getMessage()." <br/>";
    die();

}
/*
try{
    $myPDOJoomla = new PDO("mysql:host=".DB_HOSTJOOMLA.";dbname=".DB_NAMEJOOMLA, DB_USERJOOMLA, DB_PASSJOOMLA);
    //echo "<br/>ÉXITO EN LA CONEXIÓN BBDD<BR/>";
    $myPDO->query("SET NAMES 'utf8';");


}catch(PDOException $e){
    print "<br/>ERROR: ".$e->getMessage()." <br/>";
    die();

}
*/
?> 