<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/EstablecimientoMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_establecimientos();
        break;
    default:
        break;
    
}

function get_establecimientos(){
    $matriz_establecimiento = new EstablecimientoMatriz();
    if($matriz_establecimiento->db_get_establecimientos() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
    print_r($matriz_establecimiento->to_json());
    return null;
}
?>