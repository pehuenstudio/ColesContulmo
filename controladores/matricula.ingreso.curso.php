<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Resize.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Persona.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Alumno.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Apoderado.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Curso.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetidoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Matricula.php";


//print_r($_POST);

//move_uploaded_file($_FILES["avatar_alumno"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"]."/_avatars/20150504.png");

if(empty($_POST["id_grado"])){
    $_POST["id_grado"] = "";
}
if(empty($_POST["grupo"])){
    $_POST["grupo"] = "";
}

$alumno = new \personas\Alumno();
$alumno->set_run($_POST["run_alumno"]);

$apoderado = new \personas\Apoderado();
$apoderado->set_run($_POST["run_apoderado"]);

$curso = new Curso();
$curso->set_identidad(
    $_POST["rbd_establecimiento"],
    $_POST["id_grado"],
    $_POST["id_tipo_ensenanza"],
    $_POST["grupo"]
);

$result["val"] = "0";
$result["msg"] = "Lo sentimos, ocurrió un error fatal y la matricula no pudo ser ingresada.";

$validar = true;
if(!$alumno->validar_run()){$validar = false;};
if(!$apoderado->validar_run()){$validar = false;};
if(!$curso->validar()){$validar = false;};
//var_dump($validar);

$periodo = $_POST["periodo"];
$establecimiento_procedencia = $_POST["establecimiento_procedencia"];
$fecha_incorporacion = date("Y-m-d");

$matricula = new Matricula();
$matricula->set_identidad(
    $curso->get_id_tipo_ensenanza(),
    $periodo, $alumno->get_run(),
    $curso->get_rbd_establecimiento(),
    $apoderado->get_run(),
    $curso->db_get_curso_id(),
    $establecimiento_procedencia,
    $fecha_incorporacion
);

if(!$matricula->validar()){ $validar = false;};
//var_dump($validar);

$ingreso = true;
if($validar){
    if(!$matricula->db_existencia()){
        if(!$matricula->db_ingresar()){$ingreso = false;};
    }else{
        $ingreso = false;
        $result["val"] = "2";
        $result["msg"] = "Lo sentimos, el alumno ya cuenta con una matrícula para este periodo.";
    }
}else{
    $ingreso = false;
    $result["val"] = "1";
    $result["msg"] = "Lo sentimos, el formulario de matrícula tiene caracteres no permitidos.";
}

if($ingreso){
    $result["val"] = "3";
    $result["msg"] = "Matricula ingresada exitosamente.";
}
//var_dump($ingreso);
$result = json_encode($result, JSON_UNESCAPED_UNICODE);
print_r($result);


?>
