<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ProvinciaMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        $id_region = $_POST["id_region"];
        get_provincias_by_id_region($id_region);
        break;
    default:
        break;

}

function get_provincias_by_id_region($id_region){
    $provincia_matriz = new ProvinciaMatriz();
    $provincia_matriz->db_get_provincias_by_id_region($id_region);
    print_r($provincia_matriz->to_json());
}
?>