<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Resize.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Alumno.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/AlumnoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Comuna.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Provincia.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetidoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_alumno_by_run();
        break;
    case "2":
        ins_alumno();
        break;
    case "3":
        ins_alumno_joomla();
        break;
    case "4":
        get_alumnos_by_id_curso();
        break;
    default:
        break;
    
}
//SE USA EN ingreso_matricula
function get_alumno_by_run(){
    $run_alumno = $_POST["run_alumno"];

    $alumno = new Alumno();
    $alumno->set_run($run_alumno);
    if($alumno->db_get_alumno_by_run() == "0"){
        $result = array(
            "result" => false
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }



    $direccion = new Direccion();
    $direccion->set_id_direccion($alumno->get_id_direccion());
    $direccion->db_get_direccion_by_id();

    $comuna = new Comuna();
    $comuna->set_id_comuna($direccion->get_id_comuna());
    $comuna->db_get_comuna_by_id();

    $provincia = new Provincia();
    $provincia->set_id_provincia($comuna->get_id_provincia());
    $provincia->db_get_provincia_by_id();

    $matriz_grados_repetidos = new GradoRepetidoMatriz();
    $matriz_grados_repetidos->db_get_grados_repetidos_by_run_alumno($alumno->get_run());

    $matriz_alumno = $alumno->to_matriz();
    $matriz_alumno["calle"] = $direccion->get_calle();
    $matriz_alumno["numero"] = $direccion->get_numero();
    $matriz_alumno["depto"] = $direccion->get_depto();
    $matriz_alumno["sector"] = $direccion->get_sector();
    $matriz_alumno["id_comuna"] = $direccion->get_id_comuna();
    $matriz_alumno["nombre_comuna"] = $comuna->get_nombre();
    $matriz_alumno["id_provincia"] = $comuna->get_id_provincia();
    $matriz_alumno["nombre_provincia"] = $provincia->get_nombre();
    $matriz_alumno["id_region"] = $provincia->get_id_region();

    $matriz_alumno["grados_repetidos"] = $matriz_grados_repetidos->get_matriz();

    $matriz_alumno["result"] = true;

    print_r(json_encode($matriz_alumno, JSON_UNESCAPED_UNICODE));


}

//SE USA EN ingreso_matricula
function ins_alumno(){
    $alumno = new Alumno();
    $alumno->set_identidad(
        $_POST["run_alumno"],
        $_POST["nombre1_alumno"],
        $_POST["nombre2_alumno"],
        $_POST["apellido1_alumno"],
        $_POST["apellido2_alumno"],
        $_POST["sexo_alumno"],
        $_POST["email_alumno"]
    );

    $alumno->set_fecha_nacimiento($_POST["fecha_nacimiento_alumno"]);
    $alumno->set_pde($_POST["pde"]);
    $alumno->set_id_religion($_POST["id_religion_alumno"]);
    $alumno->set_grado_educacional_padre($_POST["grado_educacional_padre"]);
    $alumno->set_grado_educacional_madre($_POST["grado_educacional_madre"]);
    $alumno->set_persona_vive($_POST["persona_vive_alumno"]);

    $direccion = new Direccion();
    $direccion->set_identidad(
        $_POST["calle_alumno"],
        $_POST["numero_alumno"],
        $_POST["depto_alumno"],
        $_POST["sector_alumno"],
        $_POST["id_comuna_alumno"]
    );

    $array_grados_repetidos = array(
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
    foreach($array_grados_repetidos as $row){
        $grado_repetido = new GradoRepetido();
        $grado_repetido->set_identidad(
            $alumno->get_run(),
            $row["id_grado"],
            $row["id_tipo_ensenanza"],
            $row["cantidad"]
        );

        $matriz_grados_repetidos->to_matriz($grado_repetido);
    }


    $validacion = true;
    if(!$alumno->validar()){$validacion = false;}
    if(!$direccion->validar()){$validacion = false;}
    if(!$matriz_grados_repetidos->validar()){$validacion = false;}
    if(!$validacion){
        $result = array("result" => "1", "msg" => "Fallo de validación.");
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        die();
    }

    if($alumno->db_con_alumno_by_run() > "0"){
        $actualizar = $alumno->db_upd_alumno_by_run();
        $alumno->set_id_direccion($_POST["id_direccion_alumno"]);
        $direccion->set_id_direccion($alumno->get_id_direccion());
        $direccion->db_upd_direccion_by_id();

        if($actualizar){
            $result = array("result" => "3", "msg" => "Actualización de datos exitosa.");
        }
    }else{
        $direccion->db_ins_direccion();
        $alumno->set_id_direccion($direccion->get_id_direccion());
        $insertar = $alumno->db_ins_alumno();

        if($insertar){
            $result = array("result" => "3", "msg" => "Ingreso de datos exitoso.");

        }
    }
    if($_FILES["avatar_alumno"]["error"] <= 0){

        $tmp_name = $_FILES["avatar_alumno"]["tmp_name"];
        $ext = ".".pathinfo($_FILES["avatar_alumno"]["name"], PATHINFO_EXTENSION);
        $ruta = $_SERVER["DOCUMENT_ROOT"]."/_avatars/";
        $new_name = $ruta.$alumno->get_run().$ext;
        move_uploaded_file($tmp_name,$new_name);

        $resizeObj = new Resize($new_name);
        $resizeObj -> resizeImage(100, 100, 'crop');
        $resizeObj -> saveImage($new_name , 100);
        $alumno->set_avatar($alumno->get_run().$ext);
        $alumno->db_upd_alumno_avatar_by_run();

    }
    $matriz_grados_repetidos->db_ins_or_upd();


    print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    die();
}

//SE USA EN ingreso_matricula
function ins_alumno_joomla(){
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
    if(empty($_POST["email_alumno"])){
        $no_email = true;
        $_POST["email_alumno"] = $_POST["run_alumno"]."@mail.cl";
    }

    $alumno = new Alumno();
    $alumno->set_run($_POST["run_alumno"]);
    $alumno->set_nombre1($_POST["nombre1_alumno"]);
    $alumno->set_email($_POST["email_alumno"]);

    $result["result"] = "1";
    $result["msg"] = "Error fatal.";

    $validar = true;
    if(!$alumno->validar_run()){$validar = false;}
    if(!$alumno->validar_nombre1()){$validar = false;}
    if(!$alumno->validar_email()){$validar = false;}

    $existencia = false;
    if($validar){
        $db = JFactory::getDBO();
        $db->setQuery("SELECT id FROM z_users WHERE username = '" . $alumno->get_run()."'");
        $db->query();
        $data = $db->loadResult();
        if(!empty($data)){
            $result["result"] = "3";
            $result["msg"] = "El alumno ya existe en el sistema.";
            $existencia = true;
        }else{
            $db->setQuery("SELECT id FROM z_users WHERE email = '" . $alumno->get_email()."'");
            $db->query();
            $data = $db->loadResult();

            if(!empty($data)){
                $result["result"] = "1";
                $result["msg"] = "El mail del alumno es usado por otro usuario.";
                $existencia = true;
            }
        }
    }else{
        $result["result"] = "1";
        $result["msg"] = "Fallo de validación.";
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
            $result["result"] = "1";
            $result["msg"] = "Error fatal";

        }else{
            if($no_email){
                $result["result"] = "2";
                $result["msg"] = "Ingreso exitoso al sistema. Se asigno el email ".$_POST['run_alumno']."@mail.cl. Recuerde cambiarlo mas tarde.";

            }else{
                $result["result"] = "3";
                $result["msg"] = "Ingreso exitoso al sistema.";
            }
        }
    }
    $result = json_encode($result, JSON_UNESCAPED_UNICODE);
    print_r($result);
}

function get_alumnos_by_id_curso(){
    $id_curso = $_POST["id_curso"];
    $matriz_alumnos = new AlumnoMatriz();
    if($matriz_alumnos->db_get_alumnos_by_id_curso($id_curso) == "0"){
        $result = array();

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        return null;
    }

    print_r($matriz_alumnos->to_json());

}


?>