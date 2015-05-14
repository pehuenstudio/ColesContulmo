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
//print_r($bloques);
//print_r($bloquesDel);

//$matriz_clase = new ClaseMatriz();
foreach($bloquesDel as $row){
    //print_r($row);
    $clase = new Clase();
    $clase->set_identidad(
        $id_curso,
        "null",
        $row["id_bloque"],
        $rbd_establecimiento
    );
    $clase->db_actualizar_clase_null();
  //  print_r($row);
}


foreach($bloques as $row){
    //print_r($row);
    $clase = new Clase();
    $clase->set_identidad(
        $id_curso,
        $row["id_asignatura"],
        $row["id_bloque"],
        $rbd_establecimiento
    );

    $clase->db_actualizar_clase();
   // print_r($row["id_bloque"]);

}




?>
 