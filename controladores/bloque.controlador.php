<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/BloqueMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Dia.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_bloques_by_run_profe_and_id_cur_and_id_asig_and_id_dia();
        break;
    default:
        break;
    
}

function get_bloques_by_run_profe_and_id_curso_and_id_asignatura(){
    $run_profesor = $_POST["run_profesor"];
    $id_curso = $_POST["id_curso"];
    $id_asignatura = $_POST["id_asignatura"];

    $matriz_bloque = new BloqueMatriz();
    if($matriz_bloque->db_get_bloques_by_run_profe_and_id_curso_and_id_asignatura($run_profesor, $id_curso, $id_asignatura) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
    $bloques = $matriz_bloque->get_matriz();

    for($i = 0; $i < count($bloques); $i++){
        $dia = new Dia();
        $dia->set_id_dia($bloques[$i]["id_dia"]);
        $dia->db_get_dia_by_id();

        $bloques[$i]["nombre_dia"] = $dia->get_nombre();
    }

    print_r(json_encode($bloques, JSON_UNESCAPED_UNICODE));
}


function get_bloques_by_run_profe_and_id_cur_and_id_asig_and_id_dia(){
    $run_profesor = $_POST["run_profesor"];
    $id_curso = $_POST["id_curso"];
    $id_asignatura = $_POST["id_asignatura"];
    $id_dia = $_POST["id_dia"];

    $matriz_bloque = new BloqueMatriz();
    if($matriz_bloque->db_get_bloques_by_run_profe_and_id_cur_and_id_asig_and_id_dia($run_profesor, $id_curso, $id_asignatura,$id_dia) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
    $bloques = $matriz_bloque->get_matriz();

    for($i = 0; $i < count($bloques); $i++){
        $dia = new Dia();
        $dia->set_id_dia($bloques[$i]["id_dia"]);
        $dia->db_get_dia_by_id();

        $bloques[$i]["nombre_dia"] = $dia->get_nombre();
    }

    print_r(json_encode($bloques, JSON_UNESCAPED_UNICODE));
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