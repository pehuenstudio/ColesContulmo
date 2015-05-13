<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CicloMatriz.php";

$matriz_ciclo = new CicloMatriz();
$matriz_ciclo->db_get_datos();
print_r($matriz_ciclo->to_json());


?>
 