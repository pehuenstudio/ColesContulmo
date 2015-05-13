<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/AsignaturaMatriz.php";

$id_grado = $_POST["id_grado"];
$id_tipo_ensenanza = $_POST["id_tipo_ensenanza"];

switch($id_tipo_ensenanza){
    case "110":
        if($id_grado< 7){
            $id_asignatura_tipo = 1;
        }else{
            $id_asignatura_tipo = 2;
        }
        break;
}

$matriz_asignatura = new AsignaturaMatriz();
$matriz_asignatura->db_get_datos($id_asignatura_tipo);
print_r($matriz_asignatura->to_json());

?>
 