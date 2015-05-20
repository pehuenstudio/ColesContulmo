<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoEducacionalMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_grados_educacionales();
        break;
    default:
        break;
    
}

function get_grados_educacionales(){
    $grado_educacional_matriz = new GradoEducacionalMatriz();
    $grado_educacional_matriz->db_get_grados_educacionales();
    print_r($grado_educacional_matriz->to_json());
}
?>