<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Alumno.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/MatrizGradosRepetidos.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";


if(!isset($_GET["funcion"])){
    //TODO manejar que no se envie nada,
}

$run_alumno = $_GET["run_alumno"];
$funcion = $_GET["funcion"];
switch ($funcion){
    case 1:
        $alumno = new \personas\Alumno();
        $alumno->set_run($run_alumno);
        if(!$alumno->validar_run()){
            $result["result"] = false;
            $result = json_encode($result,JSON_UNESCAPED_UNICODE);
            print_r($result);
            break;
        }
        if(!$alumno->db_existencia()){
            $result["result"] = false;
            $result = json_encode($result,JSON_UNESCAPED_UNICODE);
            print_r($result);
            break;
        }
        $alumno->db_get_datos();
        //print_r($alumno);

        $direccion = new Direccion();
        $direccion->set_id_direccion($alumno->get_id_direccion());

        $direccion->db_get_datos();
       //print_r($direccion);
        $direccion->db_get_ids_nombres();

        //var_dump($direccion);

        $alumno->set_direccion($direccion);

        $matriz_grados_repetido = new MatrizGradosRepetidos();
        $matriz_grados_repetido->db_get_datos($run_alumno);


        $alumno_json = $alumno->to_json();

        $matriz_grados_repetido_json = $matriz_grados_repetido->to_json();


        $alumno_array = json_decode($alumno_json, JSON_UNESCAPED_UNICODE);

        $matriz_grados_repetido_array = json_decode($matriz_grados_repetido_json, JSON_UNESCAPED_UNICODE);




        $alumno_array["direccion_id"]["id_comuna"] = $direccion->get_id_comuna();
        $alumno_array["direccion_id"]["id_provincia"] = $direccion->get_id_provincia();
        $alumno_array["direccion_id"]["id_region"] = $direccion->get_id_region();

        $alumno_array["direccion_nombre"]["nombre_comuna"] = $direccion->get_nombre_comuna();
        $alumno_array["direccion_nombre"]["nombre_provincia"] = $direccion->get_nombre_provincia();
        $alumno_array["direccion_nombre"]["nombre_region"] = $direccion->get_nombre_region();

        $alumno_array["grados_repetidos"] = array();
        foreach($matriz_grados_repetido_array as $row){
            $data["id_grado"] = $row["id_grado"];
            $data["id_tipo_ensenanza"] = $row["id_tipo_ensenanza"];
            $data["cantidad"] = $row["cantidad"];

            array_push($alumno_array["grados_repetidos"],$data);
        }

        $alumno_array["result"] = true;

        $alumno_json = json_encode($alumno_array,JSON_UNESCAPED_UNICODE);


        print_r($alumno_json);
        break;
    default:
        echo "no se envio nada";
        break;
}



?>
 