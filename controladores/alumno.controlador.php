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
        get_alumno_by_run();
        break;
    case "2":
        //print_r($_POST);
        if(con_alumno_by_run() > "0"){
            upd_alumno();
        }else{
            echo "ins";
        }
        $id_direccion = ins_direccion();
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

function con_alumno_by_run(){
    $run_alumno = $_POST["run_alumno"];

    $alumno = new Alumno();
    $alumno->set_run($run_alumno);

    $con = $alumno->db_get_alumno_by_run();
    return $con;
}

function upd_alumno(){
    $alumno = new Alumno();

    $run_alumno = $_POST["run_alumno"];
    $nombre1 = $_POST["nombre1_alumno"];
    $nombre2 = $_POST["nombre2_alumno"];
    $apellido1 = $_POST["apellido1_alumno"];
    $apellido2 = $_POST["apellido2_alumno"];
    $sexo = $_POST["sexo_alumno"];
    //$id_direccion = $_POST["id_direccion_alumno"];
    $email = $_POST["email_alumno"];
    $fecha_nacimiento = $_POST["fecha_nacimiento_alumno"];
    $pde = $_POST["pde"];
    $id_religion = $_POST["id_religion_alumno"];
    $grado_educacional_padre = $_POST["grado_educacional_padre"];
    $grado_educacional_madre = $_POST["grado_educacional_madre"];
    $persona_vive = $_POST["persona_vive_alumno"];

    $alumno->set_identidad(
        $run_alumno,
        $nombre1,
        $nombre2,
        $apellido1,
        $apellido2,
        $sexo,
        null,
        $email
    );


    $alumno->set_fecha_nacimiento($fecha_nacimiento);
    $alumno->set_pde($pde);
    $alumno->set_id_religion($id_religion);
    $alumno->set_grado_educacional_padre($grado_educacional_padre);
    $alumno->set_grado_educacional_madre($grado_educacional_madre);
    $alumno->set_persona_vive($persona_vive);

    if(!$alumno->validar()){
        $result = array("result" => false);
    }

    $alumno->db_upd_alumno();

    $result = array("result" => true);
    print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
}

function ins_direccion(){
    $calle = $_POST["calle_alumno"];
    $numero = $_POST["numero_alumno"];
    $depto = $_POST["depto_alumno"];
    $sector = $_POST["sector_alumno"];
    $id_comuna = $_POST["id_comuna_alumno"];

    $direccion = new Direccion();
    $direccion->set_identidad(
        $calle,
        $numero,
        $depto,
        $sector,$id_comuna
    );
    $direccion->validar();
    $direccion->db_ins_direccion();
    return $direccion->db_ins_direccion();
}

?>