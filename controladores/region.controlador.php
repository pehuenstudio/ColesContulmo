<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/RegionMatriz.php";

$id_funcion = $_POST["id_funcion"];
//print_r($_POST);
switch($id_funcion){
    case "1":
        get_regiones();
        break;
    default:
        break;

}

function get_regiones(){
    $region_matriz = new RegionMatriz();
    $region_matriz->db_get_regiones();
    print_r($region_matriz->to_json());
}

?>