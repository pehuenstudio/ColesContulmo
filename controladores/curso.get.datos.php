<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CursoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/TipoEnsenanza.php";

$rbd_establecimiento = $_POST["rbd_establecimiento"];
$id_ciclo = $_POST["id_ciclo"];

$matriz_curso = new CursoMatriz();
$matriz_curso->db_get_datos($rbd_establecimiento, $id_ciclo);
$cursos = $matriz_curso->to_json();

$cursos = json_decode($cursos, JSON_UNESCAPED_UNICODE);


for ($i = 0; $i < count($cursos); $i++){

    switch ($cursos[$i]["id_tipo_ensenanza"]){
        case "10":
            if($cursos[$i]["id_grado"] == "4"){
                $cursos[$i]["nombre_curso"] = "Pre Kinder ".$cursos[$i]["grupo"];
            }elseif($cursos[$i]["id_grado"] == "5"){
                $cursos[$i]["nombre_curso"] = "Kinder ".$cursos[$i]["grupo"];
            }
            break;
        case "110":
            $cursos[$i]["nombre_curso"]= $cursos[$i]["id_grado"]." Básico ".$cursos[$i]["grupo"];
    }
    $tipo_ensenanza = new TipoEnsenanza();
    $tipo_ensenanza->set_id_tipo_ensenanza($cursos[$i]["id_tipo_ensenanza"]);
    $tipo_ensenanza->db_get_datos();

    $cursos[$i]["nombre_ensenanza"] = $tipo_ensenanza->get_nombre();


}
print_r(json_encode($cursos, JSON_UNESCAPED_UNICODE));

?>
 