<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ProvinciaMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_provincias_by_id_region();
        break;
    default:
        break;

}
//SE USA DESDE *
function get_provincias_by_id_region(){
    $id_region = $_POST["id_region"];

    $provincia_matriz = new ProvinciaMatriz();
    if($provincia_matriz->db_get_provincias_by_id_region($id_region) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($provincia_matriz->to_json());
    return null;
}
?>