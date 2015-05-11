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
$matriz_grados_repetidos = new GradoRepetidoMatriz();
foreach($matriz_gra as $row){
    $matriz_grados_repetidos->to_matriz(
        new GradoRepetido(
            $alumno->get_run(),
            $row["id_grado"],
            $row["id_tipo_ensenanza"],
            $row["cantidad"]
        )
    );
}

$result["val"] = "0";
$result["msg"] = "Lo sentimos, ocurrió un error fatal y el alumno no pudo ser ingresado.";

$validar = true;
if(!$alumno->validar()){$validar = false;};
if(!$matriz_grados_repetidos->validar()){$validar = false;}


$ingreso = true;
if($validar){
    if(!$alumno->db_ingresar()){$ingreso = false;};
    if(!$matriz_grados_repetidos->db_ingresar()){$ingreso = false;};

}else{
    $ingreso = false;
    $result["val"] = "1";
    $result["msg"] = "Lo sentimos, el formulario del alumno contiene caracteres no permitidos.";
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

    $result["val"] = "3";
    $result["msg"] = "El alumno fue ingresado exitosamente.";
}

$result = json_encode($result, JSON_UNESCAPED_UNICODE);
print_r($result);


?>
