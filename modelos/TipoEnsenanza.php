<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
echo __FILE__."<br/>";

class TipoEnsenanza {
    private $id_tipo_ensenanza;
    private $nombre;
    private $estado = 1;


    function __construct()
    {
    }

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_tipo_ensenanza($id_tipo_ensenanza)
    {
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
    }
    public function get_id_tipo_ensenanza()
    {
        return $this->id_tipo_ensenanza;
    }
    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function get_nombre()
    {
        return $this->nombre;
    }

    //VALIDAR ID TIPO DE ENSEÑANZA
    public function validar_id_tipo_ensenanza(){
        global $v;
        if(!$v->validar_formato_numero($this->id_tipo_ensenanza,1,5)){
            echo ERRORCITO.CLASE_TIPOENSENANZA." TIPO DE ENSEÑANZA INGRESADO INCORRECTAMENTE <br/>";
            $this->id_tipo_ensenanza = null;
            return false;
        }
        echo INFO.CLASE_TIPOENSENANZA." TIPO DE ENSEÑANZA INGRESADA CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR NOMBRE
    public function validar_nombre(){
        global $v;
        if(!$v->validar_texto($this->nombre,3,45)){
            echo ERRORCITO.CLASE_TIPOENSENANZA." NOMBRE INGRESADO INCORRECTAMENTE<br/>";
            $this->nombre = null;
            return false;
        }
        echo INFO.CLASE_TIPOENSENANZA." NOMBRE INGRESA CORRECTAMENTE<br/>";
    }

    //VALIDADOR GENERAL
    public function validar(){
        $result = true;
        if(!$this->validar_id_tipo_ensenanza()){
            $result = false;
        }
        if(!$this->validar_nombre()){
            $result = false;
        }
        return $result;
    }





}
?> 