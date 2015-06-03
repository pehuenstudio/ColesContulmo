<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/DiaMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_dias_by_run_profesor_and_id_curso_and_id_asignatura();
        break;
    default:
        break;
    
}
function get_dias_by_run_profesor_and_id_curso_and_id_asignatura(){
    $run_profesor = $_POST["run_profesor"];
    $id_curso = $_POST["id_curso"];
    $id_asignatura = $_POST["id_asignatura"];

    $matriz_dia = new DiaMatriz();
    if($matriz_dia->get_dias_by_run_profesor_and_id_curso_and_id_asignatura($run_profesor, $id_curso, $id_asignatura) == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_dia->to_json());

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