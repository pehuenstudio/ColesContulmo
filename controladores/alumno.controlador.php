<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Resize.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Alumno.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Comuna.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Provincia.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetidoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_alumno_by_run();
        break;
    case "2":
        ins_alumno();
        break;
    default:
        break;
    
}

function get_alumno_by_run(){
    $run_alumno = $_POST["run_alumno"];

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


}

function ins_alumno(){
    $alumno = new Alumno();
    $alumno->set_identidad(
        $_POST["run_alumno"],
        $_POST["nombre1_alumno"],
        $_POST["nombre2_alumno"],
        $_POST["apellido1_alumno"],
        $_POST["apellido2_alumno"],
        $_POST["sexo_alumno"],
        $_POST["email_alumno"]
    );

    $alumno->set_fecha_nacimiento($_POST["fecha_nacimiento_alumno"]);
    $alumno->set_pde($_POST["pde"]);
    $alumno->set_id_religion($_POST["id_religion_alumno"]);
    $alumno->set_grado_educacional_padre($_POST["grado_educacional_padre"]);
    $alumno->set_grado_educacional_madre($_POST["grado_educacional_madre"]);
    $alumno->set_persona_vive($_POST["persona_vive_alumno"]);

    $direccion = new Direccion();
    $direccion->set_identidad(
        $_POST["calle_alumno"],
        $_POST["numero_alumno"],
        $_POST["depto_alumno"],
        $_POST["sector_alumno"],
        $_POST["id_comuna_alumno"]
    );

    $validacion = true;
    if(!$alumno->validar()){$validacion = false;}
    if(!$direccion->validar()){$validacion = false;}
    if(!$validacion){
        $result = array("result" => "1", "msg" => "Fallo de validación.");
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        die();
    }

    if($alumno->db_con_alumno_by_run() > "0"){
        $actualizar = $alumno->db_upd_alumno_by_run();
        $alumno->set_id_direccion($_POST["id_direccion_alumno"]);
        $direccion->set_id_direccion($alumno->get_id_direccion());
        $direccion->db_upd_direccion_by_id();

        if($actualizar){
            $result = array("result" => "3", "msg" => "Actualización de datos exitosa.");
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
            die();
        }
    }else{
        $direccion->db_ins_direccion();
        $alumno->set_id_direccion($direccion->get_id_direccion());
        $insertar = $alumno->db_ins_alumno();

        if($insertar){
            $result = array("result" => "3", "msg" => "Ingreso de datos exitoso.");
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
            die();
        }
    }
    print_r($alumno);
}




?>