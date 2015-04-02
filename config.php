<?php
echo __FILE__."<br/>";

//DEFINICION DE CONSTANTES
define("ROOT_MODELOS",$_SERVER["DOCUMENT_ROOT"]."/_code/modelos/");
define("ROOT_MODELOS_USUARIOS",$_SERVER["DOCUMENT_ROOT"]."/_code/modelos/usuarios/");

//echo $_SERVER["SERVER_NAME"]."<br/>";

if ($_SERVER["SERVER_NAME"] == "colescontulmo.local"){
    //echo "ESTAS EN LOCALHOST"; //DATOS BBDD LOCAL
    define("DB_HOST","localhost");//NOMBRE DEL SERVIDOR
    define("DB_NAME","coles_data");//NOMBRE DE LA BBDD
    define("DB_USER","coles_data");//NOMBRE DE USUARIO DE BBDD
    define("DB_PASS","20150402");//CONTRASEÑA DE BBDD
}else{
    //echo "ESTAS EN LOCALHOST"; //DATOS BBDD WEB
    define("DB_HOST","mysql.hostinger.es");//NOMBRE DEL SERVIDOR
    define("DB_NAME","u906616672_data");//NOMBRE DE LA BBDD
    define("DB_USER","u906616672_data");//NOMBRE DE USUARIO DE BBDD
    define("DB_PASS","20150402");//CONTRASEÑA DE BBDD
}

try{
    $myPDO = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
    //echo "<br/>ÉXITO EN LA CONEXIÓN BBDD<BR/>";

}catch(PDOException $e){
    print "<br/>ERROR: ".$e->getMessage()." <br/>";
    die();
}
?>