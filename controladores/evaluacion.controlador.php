<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Evaluacion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/EvaluacionMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Clase.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_evaluacion_by_id_clase_and_fecha();
        break;
    case "2":
        get_evaluaciones_by_id_curso_and_mes_actual();
        break;
    default:
        break;
    
}
function get_evaluacion_by_id_clase_and_fecha(){

    $evaluacion = new Evaluacion();
    $evaluacion->set_id_clase($id_clase = $_POST["id_clase"]);
    $evaluacion->set_fecha($fecha = $_POST["fecha"]);
    $evaluacion->set_run_profesor($_POST["run_profesor"]);
    $evaluacion->set_descripcion($_POST["descripcion"]);

    if($evaluacion->db_get_evaluacion_by_id_clase_and_fecha() > "0"){
        print_r("existe una evaluacion");
    }else{
        if($evaluacion->db_ins_evaluacion()){
            $result = array("result" => "3");
        }else{
            $result = array("result" => "1");
        }
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}

function get_evaluaciones_by_id_curso_and_mes_actual(){
    $id_curso = $_POST["id_curso"];
    $mes_actual = $_POST["mes_actual"];

    $matriz_evaluacion = new EvaluacionMatriz();
    if($matriz_evaluacion->db_get_evaluaciones_by_id_curso_and_mes_actual($id_curso, $mes_actual) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $evaluaciones = $matriz_evaluacion->get_matriz();
    for($i = 0; $i < count($evaluaciones); $i++){
        $clase = new Clase();
        $clase->set_id_clase($evaluaciones[$i]["id_clase"]);
        $clase->db_get_clase_by_id();


        $asignatura = new Asignatura();
        $asignatura->set_id_asignatura($clase->get_id_asignatura());
        $asignatura->db_get_asignatura_by_id();

        $evaluaciones[$i]["nombre_asignatura"] = $asignatura->get_nombre();
        $evaluaciones[$i]["color1"] = $asignatura->get_color1();
        $evaluaciones[$i]["color2"] = $asignatura->get_color2();

    }

    print_r(json_encode($evaluaciones, JSON_UNESCAPED_UNICODE));
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