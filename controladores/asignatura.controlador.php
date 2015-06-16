<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/AsignaturaMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Curso.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Matricula.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Profesor.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_asignaturas_by_rbd_establecimiento_and_id_tipo_asignatura();
        break;
    case "2":
        get_asignaturas_by_run_profesor_and_id_curso();
        break;
    case "3":

        break;
    default:
        break;
    
}
//SE USA DESDE carga_clases
function get_asignaturas_by_rbd_establecimiento_and_id_tipo_asignatura(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $id_curso = $_POST["id_curso"];
    $id_tipo_asignatura = "0";


    $curso = new Curso();
    $curso->set_id_curso($id_curso);
    $curso->db_get_curso_by_id();
    switch($curso->get_id_tipo_ensenanza()){
        case "110":
            if($curso->get_id_grado() >= "1" and $curso->get_id_grado() <= "6"){
                $id_tipo_asignatura = "1";
            }
            elseif($curso->get_id_grado() > "6" and $curso->get_id_grado() <= "8"){
                $id_tipo_asignatura = "2";
            }
            break;
        default:
            break;
    }

    $matriz_asignatura = new AsignaturaMatriz();
    if($matriz_asignatura->db_get_asignaturas_by_rbd_establecimiento_and_id_tipo_asignatura($rbd_establecimiento, $id_tipo_asignatura) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_asignatura->to_json());
}

//SE USA DESDE carga_evaluaciones
function get_asignaturas_by_run_profesor_and_id_curso(){
    $run_profesor = $_POST["run_profesor"];
    $id_curso = $_POST["id_curso"];

    $matriz_asignatura = new AsignaturaMatriz();
    if($matriz_asignatura->db_get_asignaturas_by_run_profesor_and_id_curso($run_profesor, $id_curso) == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_asignatura->to_json());
}


/*
if( == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
*/
?>