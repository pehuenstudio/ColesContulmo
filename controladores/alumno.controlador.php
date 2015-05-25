<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Alumno.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Comuna.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Provincia.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetidoMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        $run_alumno = $_POST["run_alumno"];
        get_alumno_by_run($run_alumno);
        break;
    default:
        break;
    
}
function get_alumno_by_run($run_alumno){
    $result = true;
    $alumno = new Alumno();
    $alumno->set_run($run_alumno);
    if($alumno->db_get_alumno_by_run() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }



    $direccion = new Direccion();
    $direccion->set_id_direccion($alumno->get_id_direccion());
    $direccion->db_get_direccion_by_id();

    $comuna = new Comuna();
    $comuna->set_id_comuna($direccion->get_id_comuna());
    $comuna->db_get_comuna_by_id();

    $provincia = new Provincia();
    $provincia->set_id_provincia($comuna->get_id_provincia());
    $provincia->db_get_provincia_by_id();

    $matriz_grados_repetidos = new GradoRepetidoMatriz();
    $matriz_grados_repetidos->db_get_grados_repetidos_by_run_alumno($alumno->get_run());

    $matriz_alumno = $alumno->to_matriz();
    $matriz_alumno["calle"] = $direccion->get_calle();
    $matriz_alumno["numero"] = $direccion->get_numero();
    $matriz_alumno["depto"] = $direccion->get_depto();
    $matriz_alumno["sector"] = $direccion->get_sector();
    $matriz_alumno["id_comuna"] = $direccion->get_id_comuna();
    $matriz_alumno["nombre_comuna"] = $comuna->get_nombre();
    $matriz_alumno["id_provincia"] = $comuna->get_id_provincia();
    $matriz_alumno["nombre_provincia"] = $provincia->get_nombre();
    $matriz_alumno["id_region"] = $provincia->get_id_region();

    $matriz_alumno["grados_repetidos"] = $matriz_grados_repetidos->get_matriz();

    $matriz_alumno["result"] = true;

    print_r(json_encode($matriz_alumno, JSON_UNESCAPED_UNICODE));

    return null;
}
?>