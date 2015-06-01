<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CicloMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_ciclos_by_rbd_establecimiento();
        break;
    default:
        break;
    
}
function get_ciclos_by_rbd_establecimiento(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $matriz_ciclo = new CicloMatriz();
    if($matriz_ciclo->db_get_ciclos_by_rbd_establecimiento($rbd_establecimiento) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
    print_r($matriz_ciclo->to_json());
}
/*
if( == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
*/
?>