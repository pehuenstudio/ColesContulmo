<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ComunaMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        $id_provincia = $_POST["id_provincia"];
        get_comunas_by_id_provincia($id_provincia);
        break;
    default:
        break;
    
}

function get_comunas_by_id_provincia($id_provincia){
    $comuna_matriz = new ComunaMatriz();
    $comuna_matriz->db_get_comunas_by_id_provincia($id_provincia);
    print_r($comuna_matriz->to_json());
}
?>