<?php
header('Content-Type: text/html; charset=utf-8');header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ClaseMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Clase.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Bloque.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Asignatura.php";

$rbd_establecimiento = $_POST["rbd_establecimiento"];
$id_curso = $_POST["id_curso"];

$matriz_clase = new ClaseMatriz();
$matriz_clase->db_get_datos($id_curso, $rbd_establecimiento);
$clases = json_decode($matriz_clase->to_json(), JSON_UNESCAPED_UNICODE);

for ($i = 0; $i < count($clases); $i++){
    $bloque = new Bloque();
    $bloque->set_id_bloque($clases[$i]["id_bloque"]);
    $bloque->db_get_datos();
    $clases[$i]["id_dia"] = $bloque->get_id_dia();
    $clases[$i]["hora_inicio"] = $bloque->get_hora_inicio();
    $clases[$i]["hora_fin"] = $bloque->get_hora_fin();
    $clases[$i]["nombre_asignatura"] = "Sin clases";
   // print_r($bloque);
    if(!empty($clases[$i]["id_asignatura"])){
        $asignatura = new Asignatura();
        $asignatura->set_id_asignatura($clases[$i]["id_asignatura"]);

        $asignatura->db_get_datos();
        $clases[$i]["nombre_asignatura"] = $asignatura->get_nombre();
    }

}
$clases = json_encode($clases, JSON_UNESCAPED_UNICODE);
print_r($clases);
?>
 