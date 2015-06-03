<?php
header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Resize.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Apoderado.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Comuna.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Provincia.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_apoderado_by_run();
        break;
    case "2":
        ins_apoderado();
        break;
    case "3":
        ins_apoderado_joomla();
        break;
    default:
        break;
    
}
//SE USA EN ingreso_matricula
function get_apoderado_by_run(){
    $run_apoderado = $_POST["run_apoderado"];

    $apoderado = new Apoderado();
    $apoderado->set_run($run_apoderado);

    if($apoderado->db_get_apoderado_by_run() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    $direccion = new Direccion();
    $direccion->set_id_direccion($apoderado->get_id_direccion());
    $direccion->db_get_direccion_by_id();

    $comuna = new Comuna();
    $comuna->set_id_comuna($direccion->get_id_comuna());
    $comuna->db_get_comuna_by_id();

    $provincia = new Provincia();
    $provincia->set_id_provincia($comuna->get_id_provincia());
    $provincia->db_get_provincia_by_id();

    $matriz_apoderado = $apoderado->to_matriz();
    $matriz_apoderado["calle"] = $direccion->get_calle();
    $matriz_apoderado["numero"] = $direccion->get_numero();
    $matriz_apoderado["depto"] = $direccion->get_depto();
    $matriz_apoderado["sector"] = $direccion->get_sector();
    $matriz_apoderado["id_comuna"] = $direccion->get_id_comuna();
    $matriz_apoderado["nombre_comuna"] = $comuna->get_nombre();
    $matriz_apoderado["id_provincia"] = $comuna->get_id_provincia();
    $matriz_apoderado["nombre_provincia"] = $provincia->get_nombre();
    $matriz_apoderado["id_region"] = $provincia->get_id_region();
    $matriz_apoderado["result"] = true;

    print_r(json_encode($matriz_apoderado, JSON_UNESCAPED_UNICODE));

    return null;
}

//SE USA EN ingreso_matricula
function ins_apoderado(){
    $apoderado = new Apoderado();
    $apoderado->set_identidad(
        $_POST["run_apoderado"],
        $_POST["nombre1_apoderado"],
        $_POST["nombre2_apoderado"],
        $_POST["apellido1_apoderado"],
        $_POST["apellido2_apoderado"],
        $_POST["sexo_apoderado"],
        $_POST["email_apoderado"]
    );

    $apoderado->set_telefono_fijo($_POST["telefono_fijo_apoderado"]);
    $apoderado->set_telefono_celular($_POST["telefono_celular_apoderado"]);

    $direccion = new Direccion();
    $direccion->set_identidad(
        $_POST["calle_apoderado"],
        $_POST["numero_apoderado"],
        $_POST["depto_apoderado"],
        $_POST["sector_apoderado"],
        $_POST["id_comuna_apoderado"]
    );



    $validacion = true;
    if(!$apoderado->validar()){$validacion = false;}
    if(!$direccion->validar()){$validacion = false;}
    if(!$validacion){
        $result = array("result" => "1", "msg" => "Fallo de validación.");
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        die();
    }

    if($apoderado->db_con_apoderado_by_run() > "0"){
        $actualizar = $apoderado->db_upd_apoderado_by_run();
        $apoderado->set_id_direccion($_POST["id_direccion_apoderado"]);
        $direccion->set_id_direccion($apoderado->get_id_direccion());
        $direccion->db_upd_direccion_by_id();

        if($actualizar){
            $result = array("result" => "3", "msg" => "Actualización de datos exitosa.");
        }
    }else{
        $direccion->db_ins_direccion();
        $apoderado->set_id_direccion($direccion->get_id_direccion());
        $insertar = $apoderado->db_ins_apoderado();

        if($insertar){
            $result = array("result" => "3", "msg" => "Ingreso de datos exitoso.");

        }
    }
    if($_FILES["avatar_apoderado"]["error"] <= 0){

        $tmp_name = $_FILES["avatar_apoderado"]["tmp_name"];
        $ext = ".".pathinfo($_FILES["avatar_apoderado"]["name"], PATHINFO_EXTENSION);
        $ruta = $_SERVER["DOCUMENT_ROOT"]."/_avatars/";
        $new_name = $ruta.$apoderado->get_run().$ext;
        move_uploaded_file($tmp_name,$new_name);

        $resizeObj = new Resize($new_name);
        $resizeObj -> resizeImage(100, 100, 'crop');
        $resizeObj -> saveImage($new_name , 100);
        $apoderado->set_avatar($apoderado->get_run().$ext);
        $apoderado->db_upd_apoderado_avatar_by_run();

    }


    print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    die();
}

//SE USA EN ingreso_matricula
function ins_apoderado_joomla(){

    define('_JEXEC', 1);
    define('DS', DIRECTORY_SEPARATOR);
    define('JPATH_BASE', $_SERVER["DOCUMENT_ROOT"]);
    require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
    require JPATH_LIBRARIES.DS.'import.php';
    require JPATH_LIBRARIES.DS.'cms.php';

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

    $apoderado = new Apoderado();
    $apoderado->set_run($_POST["run_apoderado"]);
    $apoderado->set_nombre1($_POST["nombre1_apoderado"]);
    $apoderado->set_email($_POST["email_apoderado"]);

    $result["result"] = "0";
    $result["msg"] = "Lo sentimos, ocurrió un error fatal y el apoderado no pudo ser ingresado al sistema.";

    $validar = true;
    if(!$apoderado->validar_run()){$validar = false;}
    if(!$apoderado->validar_nombre1()){$validar = false;}
    if(!$apoderado->validar_email()){$validar = false;}

    $existencia = false;
    if($validar){
        $db = JFactory::getDBO();
        $db->setQuery("SELECT id FROM z_users WHERE username = '" . $apoderado->get_run()."'");
        $db->query();
        $data = $db->loadResult();

        //print_r("SELECT id FROM z_users WHERE username = " . $apoderado->get_run());
        if(!empty($data)){
            $result["result"] = "3";
            $result["msg"] = "El apoderado ya existe en el sistema.";
            $existencia = true;
        }else{
            $db->setQuery("SELECT id FROM z_users WHERE email = '" . $apoderado->get_email()."'");
            $db->query();
            $data = $db->loadResult();

            if(!empty($data)){
                $result["result"] = "1";
                $result["msg"] = "El mail del apoderado es usado por otro usuario.";
                $existencia = true;
            }
        }
    }else{
        $result["result"] = "1";
        $result["msg"] = "Fallo de validacion";
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
        //print_r($data);
        $save = true;
        $user = new JUser;
        if (!$user->bind($data)) {
            $save = false;
        }
        if (!$user->save()) {
            $save = false;
        }

        if (!$save) {
            $result["result"] = "1";
            $result["msg"] = "Error Fatal";
        }else{
            if($no_email){
                $result["result"] = "2";
                $result["msg"] = "Ingreso exitoso al sistema. Se asigno el email ".$_POST['run_apoderado']."@mail.cl. Recuerde cambiarlo más tarde.";
            }else{
                $result["result"] = "3";
                $result["msg"] = "Ingreso exitoso al sistema.";
            }
        }

    }
    $result = json_encode($result, JSON_UNESCAPED_UNICODE);
    print_r($result);

}
?>