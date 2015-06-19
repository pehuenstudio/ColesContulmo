<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_grados_by_rbd_establecimiento_and_id_tipo_ensenanza();
        break;
    default:
        break;
    
}
//SE USA DESDE ingreso_matricula
function get_grados_by_rbd_establecimiento_and_id_tipo_ensenanza(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $id_tipo_ensenanza = $_POST["id_tipo_ensenanza"];

    $matriz_grado = new GradoMatriz();
    if($matriz_grado->db_get_grados_by_rbd_establecimiento_and_id_tipo_ensenanza($rbd_establecimiento, $id_tipo_ensenanza) == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_grado->to_json());
}
/*
if( == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
*/
?>