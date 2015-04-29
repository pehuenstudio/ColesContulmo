<?php

namespace personas;

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
require_once ROOT_MODELOS_PERSONAS."Persona.php";
echo __FILE__."<br/>";
class Alumno extends Persona {
    private $fecha_nacimiento;
    private $pde;
    private $id_religion;
    private $grado_educacional_padre;
    private $grado_educacional_madre;
    private $persona_vive;

    //CONSTRUCTOR
    function __construct(){

    }

    //GETTER y SETTER
    public function get_fecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }
    public function set_fecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }
    public function get_grado_educacional_madre()
    {
        return $this->grado_educacional_madre;
    }
    public function set_grado_educacional_madre($grado_educacional_madre)
    {
        $this->grado_educacional_madre = $grado_educacional_madre;
    }
    public function get_grado_educacional_padre()
    {
        return $this->grado_educacional_padre;
    }
    public function set_grado_educacional_padre($grado_educacional_padre)
    {
        $this->grado_educacional_padre = $grado_educacional_padre;
    }
    public function get_pde()
    {
        return $this->pde;
    }
    public function set_pde($pde)
    {
        $this->pde = $pde;
    }
    public function get_persona_vive()
    {
        return $this->persona_vive;
    }
    public function set_persona_vive($persona_vive)
    {
        $this->persona_vive = $persona_vive;
    }
    public function get_id_religion()
    {
        return $this->id_religion;
    }
    public function set_id_religion($id_religion)
    {
        $this->id_religion = $id_religion;
    }

    public function set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $fecha_nacimiento, $pde, $id_religion, $persona_vive,$grado_educacional_madre, $grado_educacional_padre){
        parent::set_identidad_nueva($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo);
        $this->fecha_nacimiento        = $fecha_nacimiento;
        $this->pde                     = $pde;
        $this->id_religion                = $id_religion;
        $this->grado_educacional_madre = $grado_educacional_madre;
        $this->grado_educacional_padre = $grado_educacional_padre;
        $this->persona_vive            = $persona_vive;
    }

