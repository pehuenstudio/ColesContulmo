<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ReligionMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_religiones();
        break;
    default:
        break;
    
}

function get_religiones(){
    $religion_matriz = new ReligionMatriz();
    $religion_matriz->db_get_religiones();
    print_r($religion_matriz->to_json());
}
?>