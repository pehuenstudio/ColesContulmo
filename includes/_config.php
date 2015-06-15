<?php
//echo __FILE__."<br/>";

//ini_set('default_charset','utf8');
//DEFINICION DE CONSTANTES
define("MUNICIPALIDAD","Ilustre Municipalidad de Contulmo");

define("ROOT_MODELOS",$_SERVER["DOCUMENT_ROOT"]."/_code/modelos/");
define("ROOT_MODELOS_PERSONAS",$_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/");
define("INFO","<strong style=\"color:blue\">INFO&nbsp;&nbsp;&nbsp;&nbsp;</strong>");
define("ERRORCITO","<strong style=\"color:red\">ERROR</strong>");
define("CLASE_PERSONA"," <strong style=\"color:firebrick\">&nbsp;CLASE_PERSONA:&nbsp;</strong> ");
define("CLASE_ALUMNO"," <strong style=\"color:green\">&nbsp;CLASE_ALUMNO:&nbsp;</strong> ");
define("CLASE_APODERADO"," <strong style=\"color:orange\">&nbsp;CLASE_APODERADO:&nbsp;</strong> ");
define("CLASE_PROFESOR"," <strong style=\"color:mediumvioletred\">&nbsp;CLASE_PREFESOR:&nbsp;</strong> ");
define("CLASE_MATRICULA"," <strong style=\"color:darkorchid\">&nbsp;CLASE_MATRICULA:&nbsp;</strong> ");
define("CLASE_TIPOENSENANZA"," <strong style=\"color:palevioletred\">&nbsp;CLASE_TIPOENSENANZA:&nbsp;</strong> ");
define("CLASE_DIRECCION"," <strong style=\"color:greenyellow\">&nbsp;CLASE_DIRECCION:&nbsp;</strong> ");
define("CLASE_ESTABLECIMIENTO"," <strong style=\"color:tan\">&nbsp;CLASE_ESTABLECIMIENTO:&nbsp;</strong> ");
define("CLASE_CURSO"," <strong style=\"color:lightseagreen\">&nbsp;CLASE_CURSO:&nbsp;</strong> ");
define("CLASE_GRADO_REPETIDO"," <strong style=\"color:violet\">&nbsp;CLASE_GRADO REPETIDO:&nbsp;</strong> ");
//TipoEnsenanza

//echo $_SERVER["SERVER_NAME"]."<br/>";

if ($_SERVER["SERVER_NAME"] == "colescontulmo.local" || $_SERVER["SERVER_NAME"] == "test.cl"){
    //echo "ESTAS EN LOCALHOST"; //DATOS BBDD LOCAL
    define("DB_HOST","localhost");//NOMBRE DEL SERVIDOR
    define("DB_NAME","coles_data");//NOMBRE DE LA BBDD
    define("DB_USER","coles_data");//NOMBRE DE USUARIO DE BBDD
    define("DB_PASS","martes 14 de abril");//CONTRASEÑA DE BBDD

    define("DB_HOSTJOOMLA","localhost");//NOMBRE DEL SERVIDOR
    define("DB_NAMEJOOMLA","coles_joom");//NOMBRE DE LA BBDD
    define("DB_USERJOOMLA","coles_joom");//NOMBRE DE USUARIO DE BBDD
    define("DB_PASSJOOMLA","martes 14 de abril");//CONTRASEÑA DE BBDD
}else{
    //echo "ESTAS EN LOCALHOST"; //DATOS BBDD WEB
    define("DB_HOST","mysql.hostinger.com.ar");//NOMBRE DEL SERVIDOR
    define("DB_NAME","u549741940_data");//NOMBRE DE LA BBDD
    define("DB_USER","u549741940_data");//NOMBRE DE USUARIO DE BBDD
    define("DB_PASS","martes 14 de abril");//CONTRASEÑA DE BBDD

    define("DB_HOSTJOOMLA","mysql.hostinger.com.ar");//NOMBRE DEL SERVIDOR
    define("DB_NAMEJOOMLA","u549741940_joom");//NOMBRE DE LA BBDD
    define("DB_USERJOOMLA","u549741940_joom");//NOMBRE DE USUARIO DE BBDD
    define("DB_PASSJOOMLA","martes 14 de abril");//CONTRASEÑA DE BBDD
}
?>
 