<?php
header('Content-Type: text/html; charset=utf-8');

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
define('JPATH_BASE', $_SERVER["DOCUMENT_ROOT"]);
require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
require JPATH_LIBRARIES.DS.'import.php';
require JPATH_LIBRARIES.DS.'cms.php';
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Persona.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Apoderado.php";

JLoader::import('joomla.user.authentication');
JLoader::import('joomla.application.component.helper');

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();
jimport( 'joomla.user.helper');

$no_email = false;
if(empty($_POST["email_apoderado"])){
    $no_email = true;
    $_POST["email_apoderado"] = $_POST["run_apoderado"]."@mail.cl";
}

$apoderado = new \personas\Apoderado();
$apoderado->set_run($_POST["run_apoderado"]);
$apoderado->set_nombre1($_POST["nombre1_apoderado"]);
$apoderado->set_email($_POST["email_apoderado"]);

$result["val"] = "0";
$result["msg"] = "Lo sentimos, ocurrió un error fatal y el apoderado no pudo ser ingresado al sistema.";

$validar = true;
if(!$apoderado->validar_run()){$validar = false;}
if(!$apoderado->validar_nombre1()){$validar = false;}
if(!$apoderado->validar_email()){$validar = false;}

$existencia = false;
if($validar){
    $db = JFactory::getDBO();
    $db->setQuery("SELECT id FROM z_users WHERE username = " . $apoderado->get_run());
    $db->query();
    $data = $db->loadResult();

    if(!empty($data)){
        $result["val"] = "3";
        $result["msg"] = "El apoderado ya existe en el sistema.";
        $existencia = true;
    }
}else{
    $result["val"] = "1";
    $result["msg"] = "Lo sentimos, el formulario del apoderado contiene caracteres no permitidos.";
}


if(!$existencia) {
    $data = array(
        "name" => $apoderado->get_nombre1(),
        "username" => $apoderado->get_run(),
        "password" => $apoderado->get_run(),
        "password2" => $apoderado->get_run(),
        "email" => $apoderado->get_email(),
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
        $result["msg"] = "Lo sentimos, ocurrió un error fatal y el apoderado no pudo ser ingresado al sistema.";
    }else{
        if($no_email){
            $result["val"] = "2";
            $result["msg"] = "Sin un email es imposible generar un usuario en el sistema, se asigno el email .".$_POST['run_apoderado']."@mail.cl. Recuerde cambiarlo más tarde.";
        }else{
            $result["val"] = "3";
            $result["msg"] = "El apoderado fue ingresado exitosamente en el sistema.";
        }
    }

}
$result = json_encode($result, JSON_UNESCAPED_UNICODE);
print_r($result);






?>