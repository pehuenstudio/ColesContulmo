<?php
header('Content-Type: text/html; charset=utf-8');

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
define('JPATH_BASE', $_SERVER["DOCUMENT_ROOT"]);
require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
require JPATH_LIBRARIES.DS.'import.php';
require JPATH_LIBRARIES.DS.'cms.php';
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Persona.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Alumno.php";

JLoader::import('joomla.user.authentication');
JLoader::import('joomla.application.component.helper');

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();
jimport( 'joomla.user.helper');

$no_email = false;
if(empty($_POST["email_alumno"])){
    $no_email = true;
    $_POST["email_alumno"] = $_POST["run_alumno"]."@mail.cl";
}

$alumno = new \personas\Alumno();
$alumno->set_run($_POST["run_alumno"]);
$alumno->set_nombre1($_POST["nombre1_alumno"]);
$alumno->set_email($_POST["email_alumno"]);

$result["val"] = "0";
$result["msg"] = "Lo sentimos, ocurrió un error fatal y el alumno no pudo ser ingresado al sistema.";

$validar = true;
if(!$alumno->validar_run()){$validar = false;}
if(!$alumno->validar_nombre1()){$validar = false;}
if(!$alumno->validar_email()){$validar = false;}

$existencia = false;
if($validar){
    $db = JFactory::getDBO();
    $db->setQuery("SELECT id FROM z_users WHERE username = " . $alumno->get_run());
    $db->query();
    $data = $db->loadResult();

    if(!empty($data)){
        $result["val"] = "3";
        $result["msg"] = "El alumno ya existe en el sistema.";
        $existencia = true;
    }
}else{
    $result["val"] = "1";
    $result["msg"] = "Lo sentimos, el formulario del alumno contiene caracteres no permitidos.";
}


if(!$existencia) {
    $data = array(
        "name" => $alumno->get_nombre1(),
        "username" => $alumno->get_run(),
        "password" => $alumno->get_run(),
        "password2" => $alumno->get_run(),
        "email" => $alumno->get_email(),
        "block" => 0,
        "groups" => array("1", "2")
    );
    $save = true;
    $user = new JUser;
    if (!$user->bind($data)) {
        $save = false;
    }
    if (!$user->save()) {
        $save = false;
    }

    if (!$save) {
        $result["val"] = "0";
        $result["msg"] = "Lo sentimos, ocurrió un error fatal y el alumno no pudo ser ingresado al sistema.";

    }else{
        if($no_email){
            $result["val"] = "2";
            $result["msg"] = "Sin un email es imposible generar un usuario en el sistema, se asigno el email .".$_POST['run_alumno']."@mail.cl. Recuerde cambiarlo más tarde.";

        }else{
        $result["val"] = "3";
        $result["msg"] = "El alumno fue ingresado exitosamente en el sistema.";
        }
    }
}
$result = json_encode($result, JSON_UNESCAPED_UNICODE);
print_r($result);






?>