<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Evaluacion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/EvaluacionMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Clase.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Profesor.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/NotaMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        ins_evaluacion();
        break;
    case "2":
        get_evaluaciones_by_id_curso_and_mes_actual();
        break;
    case "3":
        get_evaluacion_by_id();
        break;
    case "4":
        upd_evaluacion_by_id();
        break;
    case "5":
        del_evaluacion_by_id();
        break;
    default:
        break;
    
}
//SE USA DESDE carga_evaluaciones
function ins_evaluacion(){

    $evaluacion = new Evaluacion();
    $evaluacion->set_id_clase($_POST["id_clase"]);
    $evaluacion->set_run_profesor($_POST["run_profesor"]);
    $evaluacion->set_fecha($_POST["fecha"]);
    $evaluacion->set_coeficiente($_POST["coeficiente"]);
    $evaluacion->set_descripcion($_POST["descripcion"]);

    if($evaluacion->db_get_evaluacion_by_id_clase_and_fecha() > "0"){
        $result = array("result" => "2");
    }else{
        if($evaluacion->db_ins_evaluacion()){
            $result = array("result" => "3", "id_evaluacion" => $evaluacion->get_id_evaluacion());
        }else{
            $result = array("result" => "1");
        }
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}

//SE USA DESDE carga_evaluaciones
function get_evaluaciones_by_id_curso_and_mes_actual(){
    $id_curso = $_POST["id_curso"];
    $mes_actual = $_POST["mes_actual"];

    $matriz_evaluacion = new EvaluacionMatriz();
    if($matriz_evaluacion->db_get_evaluaciones_by_id_curso_and_mes_actual($id_curso, $mes_actual) == "0"){
        $result = array();

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

//SE USA DESDE carga_evaluaciones
function get_evaluacion_by_id(){
    $evaluacion = new Evaluacion();
    $evaluacion->set_id_evaluacion($_POST["id_evaluacion"]);
    if($evaluacion->db_get_evaluacion_by_id() == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $profesor = new Profesor();
    $profesor->set_run($evaluacion->get_run_profesor());
    $profesor->db_get_profesor_by_run();

    $clase = new Clase();
    $clase->set_id_clase($evaluacion->get_id_clase());
    $clase->db_get_clase_by_id();

    $bloque = new Bloque();
    $bloque->set_id_bloque($clase->get_id_bloque());
    $bloque->db_get_bloque_by_id();

    $matriz_evaluacion = $evaluacion->to_matriz();
    $matriz_evaluacion["profesor"] = $profesor->get_nombre1()." ".$profesor->get_apellido1()." ".$profesor->get_apellido1();
    $matriz_evaluacion["dia_mes"] = date("j", strtotime($evaluacion->get_fecha()));
    $matriz_evaluacion["id_dia"] = $bloque->get_id_dia();
    $matriz_evaluacion["id_mes"] = date("n", strtotime($evaluacion->get_fecha()));
    $matriz_evaluacion["horario"] = $bloque->get_hora_inicio()." - ".$bloque->get_hora_fin();
    print_r(json_encode($matriz_evaluacion, JSON_UNESCAPED_UNICODE));

}

//SE USA DESDE carga_evaluaciones
function upd_evaluacion_by_id(){
    $evaluacion = new Evaluacion();
    $evaluacion->set_id_evaluacion($_POST["id_evaluacion"]);
    $evaluacion->set_coeficiente($_POST["coeficiente"]);
    $evaluacion->set_descripcion($_POST["descripcion"]);

    $evaluacion2 = new Evaluacion();
    $evaluacion2->set_id_evaluacion($_POST["id_evaluacion"]);
    $evaluacion2->db_get_evaluacion_by_id();

    $fecha_hoy = date_create(date("Y-m-d"));
    $fecha_evaluacion = date_create($evaluacion2->get_fecha());

    $date_diff = date_diff($fecha_hoy, $fecha_evaluacion);
    $diferencia = (int)$date_diff->format("%R%a");

    if($diferencia < 1){
        $result = array("result" => "2");
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
    $evaluacion->db_upd_evaluacion_by_id();
    $result = array("result" => "3");
    print_r(json_encode($result, JSON_UNESCAPED_UNICODE));

}

function del_evaluacion_by_id(){
    //print_r($_POST);
    $evaluacion = new Evaluacion();
    $evaluacion->set_id_evaluacion($_POST["id_evaluacion"]);

    $evaluacion2 = new Evaluacion();
    $evaluacion2->set_id_evaluacion($_POST["id_evaluacion"]);
    $evaluacion2->db_get_evaluacion_by_id();

    $fecha_hoy = date_create(date("Y-m-d"));
    $fecha_evaluacion = date_create($evaluacion2->get_fecha());

    $date_diff = date_diff($fecha_hoy, $fecha_evaluacion);
    $diferencia = (int)$date_diff->format("%R%a");

    if($diferencia < 1){
        $result = array("result" => "2");
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $matriz_notas = new NotaMatriz();
    if($matriz_notas->db_get_notas_by_id_evaluacion($evaluacion->get_id_evaluacion()) > "0"){
        $result = array("result" => "21");
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    if(!$evaluacion->db_del_evaluacion_by_id()){
        $result = array("result" => "1");
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $result = array("result" => "3");
    print_r(json_encode($result, JSON_UNESCAPED_UNICODE));


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