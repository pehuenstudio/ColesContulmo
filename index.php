<?php
echo __FILE__."<br/>";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/config.php";
require_once ROOT_MODELOS_USUARIOS."Profesor.php";
require_once ROOT_MODELOS_USUARIOS."Apoderado.php";
require_once ROOT_MODELOS_USUARIOS."Alumno.php";


$alumnoParametrizado = new Alumno("16689083-7","Rodrigo","Alberto","Sepulveda","Castro","19880528",1);

//$alumnoVacio->validar_run();
//$alumnoParametrizado->validar_run();
//$alumnoParametrizado->validar_nombre_completo();
//echo var_dump($alumnoVacio);
//echo var_dump($alumnoParametrizado);

if($alumnoParametrizado->validar()){
    echo "exito";
}else{
    echo "error";
}
var_dump($alumnoParametrizado);
?>