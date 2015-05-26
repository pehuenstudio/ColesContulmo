<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Apoderado.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Comuna.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Provincia.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_apoderado_by_run();
        break;
    default:
        break;
    
}
function get_apoderado_by_run(){
    $run_apoderado = $_POST["run_apoderado"];

    $apoderado = new Apoderado();
    $apoderado->set_run($run_apoderado);

    if($apoderado->db_get_apoderado_by_run() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $direccion = new Direccion();
    $direccion->set_id_direccion($apoderado->get_id_direccion());
    $direccion->db_get_direccion_by_id();

    $comuna = new Comuna();
    $comuna->set_id_comuna($direccion->get_id_comuna());
    $comuna->db_get_comuna_by_id();

    $provincia = new Provincia();
    $provincia->set_id_provincia($comuna->get_id_provincia());
    $provincia->db_get_provincia_by_id();

    $matriz_apoderado = $apoderado->to_matriz();
    $matriz_apoderado["calle"] = $direccion->get_calle();
    $matriz_apoderado["numero"] = $direccion->get_numero();
    $matriz_apoderado["depto"] = $direccion->get_depto();
    $matriz_apoderado["sector"] = $direccion->get_sector();
    $matriz_apoderado["id_comuna"] = $direccion->get_id_comuna();
    $matriz_apoderado["nombre_comuna"] = $comuna->get_nombre();
    $matriz_apoderado["id_provincia"] = $comuna->get_id_provincia();
    $matriz_apoderado["nombre_provincia"] = $provincia->get_nombre();
    $matriz_apoderado["id_region"] = $provincia->get_id_region();
    $matriz_apoderado["result"] = true;

    print_r(json_encode($matriz_apoderado, JSON_UNESCAPED_UNICODE));

    return null;
}
?>