<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CursoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Curso.php";

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
    case "4":
        get_cursos_by_rbd_establecimiento_and_periodo();
        break;
    case "5":
        ins_cursos();
        break;
    case "6":
        ins_curso();
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
    if(date("n") == "1"){
        $periodo -= 1;
    }
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
    if(date("n") == "1"){
        $periodo -= 1;
    }
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

//SE USA DESDE ingreso_curso
function get_cursos_by_rbd_establecimiento_and_periodo(){
    //print_r($_POST);
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $periodo_actual = $_POST["periodo_actual"];

    $matriz_curso = new CursoMatriz();
    if($matriz_curso->db_get_cursos_by_rbd_establecimiento_and_periodo($rbd_establecimiento, $periodo_actual)== "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $cursos = $matriz_curso->get_matriz();
    for($i = 0; $i < count($cursos); $i++){
        switch($cursos[$i]["id_tipo_ensenanza"]){
            case "10":
                if($cursos[$i]["id_grado"] == "4"){
                    $cursos[$i]["nombre_grado"] = "Pre-Kinder";
                }elseif($cursos[$i]["id_grado"] == "5"){
                    $cursos[$i]["nombre_grado"] = "Kinder";
                }
                break;
            case "110":
                $cursos[$i]["nombre_grado"] = $cursos[$i]["id_grado"]." "."Básico";
                break;
        }
    }

    print_r(json_encode($cursos, JSON_UNESCAPED_UNICODE));

}

function ins_cursos(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $periodo = $_POST["periodo"];
    $data = $_POST["data"];

    for($i = 0; $i < count($data); $i++){
        $curso = new Curso();
        $curso->set_identidad(
            $rbd_establecimiento,
            null,
            $data[$i]["id_grado"],
            $data[$i]["id_tipo_ensenanza"],
            $data[$i]["id_ciclo"],
            $data[$i]["grupo"]
        );
        $curso->set_periodo($periodo);

        if($curso->validar()) {

            if ($curso->db_get_curso_by_rbd_esta_and_id_grad_and_id_tip_and_grup_and_per() == "0") {
                $curso->db_ins_curso();
            }
        }else{
            $result = array("result" => "2");

            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
            return null;
        }

        $result = array("result" => "3");

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

}

function ins_curso(){
    $rbd_establecimiento = $_POST["rbd_establecimiento"];
    $periodo = $_POST["periodo"];

    $curso = new Curso();
    $curso->set_identidad(
        $rbd_establecimiento,
        null,
        $_POST["id_grado"],
        $_POST["id_tipo_ensenanza"],
        $_POST["id_ciclo"],
        $_POST["grupo"]
    );
    $curso->set_periodo($periodo);

    if($curso->validar()) {

        if ($curso->db_get_curso_by_rbd_esta_and_id_grad_and_id_tip_and_grup_and_per() == "0") {
            $curso->db_ins_curso();
        }
    }else{
        $result = array("result" => "2");

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $result = array("result" => "3");

    print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    return null;


}
/*
if( == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
*/
?>