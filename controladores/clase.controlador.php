<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ClaseMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Profesor.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Dia.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Evaluacion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Matricula.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_clases_by_id_curso();
        break;
    case "2":
        upd_clases_run_profesor_and_id_asignatura_by_id();
        break;
    case "3":
        get_clases_by_run_profe_and_id_cur_and_id_asig_and_id_dia();
        break;
    case "4":
        get_matricula_by_run_alumno_and_rbd_esta_and_periodo();
        break;
    default:
        break;
    
}
// SE USA DESDE carag_clases
function get_clases_by_id_curso(){
    $id_curso = $_POST["id_curso"];
    $periodo = date("Y");
    $matriz_clase = new ClaseMatriz();
    if($matriz_clase->db_get_clases_by_id_curso($id_curso) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $clases = $matriz_clase->get_matriz();
    for($i = 0; $i < count($clases); $i++){
        $bloque = new Bloque();
        $bloque->set_id_bloque($clases[$i]["id_bloque"]);
        $bloque->db_get_bloque_by_id();
        $clases[$i]["id_dia"] = $bloque->get_id_dia();
        $clases[$i]["horario"] = $bloque->get_hora_inicio()." - ".$bloque->get_hora_fin();

        $profesor = new Profesor();
        $profesor->set_run($clases[$i]["run_profesor"]);
        $profesor->db_get_profesor_by_run();
        $clases[$i]["nombre_profesor"] = $profesor->get_nombre1()." ".$profesor->get_nombre2()." ".$profesor->get_apellido2();

        $asignatura = new Asignatura();
        $asignatura->set_id_asignatura($clases[$i]["id_asignatura"]);
        $asignatura->db_get_asignatura_by_id();
        $clases[$i]["nombre_asignatura"] = $asignatura->get_nombre();
        $clases[$i]["color1"] = $asignatura->get_color1();
        $clases[$i]["color2"] = $asignatura->get_color2();
    }


    print_r(json_encode($clases, JSON_UNESCAPED_UNICODE));
}

// SE USA DESDE carag_clases
function upd_clases_run_profesor_and_id_asignatura_by_id(){
    $result = true;

    $clasesIns = json_decode($_POST["clasesIns"], JSON_UNESCAPED_UNICODE);
    $matriz_clase = new ClaseMatriz();
    foreach($clasesIns as $row){
        $clase = new Clase();
        $clase->set_id_clase($row["id_clase"]);
        $clase->set_run_profesor($row["run_profesor"]);
        $clase->set_id_asignatura($row["id_asignatura"]);

        $matriz_clase->to_matriz($clase);
    }
    if(!$matriz_clase->db_upd_clases_run_profesor_and_id_asignatura_by_id()){
        $result = false;
    }

    $clasesDel= json_decode($_POST["clasesDel"], JSON_UNESCAPED_UNICODE);
    $matriz_clase = new ClaseMatriz();
    foreach($clasesDel as $row){
        $clase = new Clase();
        $clase->set_id_clase($row["id_clase"]);
        $clase->set_run_profesor(null);
        $clase->set_id_asignatura(null);

        $matriz_clase->to_matriz($clase);
    }
    if(!$matriz_clase->db_upd_clases_run_profesor_and_id_asignatura_by_id()){
        $result = false;
    }
    if(!$result){
        $result = array("result"=>"1", "msg"=>"Lo sentimos, se produjo un error en la actualización del horario.");
    }else{
        $result = array("result"=>"3", "msg"=>"El horario fue actualizado exitosamente.");
    }
    print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
}

//SE USA DESDE cargar_evaluaciones
function get_clases_by_run_profe_and_id_cur_and_id_asig_and_id_dia(){

    $run_profesor = $_POST["run_profesor"];
    $id_curso = $_POST["id_curso"];
    $id_asignatura = $_POST["id_asignatura"];
    $id_dia = $_POST["id_dia"];
    $fecha = $_POST["fecha"];

    $matriz_clase = new ClaseMatriz();
    if($matriz_clase->db_get_clases_by_run_profe_and_id_cur_and_id_asig_and_id_dia($run_profesor, $id_curso, $id_asignatura,$id_dia) == "0"){
        $result = array("result" => false);

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $clases = $matriz_clase->get_matriz();

    $i = 0;
    $j = count($clases);
    while($i < $j){
        $evaluacion = new Evaluacion();
        $evaluacion->set_id_clase($clases[$i]["id_clase"]);
        $evaluacion->set_fecha($fecha);

        if($evaluacion->db_get_evaluacion_by_id_clase_and_fecha() > "0"){
            unset($clases[$i]);
        }
        $i++;
    }

    $clases = array_values($clases);
    for($i = 0; $i < count($clases); $i++){
    $bloque = new Bloque();
    $bloque->set_id_bloque($clases[$i]["id_bloque"]);
    $bloque->db_get_bloque_by_id();
    $clases[$i]["hora_inicio"]= $bloque->get_hora_inicio();
    $clases[$i]["hora_fin"] = $bloque->get_hora_fin();

    $dia = new Dia();
    $dia->set_id_dia($bloque->get_id_dia());
    $dia->db_get_dia_by_id();

    $clases[$i]["nombre_dia"] = $dia->get_nombre();
    }
    //$clases = array_values($clases);

    print_r(json_encode($clases, JSON_UNESCAPED_UNICODE));
}

function get_matricula_by_run_alumno_and_rbd_esta_and_periodo(){
    //print_r($_POST);
    $periodo = date("Y");

    $matricula = new Matricula();
    $matricula->set_run_alumno($_POST["run_alumno"]);
    $matricula->set_rbd_establecimiento($_POST["rbd_establecimiento"]);
    $matricula->set_periodo($periodo);
    $matricula->db_get_matricula_by_run_alumno_and_rbd_esta_and_periodo();
    //print_r($matricula);

    $matriz_clase = new ClaseMatriz();
    if($matriz_clase->db_get_clases_by_id_curso($matricula->get_id_curso()) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $clases = $matriz_clase->get_matriz();
    for($i = 0; $i < count($clases); $i++){
        $bloque = new Bloque();
        $bloque->set_id_bloque($clases[$i]["id_bloque"]);
        $bloque->db_get_bloque_by_id();
        $clases[$i]["id_dia"] = $bloque->get_id_dia();
        $clases[$i]["horario"] = $bloque->get_hora_inicio()." - ".$bloque->get_hora_fin();

        $profesor = new Profesor();
        $profesor->set_run($clases[$i]["run_profesor"]);
        $profesor->db_get_profesor_by_run();
        $clases[$i]["nombre_profesor"] = $profesor->get_nombre1()." ".$profesor->get_nombre2()." ".$profesor->get_apellido2();

        $asignatura = new Asignatura();
        $asignatura->set_id_asignatura($clases[$i]["id_asignatura"]);
        $asignatura->db_get_asignatura_by_id();
        $clases[$i]["nombre_asignatura"] = $asignatura->get_nombre();
        $clases[$i]["color1"] = $asignatura->get_color1();
        $clases[$i]["color2"] = $asignatura->get_color2();
    }


    print_r(json_encode($clases, JSON_UNESCAPED_UNICODE));

}
/*
if( == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
*/
?>