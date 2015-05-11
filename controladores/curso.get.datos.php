<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CursoMatriz.php";

$rbd_establecimiento = $_POST["rbd_establecimiento"];

$matriz_curso = new CursoMatriz();
$matriz_curso->db_get_datos($rbd_establecimiento);
print_r($matriz_curso->to_json());
?>
 