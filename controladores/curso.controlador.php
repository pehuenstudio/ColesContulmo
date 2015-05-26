<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CursoMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":

        get_cursos_by_rbd_esta_and_id_tipo_ensenanza_and_id_grado();
        break;
    default:
        break;
    
}

function get_cursos_by_rbd_esta_and_id_tipo_ensenanza_and_id_grado(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $id_tipo_ensenanza = $_POST["id_tipo_ensenanza"];
    $id_grado = $_POST["id_grado"];

    $matriz_curso = new CursoMatriz();
    if($matriz_curso->db_get_cursos_by_rbd_esta_and_id_tipo_ensenanza_and_id_grado($rbd_establecimiento, $id_tipo_ensenanza, $id_grado) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_curso->to_json());
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