//+++++++++++++++++++++++++++++++++++++++++VALIDACIONES++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //VALIDAR FECHA DE NACIMIENTO
    public function validar_fecha_nacimiento(){
        global $v;
        if(!$v->validar_formato_fecha($this->fecha_nacimiento)){
            echo ERRORCITO.CLASE_ALUMNO." FECHA CON FORMATO INCORRECTO<br/>";
            $this->fecha_nacimiento = null;
            return false;
        }
        $a = substr(str_replace("-","",$this->fecha_nacimiento),0,4);
        $m = substr(str_replace("-","",$this->fecha_nacimiento),4,2);
        $d = substr(str_replace("-","",$this->fecha_nacimiento),6,2);

        //VALIDAR AÑO
        if((date("Y")-(int)$a)<3){
            echo ERRORCITO.CLASE_ALUMNO."FECHA CON AÑO DE NACIMIENTO ES MUY RECIENTE<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR MES
        if((int)$m<1 or (int)$m>12){
            echo ERRORCITO.CLASE_ALUMNO."FECHA CON MES FUERA DE RANGO 1-12<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR DÍA
        if((int)$d<1 or (int)$d>cal_days_in_month(CAL_GREGORIAN, (int)$m, (int)$a)){
            echo ERRORCITO.CLASE_ALUMNO."FECHA CON DIA QUE NO CORRESPONDE AL MES<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        echo INFO.CLASE_ALUMNO." FECHA INGRESADA CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR PDE
    public function validar_pde(){
        global $v;
        if(!$v->validar_formato_verdadero_falso($this->pde)){
            echo ERRORCITO.CLASE_ALUMNO." PDE INGRESADO INCORECTAMENTE<br/>";
            $this->pde = null;
            return false;
        }
        echo INFO.CLASE_ALUMNO." PDE INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR ID_RELIGION
    public function validar_id_religion(){
        global $v;
        $result = true;
        if(!$v->validar_formato_numero($this->id_religion,1,1)){
            echo ERRORCITO.CLASE_ALUMNO." ID_RELIGION INGRESADO INCORRECTAMENTE<br/>";
            $this->id_religion = null;
            return false;
        }
        echo INFO.CLASE_ALUMNO." ID_RELIGION INGRESADO CORRECTAMENTE<br/>";
        if($this->id_religion == "0"){
            $this->id_religion = null;
        }
        return true;
    }

    //VALIDAR GRADO EDUCACIONAL PADRE
    public function validar_grado_educacional_padre(){
        global $v;
        if(!$v->validar_grado_educacional($this->grado_educacional_padre)){
            echo ERRORCITO.CLASE_ALUMNO." GEP INGRESADO INCORRECTAMENTE<br/>";
            $this->grado_educacional_padre = null;
            return false;
        }
        echo INFO.CLASE_ALUMNO." GEP INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR GRADO EDUCACIONAL MADRW
    public function validar_grado_educacional_madre(){
        global $v;
        if(!$v->validar_grado_educacional($this->grado_educacional_madre)){
            echo ERRORCITO.CLASE_ALUMNO." GEM INGRESADO INCORRECTAMENTE<br/>";
            $this->grado_educacional_madre = null;
            return false;
        }
        echo INFO.CLASE_ALUMNO." GEM INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR PERSONA VIVE
    public function validar_persona_vive(){
        global $v;
        if(!$v->validar_formato_numero_texto($this->persona_vive,3,100)){
            echo ERRORCITO.CLASE_ALUMNO." PERSONA VIVE ES MUY CORTO O MUY LARGO O0 CONTIENE CARACTERES NO ADMITIDOS<br/>";
            $this->persona_vive = null;
            return false;
        }
        echo INFO.CLASE_ALUMNO." PERSONA VIVE INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //
    public function validar(){
        $result = true;

        if(!parent::validar_identidad()){
            $result = false;
        }
        if(!$this->validar_fecha_nacimiento()){
            $result = false;
        }
        if(!$this->validar_pde()){
            $result = false;
        }
        if(!$this->validar_id_religion()){
            $result = false;
        }
        if(!$this->validar_grado_educacional_padre()){
            $result = false;
        }
        if(!$this->validar_grado_educacional_madre()){
            $result = false;
        }

        return $result;
    }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function to_jj()
    {

        $persona = json_decode(parent::to_json(),true);
        $persona["identidad"]["fecha_nacimiento"] = $this->fecha_nacimiento;
        $persona["identidad"]["pde"] =$this->pde;
        $persona["identidad"]["grado_educacional_madre"] = $this->grado_educacional_madre;
        $persona["identidad"]["grado_educacional_padre"] = $this->grado_educacional_padre;
        $persona["identidad"]["persona_vive"] = $this->persona_vive;
        $persona["identidad"]["text"] = "hola mundo!";

        //array_push($persona,$alumno);
        //var_dump($persona);
        return json_encode($persona);
    }

    //++++++++++++++++++++++++++++++++++++++++++++INGRESO BBDD++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function db_existencia(){
        global $myPDO;
        $run = $this->get_run();
        $sentencia = $myPDO->prepare("CALL get_alumno(?)");
        $sentencia->bindParam(1, $run, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        if($sentencia->rowCount()>=1){
            echo INFO.CLASE_ALUMNO." DDBB FILA EXISTENTE <br/>";
            return true;
        }
        echo INFO.CLASE_ALUMNO." DDBB FILA INEXISTENTE <br/>";
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
        $id_direccion = $this->get_direccion()->db_get_direccion_id("alumnos","alumno",$run);


        $estado = "1";

        $sentencia = $myPDO->prepare("CALL upd_alumno(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $sentencia->bindParam(1,$run);
        $sentencia->bindParam(2,$nombre1);
        $sentencia->bindParam(3,$nombre2);
        $sentencia->bindParam(4,$apellido1);
        $sentencia->bindParam(5,$apellido2);
        $sentencia->bindParam(6,$sexo);
        $sentencia->bindParam(7,$this->fecha_nacimiento);
        $sentencia->bindParam(8,$this->pde);
        $sentencia->bindParam(9,$id_direccion);
        $sentencia->bindParam(10,$this->id_religion);
        $sentencia->bindParam(11,$this->grado_educacional_madre);
        $sentencia->bindParam(12,$this->grado_educacional_padre);
        $sentencia->bindParam(13,$this->persona_vive);
        $sentencia->bindParam(14,$estado);
        $result = $sentencia->execute();

        $this->get_direccion()->set_id_direccion($id_direccion);
        $this->get_direccion()->db_actualizar();

       // $sentencia = $myPDO->prepare("CALL upd_direccion(?,?,?,?,?,?,?)");


        if(!$result){
            echo ERRORCITO.CLASE_ALUMNO." DDBB ERROR EN ACTUALIZACION! <br/>";
            return true;
        }
        echo INFO.CLASE_ALUMNO." DDBB EXITO EN ACTUALIZACION! <br/>";
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
        $id_direccion = $this->get_direccion()->db_ingresar();
        if(empty($id_direccion)){
            echo ERRORCITO.CLASE_ALUMNO."DIRECCION INGRESADA INCORRECTAMENTE EN BBDD";
            return false;
        }


        $sentencia = $myPDO->prepare("CALL set_alumno(?,?,?,?,?,?,?,?,?,?,?,?,?);");
        $sentencia->bindParam(1,$run);
        $sentencia->bindParam(2,$nombre1);
        $sentencia->bindParam(3,$nombre2);
        $sentencia->bindParam(4,$apellido1);
        $sentencia->bindParam(5,$apellido2);
        $sentencia->bindParam(6,$sexo);
        $sentencia->bindParam(7,$this->fecha_nacimiento);
        $sentencia->bindParam(8,$this->pde);
        $sentencia->bindParam(9,$id_direccion);
        $sentencia->bindParam(10,$this->id_religion);
        $sentencia->bindParam(11,$this->grado_educacional_madre);
        $sentencia->bindParam(12,$this->grado_educacional_padre);
        $sentencia->bindParam(13,$this->persona_vive);
        $result = $sentencia->execute();

        if(!$result){
            echo ERRORCITO.CLASE_ALUMNO."ALUMNO INGRESADO INCORRECTAMENTE EN BBDD";
            $sentencia = $myPDO->query("DELETE FROM direcciones WHERE id_direccion = ".$id_direccion."");
            return $result;
        }
        return $result;

    }

}

?> 