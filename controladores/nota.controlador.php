<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/NotaMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Nota.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        ins_notas();
        break;
    case "2":
        get_notas_by_id_curso_and_id_asignatura();
        break;
    case "3":
        get_notas_by_run_alumno_and_id_curso();
        break;
    default:
        break;
    
}
function ins_notas(){
    //print_r($_POST);
    $fecha_creacion = date("Y-m-d");
    $alumnos = $_POST["alumnos"];
    for($i = 0; $i < count($alumnos); $i++){
        //print_r($alumnos[$i]["run_alumno"]."\n");
        $notas_array = $alumnos[$i]["notas"];
        for($j = 0; $j < count($notas_array); $j++){
            $nota = new Nota();
            $nota->set_identidad(
                $notas_array[$j]["id_evaluacion"],
                $alumnos[$i]["run_alumno"],
                $notas_array[$j]["nota"],
                $fecha_creacion
            );
            if($nota->get_valor() != "") {
                $matriz_notas = new NotaMatriz();
                if($matriz_notas->db_get_notas_by_id_evaluacion_and_run_alumno($nota->get_id_evaluacion(), $nota->get_run_alumno()) == "0"){
                    $nota->db_ins_nota();
                    print_r("ingreso \n");
                }else{
                    $nota->db_upd_nota_by_id_evaluacion_and_run_alumno();
                    print("actualizacion \n");
                }
            }else{
                $nota->db_del_nota_by_id_evaluacion_and_run_alumno();
                print_r("borrado \n");
            }
        }
    }

}

function get_notas_by_id_curso_and_id_asignatura(){
    $id_curso = $_POST["id_curso"];
    $id_asignatura = $_POST["id_asignatura"];

    $matriz_notas = new NotaMatriz();

    if($matriz_notas->db_get_notas_by_id_curso_and_id_asignatura($id_curso, $id_asignatura) == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_notas->to_json());

}

function get_notas_by_run_alumno_and_id_curso(){
    $run_alumno = $_POST["run_alumno"];
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $periodo = date("Y");

    $matricula = new Matricula();
    $matricula->set_run_alumno($run_alumno);
    $matricula->set_rbd_establecimiento($rbd_establecimiento);
    $matricula->set_periodo($periodo);
    if($matricula->db_get_matricula_by_run_alumno_and_rbd_esta_and_periodo()== "0"){
        $result = array( );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $matriz_notas = new NotaMatriz();
    if($matriz_notas->db_get_notas_by_run_alumno_and_id_curso($run_alumno, $matricula->get_id_curso())== "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_notas->to_json());

}
/*
if( == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
*/
?>