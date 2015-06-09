<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CursoMatriz.php";

$id_funcion = $_POST["id_funcion"];


switch($id_funcion){
    case "1":
        get_cursos_by_rbd_esta_and_id_tipo_ense_and_id_grado_and_periodo();
        break;
    case "2":
        get_cursos_by_rbd_establecimiento_and_id_ciclo_and_periodo();
        break;
    case "3":
        get_cursos_by_run_profesor_and_rbd_establecimiento_and_periodo();
        break;
    default:
        break;
    
}
//SE USA DESDE ingreso_matricula
function get_cursos_by_rbd_esta_and_id_tipo_ense_and_id_grado_and_periodo(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $id_tipo_ensenanza = $_POST["id_tipo_ensenanza"];
    $id_grado = $_POST["id_grado"];
    $periodo = $_POST["periodo"];

    $matriz_curso = new CursoMatriz();
    if($matriz_curso->db_get_cursos_by_rbd_esta_and_id_tipo_ense_and_id_grado_and_periodo($rbd_establecimiento,
            $id_tipo_ensenanza, $id_grado, $periodo) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_curso->to_json());
}

//SE USA DESDE carga_clases
function get_cursos_by_rbd_establecimiento_and_id_ciclo_and_periodo(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $id_ciclo = $_POST["id_ciclo"];
    $periodo = date("Y");
    $matriz_curso = new CursoMatriz();
    if($matriz_curso->db_get_cursos_by_rbd_establecimiento_and_id_ciclo_and_periodo($rbd_establecimiento, $id_ciclo, $periodo) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $cursos = $matriz_curso->get_matriz();

    for($i = 0; $i<count($cursos); $i++){
        switch($cursos[$i]["id_tipo_ensenanza"]){
            case "110":
                $cursos[$i]["nombre_curso"] = "Básico";
                break;
            default:
                break;
        }
    }

    print_r(json_encode($cursos, JSON_UNESCAPED_UNICODE));
}

//SE USA DESDE carga_evaluaciones
function get_cursos_by_run_profesor_and_rbd_establecimiento_and_periodo(){
    $run_profesor = $_POST["run_profesor"];
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $periodo = date("Y");

    $matriz_curso = new CursoMatriz();
    if($matriz_curso->db_get_cursos_by_run_profesor_and_rbd_establecimiento_and_periodo($run_profesor, $rbd_establecimiento, $periodo)== "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $cursos = $matriz_curso->get_matriz();

    for($i = 0; $i<count($cursos); $i++){
        switch($cursos[$i]["id_tipo_ensenanza"]){
            case "110":
                $cursos[$i]["nombre_curso"] = "Básico";
                break;
            default:
                break;
        }
    }

    print_r(json_encode($cursos, JSON_UNESCAPED_UNICODE));
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