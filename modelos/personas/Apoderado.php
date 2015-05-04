<?php

namespace personas;

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
require_once ROOT_MODELOS_PERSONAS."Persona.php";
//echo __FILE__."<br/>";
class Apoderado extends Persona{
    private $telefono_fijo;
    private $telefono_celular;

    function __construct()
    {

    }

    public function set_telefono_celular($telefono_celular)
    {
        $this->telefono_celular = $telefono_celular;
    }
    public function get_telefono_celular()
    {
        return $this->telefono_celular;
    }
    public function set_telefono_fijo($telefono_fijo)
    {
        $this->telefono_fijo = $telefono_fijo;
    }
    public function get_telefono_fijo()
    {
        return $this->telefono_fijo;
    }

    public function set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo,$email , $telefono_fijo,$telefono_celular){
        parent::set_identidad_nueva($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $email);
        $this->telefono_fijo = $telefono_fijo;
        $this->telefono_celular = $telefono_celular;
    }

    //VALIDAT TELEFONO FIJO
    public function validar_telefono_fijo(){
        global $v;
        if(!$v->validar_formato_numero($this->telefono_fijo,9,9)){
            echo ERRORCITO.CLASE_APODERADO." TELEFONO FIJO MUY CORTO O MUY LARGO O CONTIENE CARACTERES NO PERMITIDOS<br/>";
            $this->telefono_fijo = null;
            return false;
        }
        echo INFO.CLASE_APODERADO." TELEFONO FIJO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAT TELEFONO FIJO
    public function validar_telefono_celular(){
        global $v;
        if(!$v->validar_formato_numero($this->telefono_celular,9,9)){
            echo ERRORCITO.CLASE_APODERADO." TELEFONO CELULAR MUY CORTO O MUY LARGO O CONTIENE CARACTERES NO PERMITIDOS<br/>";
            $this->telefono_celular = null;
            return false;
        }
        echo INFO.CLASE_APODERADO." TELEFONO CELULAR INGRESADO CORRECTAMENTE<br/>";
        return true;
    }


    public function validar(){
        $result = true;
        if(!parent::validar_identidad()){
            $result = false;
        }
        if(!$this->validar_telefono_fijo()){
            $result = false;
        }
        if(!$this->validar_telefono_celular()){
            $result = false;
        }

        return $result;
    }

    public function to_json(){
        $persona = json_decode(parent::to_json0(),true);
        $persona["identidad"]["telefono_fijo"] = $this->telefono_fijo;
        $persona["identidad"]["telefono_celular"] =$this->telefono_celular;

        //array_push($persona,$alumno);
        //Svar_dump($persona);
        return json_encode($persona,JSON_UNESCAPED_UNICODE);
    }


    //++++++++++++++++++++++++++++++++++++++++++++++++++++MENJO EN BBDD+++++++++++++++++++++++++++++++++++++++++++++++++


    public function db_existencia(){
        global $myPDO;
        $run = $this->get_run();
        $sentencia = $myPDO->prepare("CALL get_apoderado(?)");
        $sentencia->bindParam(1, $run, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        if($sentencia->rowCount()>=1){
            //echo INFO.CLASE_APODERADO." DDBB FILA EXISTENTE <br/>";
            return true;
        }
        //echo INFO.CLASE_APODERADO." DDBB FILA INEXISTENTE <br/>";
        return false;
    }

    public function db_actualizar(){
        global $myPDO;

        $run = $this->get_run();
        $nombre1 = $this->get_nombre1();
        $nombre2 = $this->get_nombre2();
        $apellido1 = $this->get_apellido1();
        $apellido2 = $this->get_apellido2();
        $sexo = $this->get_sexo();
        $email = $this->get_email();
        $id_direccion = $this->get_direccion()->db_get_id("apoderados","apoderado",$run);

        $estado = "1";

        $sentencia = $myPDO->prepare("CALL upd_apoderado(?,?,?,?,?,?,?,?,?,?,?)");
        $sentencia->bindParam(1,$run);
        $sentencia->bindParam(2,$nombre1);
        $sentencia->bindParam(3,$nombre2);
        $sentencia->bindParam(4,$apellido1);
        $sentencia->bindParam(5,$apellido2);
        $sentencia->bindParam(6,$sexo);
        $sentencia->bindParam(7,$email);
        $sentencia->bindParam(8,$id_direccion);
        $sentencia->bindParam(9,$this->telefono_fijo);
        $sentencia->bindParam(10,$this->telefono_celular);
        $sentencia->bindParam(11,$estado);
        $result = $sentencia->execute();

        $this->get_direccion()->set_id_direccion($id_direccion);
        $this->get_direccion()->db_actualizar();

        if(!$result){
            echo ERRORCITO.CLASE_APODERADO." DDBB ERROR EN ACTUALIZACION! <br/>";
            return true;
        }
        echo INFO.CLASE_APODERADO." DDBB EXITO EN ACTUALIZACION! <br/>";
        return false;
    }

    public function db_ingresar(){
        global $myPDO;
        $existencia = $this->db_existencia();
        if($existencia){
            $this->db_actualizar();
            return true;
        }

        $run = $this->get_run();
        $nombre1 = $this->get_nombre1();
        $nombre2 = $this->get_nombre2();
        $apellido1 = $this->get_apellido1();
        $apellido2 = $this->get_apellido2();
        $sexo = $this->get_sexo();
        $email = $this->get_email();
        $id_direccion = $this->get_direccion()->db_ingresar();
        if(empty($id_direccion)){
            echo ERRORCITO.CLASE_APODERADO."DIRECCION INGRESADA INCORRECTAMENTE EN BBDD";
            return false;
        }

        $sentencia = $myPDO->prepare("CALL set_apoderado(?,?,?,?,?,?,?,?,?,?);");
        $sentencia->bindParam(1,$run);
        $sentencia->bindParam(2,$nombre1);
        $sentencia->bindParam(3,$nombre2);
        $sentencia->bindParam(4,$apellido1);
        $sentencia->bindParam(5,$apellido2);
        $sentencia->bindParam(6,$sexo);
        $sentencia->bindParam(7,$email);
        $sentencia->bindParam(8,$id_direccion);
        $sentencia->bindParam(9,$this->telefono_fijo);
        $sentencia->bindParam(10,$this->telefono_celular);
        $result = $sentencia->execute();

        if(!$result){
            echo ERRORCITO.CLASE_APODERADO."APODERADO INGRESADO INCORRECTAMENTE EN BBDD";
            $sentencia = $myPDO->query("DELETE FROM direcciones WHERE id_direccion = ".$id_direccion."");
            return $result;
        }
        return $result;
    }

    function db_get_datos(){
        global $myPDO;
        $run_apoderado = $this->get_run();
        $sentencia = $myPDO->prepare("CALL get_apoderado(?)");
        $sentencia->bindParam(1, $run_apoderado, \PDO::PARAM_STR, 9);
        $result = $sentencia->execute();
        $data = $sentencia->fetchAll();
        //var_dump($data);
        foreach($data as $row) {
            $this->set_run($row["run_apoderado"]);
            $this->set_nombre1($row["nombre1"]);
            $this->set_nombre2($row["nombre2"]);
            $this->set_apellido1($row["apellido1"]);
            $this->set_apellido2($row["apellido2"]);
            $this->set_sexo($row["sexo"]);
            $this->set_email($row["email"]);
            $this->set_id_direccion($row["id_direccion"]);
            $this->set_telefono_fijo($row["telefono_fijo"]);
            $this->set_telefono_celular($row["telefono_celular"]);
        }
        return $result;
    }
}
/*
$a = new Apoderado();
$a->set_identidad("166890837", "RodÏrigo", "Alberto", "Sepúlveda", "Castro", "M",123456789,564994127);
$a->validar();
var_dump($a);*/
?> 