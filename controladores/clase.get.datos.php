<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ClaseMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Clase.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Profesor.php";

$rbd_establecimiento = $_POST["rbd_establecimiento"];
$id_curso = $_POST["id_curso"];
$periodo = date("Y");

$matriz_clase = new ClaseMatriz();
$matriz_clase->db_get_datos($id_curso, $rbd_establecimiento, $periodo);
$clases = json_decode($matriz_clase->to_json(), JSON_UNESCAPED_UNICODE);

for ($i = 0; $i < count($clases); $i++){
    $bloque = new Bloque();
    $bloque->set_id_bloque($clases[$i]["id_bloque"]);
    $bloque->db_get_datos();
    $clases[$i]["id_dia"] = $bloque->get_id_dia();
    $clases[$i]["hora_inicio"] = $bloque->get_hora_inicio();
    $clases[$i]["hora_fin"] = $bloque->get_hora_fin();
    $clases[$i]["nombre_asignatura"] = "Sin clases";
    $clases[$i]["nombre_profesor"] = "";
   // print_r($bloque);
    if(!empty($clases[$i]["id_asignatura"])){
        $asignatura = new Asignatura();
        $asignatura->set_id_asignatura($clases[$i]["id_asignatura"]);

        $asignatura->db_get_datos();
        $clases[$i]["nombre_asignatura"] = $asignatura->get_nombre();
    }
    if(!empty($clases[$i]["run_profesor"])){
        $profesor = new \personas\Profesor();
        $profesor->set_run($clases[$i]["run_profesor"]);

        $profesor->db_get_datos();
        $clases[$i]["nombre_profesor"] = $profesor->get_nombre1()." ".$profesor->get_apellido1()." ".$profesor->get_apellido2();
    }

}
$clases = json_encode($clases, JSON_UNESCAPED_UNICODE);
print_r($clases);
?>
 