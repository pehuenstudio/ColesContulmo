<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ComunaMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_comunas_by_id_provincia();
        break;
    default:
        break;
    
}

function get_comunas_by_id_provincia(){
    $id_provincia = $_POST["id_provincia"];

    $comuna_matriz = new ComunaMatriz();
    if($comuna_matriz->db_get_comunas_by_id_provincia($id_provincia) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($comuna_matriz->to_json());
    return null;
}
?>