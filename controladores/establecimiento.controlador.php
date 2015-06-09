<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/EstablecimientoMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_establecimientos();
        break;
    case "2":
        get_establecimientos_by_run_profesor();
        break;
    default:
        break;
    
}
//SE USA DESDE *
function get_establecimientos(){
    $matriz_establecimiento = new EstablecimientoMatriz();
    if($matriz_establecimiento->db_get_establecimientos() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }
    print_r($matriz_establecimiento->to_json());
    return null;
}

//SE USA DESDE evaluaciones
function get_establecimientos_by_run_profesor(){
    //print_r($_POST);
    $run_profesor = $_POST["run_profesor"];

    $matriz_establecimiento = new EstablecimientoMatriz();
    if($matriz_establecimiento->db_get_establecimientos_by_run_profesor($run_profesor)== "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_establecimiento->to_json());
}
/*
== "0"){
$result = array(
"result" => false
);

print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
return null;
}
*/
?>
