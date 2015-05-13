<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/BloqueMatriz.php";


$rbd_establecimiento = $_POST["rbd_establecimiento"];
$id_ciclo = $_POST["id_ciclo"];

$matriz_bloques = new BloqueMatriz();
$matriz_bloques->db_get_datos($rbd_establecimiento,$id_ciclo);
print_r($matriz_bloques->to_json());
?>
 