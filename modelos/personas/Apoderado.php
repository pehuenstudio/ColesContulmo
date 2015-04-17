<?php

namespace personas;

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/validaciones/Validacion.php";
require_once ROOT_MODELOS_PERSONAS."Persona.php";
echo __FILE__."<br/>";
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
        $this->telfono_fijo = $telefono_fijo;
    }
    public function get_telefono_fijo()
    {
        return $this->telefono_fijo;
    }

    public function set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $telefono_fijo,$telefono_celular){
        parent::set_identidad_nueva($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo);
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

}
/*
$a = new Apoderado();
$a->set_identidad("166890837", "RodÏrigo", "Alberto", "Sepúlveda", "Castro", "M",123456789,564994127);
$a->validar();
var_dump($a);*/
?> 