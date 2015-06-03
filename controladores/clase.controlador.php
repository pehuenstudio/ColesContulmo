<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ClaseMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Profesor.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_clases_by_id_curso();
        break;
    case "2":
        upd_clases_run_profesor_and_id_asignatura_by_id();
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

// SE USA DESDE carag_evaluaciones
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