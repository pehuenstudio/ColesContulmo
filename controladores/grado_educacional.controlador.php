<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
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
//SE USA DESDE *
function get_grados_educacionales(){
    $grado_educacional_matriz = new GradoEducacionalMatriz();
    if($grado_educacional_matriz->db_get_grados_educacionales() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($grado_educacional_matriz->to_json());
    return null;
}
?>