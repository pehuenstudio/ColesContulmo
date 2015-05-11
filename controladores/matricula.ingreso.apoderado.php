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

$result["val"] = "0";
$result["msg"] = "Lo sentimos, ocurrió un error fatal y el apoderado no pudo ser ingresado.";

$validar = true;
if(!$apoderado->validar()){$validar = false;};

$ingreso = true;
if($validar){
    if(!$apoderado->db_ingresar()){ $ingreso = false;};
}else{
    $ingreso = false;
    $result["val"] = "1";
    $result["msg"] = "Lo sentimos, el formulario del apoderado contiene caracteres no permitidos.";
}

if($ingreso){
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
    $result["msg"] = "El apoderado fue ingresado exitosamente.";
}

$result = json_encode($result, JSON_UNESCAPED_UNICODE);
print_r($result);


?>
