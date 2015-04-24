<?php

namespace personas;

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
require_once ROOT_MODELOS_PERSONAS."Persona.php";
echo __FILE__."<br/>";
class Alumno extends Persona {
    private $fecha_nacimiento;
    private $pde;
    private $grado_educacional_madre;
    private $grado_educacional_padre;
    private $persona_vive;


    //CONSTRUCTOR
    function __construct(){

    }



    //GETTER y SETTER
    public function set_fecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }
    public function get_fecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }
    public function set_grado_eduacional_madre($grado_eduacional_madre)
    {
        $this->grado_eduacional_madre = $grado_eduacional_madre;
    }
    public function get_grado_eduacional_madre()
    {
        return $this->grado_eduacional_madre;
    }
    public function set_grado_educacional_padre($grado_educacional_padre)
    {
        $this->grado_educacional_padre = $grado_educacional_padre;
    }
    public function get_grado_educacional_padre()
    {
        return $this->grado_educacional_padre;
    }
    public function set_pde($pde)
    {
        $this->pde = $pde;
    }
    public function get_pde()
    {
        return $this->pde;
    }
    public function set_persona_vive($persona_vive)
    {
        $this->persona_vive = $persona_vive;
    }
    public function get_persona_vive()
    {
        return $this->persona_vive;
    }




    public function set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $fecha_nacimiento, $pde, $persona_vive){
        parent::set_identidad_nueva($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo);
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->pde              = $pde;
        $this->persona_vive     = $persona_vive;
    }

    public function set_grado_educacional_padres($grado_educacional_madre,$grado_educacional_padre){
        $this->grado_educacional_madre = $grado_educacional_madre;
        $this->grado_educacional_padre = $grado_educacional_padre;
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
            echo INFO.CLASE_ALUMNO." PDE INGRESADO INCORECTAMENTE<br/>";
            $this->pde = null;
            return false;
        }
        echo INFO.CLASE_ALUMNO." PDE INGRESADO CORRECTAMENTE<br/>";
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
    public function validar_identidad(){
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


}
/*
$a = new Alumno();
$a->set_identidad("166890837", "Rodrigo", "Alberto", "Sepúlveda", "Castro", "M", "1988-12-10",0,"con toda la familia");
$a->set_grado_educacional_padres(1,2);
$a->set_direccion(new \Direccion("Esmeralda", 1234, null, "Villa Rivas", 1));
$a->validar_identidad();
$a->validar_direccion();
var_dump($a->to_jj());
//print_r( $a->to_jj());
//echo json_encode(print_r($a));
*/
?> 