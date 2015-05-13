<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/ClaseMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Clase.php";


$rbd_establecimiento = $_POST["rbd_establecimiento"];
$id_curso = $_POST["id_curso"];
$id_asignatura = $_POST["id_asignatura"];
$bloques = json_decode($_POST["bloques"], JSON_UNESCAPED_UNICODE);
$bloquesDel = json_decode($_POST["bloquesDel"], JSON_UNESCAPED_UNICODE);

//$matriz_clase = new ClaseMatriz();
foreach($bloques as $row){
    //print_r($row);
    $clase = new Clase();
    $clase->set_identidad(
        $id_curso,
        $id_asignatura,
        $row,
        $rbd_establecimiento
    );
    //print_r($clase);
    $clase->db_actualizar_estado("1");
    //$matriz_clase->to_matriz($clase);
}

foreach($bloquesDel as $row){
    //print_r($row);
    $clase = new Clase();
    $clase->set_identidad(
        $id_curso,
        NULL,
        $row,
        $rbd_establecimiento
    );
    $clase->db_actualizar_estado("1");
}
/*
$matriz_clase->db_ingresar();
$matriz_clase->db_actualizar_estado("1");

$matriz_clase_del = new ClaseMatriz();

foreach($bloquesDel as $row){
    //print_r($row);
    $clase = new Clase();
    $clase->set_identidad(
        $id_curso,
        $id_asignatura,
        $row,
        $rbd_establecimiento
    );
    $matriz_clase_del->to_matriz($clase);
}
$matriz_clase_del->db_actualizar_estado("0");
*/

?>
 