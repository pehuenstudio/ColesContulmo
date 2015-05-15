<?php
//echo __FILE__."<br/>";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Persona.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Profesor.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/ProfesorMatriz.php";

$rbd_establecimiento = $_POST["rbd_establecimiento"];
//print_r($_POST);

$matriz_profesor =  new \personas\ProfesorMatriz();
$matriz_profesor->db_get_datos($rbd_establecimiento);
print_r($matriz_profesor->to_json());

?>
