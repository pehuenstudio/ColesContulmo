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
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/MatrizGradosRepetidos.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Matricula.php";


//print_r($_POST);

//move_uploaded_file($_FILES["avatar_alumno"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"]."/_avatars/20150504.png");



$alumno = new \personas\Alumno();
$alumno->set_identidad(
    $_POST["run_alumno"],
    $_POST["nombre1_alumno"],
    $_POST["nombre2_alumno"],
    $_POST["apellido1_alumno"],
    $_POST["apellido2_alumno"],
    $_POST["sexo_alumno"],
    $_POST["email_alumno"],
    $_POST["fecha_nacimiento_alumno"],
    $_POST["pde"],
    $_POST["id_religion_alumno"],
    $_POST["persona_vive_alumno"],
    $_POST["grado_educacional_madre"],
    $_POST["grado_educacional_padre"]
);

$direccion_alumno = new Direccion();
$direccion_alumno->set_identidad(
    $_POST["calle_alumno"],
    $_POST["numero_alumno"],
    $_POST["depto_alumno"],
    $_POST["sector_alumno"],
    $_POST["id_comuna_alumno"]
);

$alumno->set_direccion($direccion_alumno);
$matriz_gra = array(
    array("id_grado"=>"4", "id_tipo_ensenanza" => 10, "cantidad" => $_POST["PK"]),
    array("id_grado"=>"5", "id_tipo_ensenanza" => 10, "cantidad" => $_POST["KD"]),
    array("id_grado"=>"1", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["1B"]),
    array("id_grado"=>"2", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["2B"]),
    array("id_grado"=>"3", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["3B"]),
    array("id_grado"=>"4", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["4B"]),
    array("id_grado"=>"5", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["5B"]),
    array("id_grado"=>"6", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["6B"]),
    array("id_grado"=>"7", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["7B"]),
    array("id_grado"=>"8", "id_tipo_ensenanza" => 110, "cantidad" => $_POST["8B"]),
);
$matriz_grados_repetidos = new MatrizGradosRepetidos();
foreach($matriz_gra as $row){
    $matriz_grados_repetidos->to_matriz(
        new GradoRepetido(
            "166890837",
            $row["id_grado"],
            $row["id_tipo_ensenanza"],
            $row["cantidad"]
        )
    );
}
$apoderado = new \personas\Apoderado();
$apoderado->set_identidad(
    $_POST["run_apoderado"],
    $_POST["nombre1_apoderado"],
    $_POST["nombre2_apoderado"],
    $_POST["apellido1_apoderado"],
    $_POST["apellido2_apoderado"],
    $_POST["sexo_apoderado"],
    $_POST["email_apoderado"],
    $_POST["telefono_fijo_apoderado"],
    $_POST["telefono_celular_apoderado"]
);
$direccion_apoderado = new Direccion();
$direccion_apoderado->set_identidad(
    $_POST["calle_apoderado"],
    $_POST["numero_apoderado"],
    $_POST["depto_apoderado"],
    $_POST["sector_apoderado"],
    $_POST["id_comuna_apoderado"]
);
$apoderado->set_direccion($direccion_apoderado);

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
if(!$alumno->validar()){$validar = false;};
if(!$matriz_grados_repetidos->validar()){$validar = false;}
if(!$apoderado->validar()){$validar = false;};
if(!$curso->validar()){$validar = false;};

$ingreso = true;
if($validar){
    if(!$alumno->db_ingresar()){$ingreso = false;};
    if(!$matriz_grados_repetidos->db_ingresar()){$ingreso = false;};
    if(!$apoderado->db_ingresar()){ $ingreso = false;};
}else{
    $ingreso = false;
    $result["val"] = "1";
    $result["msg"] = "Lo sentimos, el formulario de matrícula tiene caracteres no permitidos.";
}

if($ingreso){
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
}

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

    if($_FILES["avatar_alumno"]["error"] <= 0){

        $tmp_name = $_FILES["avatar_alumno"]["tmp_name"];
        $ext = ".".pathinfo($_FILES["avatar_alumno"]["name"], PATHINFO_EXTENSION);
        $ruta = $_SERVER["DOCUMENT_ROOT"]."/_avatars/";
        $new_name = $ruta.$alumno->get_run().$ext;
        $result1 = move_uploaded_file($tmp_name,$new_name);

        $resizeObj = new Resize($new_name);
        $resizeObj -> resizeImage(100, 100, 'crop');
        $resizeObj -> saveImage($new_name , 100);
        $alumno->db_actualizar_avatar($alumno->get_run().$ext);
    }


    if($_FILES["avatar_apoderado"]["error"] <= 0){
        $tmp_name = $_FILES["avatar_apoderado"]["tmp_name"];
        $ext = ".".pathinfo($_FILES["avatar_apoderado"]["name"], PATHINFO_EXTENSION);
        $ruta = $_SERVER["DOCUMENT_ROOT"]."/_avatars/";
        $new_name = $ruta.$apoderado->get_run().$ext;

        move_uploaded_file($tmp_name,$new_name);

        $resizeObj2 = new Resize($new_name);
        $resizeObj2 -> resizeImage(100, 100, 'crop');
        $resizeObj2 -> saveImage($new_name , 100);
        $apoderado->db_actualizar_avatar($apoderado->get_run().$ext);
    }

    $result["val"] = "3";
    $result["msg"] = "Matricula ingresada exitosamente.";
}

$result = json_encode($result, JSON_UNESCAPED_UNICODE);
print_r($result);


?>