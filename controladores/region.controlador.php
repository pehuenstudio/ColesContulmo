<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
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
//SE USA DESDE *
function get_regiones(){
    $region_matriz = new RegionMatriz();
    if($region_matriz->db_get_regiones() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($region_matriz->to_json());
    return null;
}

?>