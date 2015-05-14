<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CicloMatriz.php";

$matriz_ciclo = new CicloMatriz();
$matriz_ciclo->db_get_datos();
$matriz_ciclo = $matriz_ciclo->get_matriz();
$matriz = array();
foreach($matriz_ciclo as $row){
    if($row["id_ciclo"] > 0){
        array_push($matriz,$row);
    }
}
$json = json_encode($matriz, JSON_UNESCAPED_UNICODE);
print_r($json);

?>
 