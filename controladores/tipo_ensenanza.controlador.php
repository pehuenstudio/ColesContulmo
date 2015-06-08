<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/TipoEnsenanzaMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_tipos_ensenanza_by_rbd_establecimiento();
        break;
    default:
        break;
    
}
//SE USA DESDE ingreso_matricula
function get_tipos_ensenanza_by_rbd_establecimiento(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];

    $matriz_tipo_ensenanza = new TipoEnsenanzaMatriz();
    if($matriz_tipo_ensenanza->db_get_tipos_ensenanza_by_rbd_establecimiento($rbd_establecimiento) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
    print_r($matriz_tipo_ensenanza->to_json());

}
?>