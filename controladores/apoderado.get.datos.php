<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Apoderado.php";


if(!isset($_GET["funcion"])){
    //TODO manejar que no se envie nada,
}

$run_apoderado = $_GET["run_apoderado"];
$funcion = $_GET["funcion"];
switch ($funcion){
    case 1:
        $apoderado = new \personas\Apoderado();
        $apoderado->set_run($run_apoderado);
        if(!$apoderado->validar_run()){
            $result["result"] = false;
            $result = json_encode($result,JSON_UNESCAPED_UNICODE);
            print_r($result);
            break;
        }
        if(!$apoderado->db_existencia()){
            $result["result"] = false;
            $result = json_encode($result,JSON_UNESCAPED_UNICODE);
            print_r($result);
            break;
        }
        $apoderado->db_get_datos();


        $direccion = new Direccion();
        $direccion->set_id_direccion($apoderado->get_id_direccion());
        $direccion->db_get_datos();

        $apoderado->set_direccion($direccion);
        //var_dump($apoderado);

        $apoderado_json = $apoderado->to_json();
        $direccion_ids_nombres_json = $direccion->db_get_ids_nombres();

        $apoderado_array = json_decode($apoderado_json,true);
        $direccion_array = json_decode($direccion_ids_nombres_json, true);


        $apoderado_array["direccion_id"]["id_comuna"] = $direccion_array["direccion_id"]["id_comuna"];
        $apoderado_array["direccion_id"]["id_provincia"] = $direccion_array["direccion_id"]["id_provincia"];
        $apoderado_array["direccion_id"]["id_region"] = $direccion_array["direccion_id"]["id_region"];

        $apoderado_array["direccion_nombre"]["nombre_comuna"] = $direccion_array["direccion_nombre"]["nombre_comuna"];
        $apoderado_array["direccion_nombre"]["nombre_provincia"] = $direccion_array["direccion_nombre"]["nombre_provincia"];
        $apoderado_array["direccion_nombre"]["nombre_region"] = $direccion_array["direccion_nombre"]["nombre_region"];
        $apoderado_array["result"] = true;

        $apoderado_json = json_encode($apoderado_array,JSON_UNESCAPED_UNICODE);


        print_r($apoderado_json);
        break;
    default:
        echo "no se envio nada";
        break;
}



?>
 