<?php
echo __FILE__."<br/>";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/config.php";
require_once ROOT_MODELOS_USUARIOS."Usuario.php";

class Apoderado extends Usuario{
    private $telefono_fijo;
    private $telefono_celular;

    private $direccion_calle;
    private $direccion_numero;
    private $direccion_depto;
    private $direccion_sector;
    private $direccion_id_comuna;

    //CONSTRUCTORES
    //MANEJO DE MÚLTIPLES CONSTRUCTORES
    function __construct(){
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    //CONSTRUCTOR VACÍO
    function __construct0(){
        parent::__construct0();

        $this->telefono_fijo       = NULL;
        $this->telefono_celular    = NULL;

        $this->direccion_calle     = NULL;
        $this->direccion_numero    = NULL;
        $this->direccion_depto     = NULL;
        $this->direccion_sector    = NULL;
        $this->direccion_id_comuna = NULL;
    }

    //CONSTRUCTOR CON IDENTIDAD COMPLETA
    function __construct12($run, $nombre1, $nombre2, $apellido1, $apellido2, $telefono_fijo, $telefono_celular, $direccion_calle, $direccion_numero, $direccion_depto, $direccion_sector, $direccion_id_comuna){
        parent::__construct5($run, $nombre1, $nombre2, $apellido1, $apellido2);

        $this->telefono_fijo       = $telefono_fijo;
        $this->telefono_celular    = $telefono_celular;

        $this->direccion_calle     = $direccion_calle ;
        $this->direccion_numero    = $direccion_numero;
        $this->direccion_depto     = $direccion_depto;
        $this->direccion_sector    = $direccion_sector;
        $this->direccion_id_comuna = $direccion_id_comuna;
    }

    //GETTERS Y SETTERS
    public function get_telefono_fijo(){
        return $this->telefono_fijo;
    }
    public function set_telefono_fijo($telefono_fijo){
        $this->telefono_fijo = $telefono_fijo;
    }
    public function get_telefono_celular(){
        return $this->telefono_celular;
    }
    public function set_telefono_celular($telefono_celular){
        $this->telefono_celular = $telefono_celular;
    }
    public function get_direccion_calle(){
        return $this->direccion_calle;
    }
    public function set_direccion_calle($direccion_calle){
        $this->direccion_calle = $direccion_calle;
    }
    public function get_direccion_numero(){
        return $this->direccion_numero;
    }
    public function set_direccion_numero($direccion_numero){
        $this->direccion_numero = $direccion_numero;
    }
    public function get_direccion_depto(){
        return $this->direccion_depto;
    }
    public function set_direccion_depto($direccion_depto){
        $this->direccion_depto = $direccion_depto;
    }
    public function get_direccion_sector(){
        return $this->direccion_sector;
    }
    public function set_direccion_sector($direccion_sector){
        $this->direccion_sector = $direccion_sector;
    }
    public function get_direccion_id_comuna(){
        return $this->direccion_id_comuna;
    }
    public function set_direccion_id_comuna($direccion_id_comuna){
        $this->direccion_id_comuna = $direccion_id_comuna;
    }


    public function validtar_telefono_fijo(){
        //SI SON NUMEROS Y SI SE ENVIO
        if(!preg_match("/^[0-9]{7,8}$/",$this->telefono_fijo)){
            echo ERRORCITO.CLASE_APODERADO."TELEFONO FIJO MUY CORTO O MUY LARGO<br/>";
            $this->telefono_fijo = NULL;
            return false;
        }
        echo INFO.CLASE_APODERADO."TELEFONO FIJO INGRESADO CORRECTAMENTE <br/>";
        return true;
    }//VALIDAR TELEFONO FIJO

    public function validar_telefono_celular(){
        //SI SON NUMEROS Y SI SE ENVIOS
        if(!preg_match("/^[0-9]{8}$/",$this->telefono_celular)){
            echo ERRORCITO.CLASE_APODERADO."TELEFO CELULAR MUY CORTO O MUY LARGO<br/>";
            $this->telefono_celular = NULL;
            return FALSE;
        }
        echo INFO.CLASE_APODERADO."TELEFONO CELULAR INGRESADO CORRECTAMENTE <br/>";
        return true;
    }//VALIDAR TELEFONO CELULAR

    public function validar_direccion_calle(){
        if(!preg_match("/^[0-9a-zA-ZñÑöÖáéíóúÁÉÍÓÚ\s]{1,40}$/",$this->direccion_calle)){
            echo ERRORCITO.CLASE_APODERADO."DIRECCION CALLE VACIA O MUY LARGO <br/>";
            $this->direccion_calle = NULL;
            return false;
        }
        echo INFO.CLASE_APODERADO."DIRECCION CALLE INGRESADA CORRECTAMENTE <br/>";
        return true;
    }//VALIDAR DIRECCION CALLE

    public function validar_direccion_numero(){
        if(!preg_match("/^[0-9]{1,5}$/",$this->direccion_numero)){
            echo ERRORCITO.CLASE_APODERADO."DIRECCION NUMERO VACIA O MUY LARGO <br/>";
            $this->direccion_numero = NULL;
            return false;
        }
        echo INFO.CLASE_APODERADO."DIRECCION NUMERO INGRESADA CORRECTAMENTE<br/>";
        return true;
    }//VALIDAR DIRECCION NUMERO

    public function validar_direccion_depto(){
        if(!is_null($this->direccion_depto)){
            if(!preg_match("/^[0-9a-zA-ZñÑöÖáéíóúÁÉÍÓÚ\]{1,10}$/",$this->direccion_depto)){
                echo ERRORCITO.CLASE_APODERADO."DIRECCION DEPTO TIENE CARACTERES NO PERMITIDOS<br/>";
                $this->direccion_depto = NULL;
                return false;
            }
        }
        echo INFO.CLASE_APODERADO."DIRECCION DEPTO INGRESADO CORRECTAMENTE<br/>";
        return true;
    } //VALIDAR DIRECCION DEPTO

    public function validar_direccion_sector(){
        if(!preg_match("/^[0-9a-zA-ZñÑöÖáéíóúÁÉÍÓÚ\s]{1,40}$/",$this->direccion_sector)){
            echo ERRORCITO.CLASE_APODERADO."DIRECCION SECTOR ES MUY CORTO O MUY LARGO<br/>";
            $this->direccion_sector = NULL;
            return false;
        }
        echo INFO.CLASE_APODERADO."DIRECCION SECTOR INGRESADO CORRECTAMENTE<br/>";
        return true;
    }//VALIDAR DIRECCION SECTOR

    public function  validar_direccion_id_comuna(){
        if(!preg_match("/^[0-9]+$/",$this->direccion_id_comuna)){
            echo ERRORCITO.CLASE_APODERADO."DIRECCION ID NO ES NUMERO";
            $this->direccion_id_comuna = NULL;
            return FALSE;
        }
        echo INFO.CLASE_APODERADO."DIRECCION ID COMUNA INGRESADO CORRECTAMENTE<br/>";
        return true;
    }//VALIDAR DIRECCION ID COMUNA


    //VALIDADOR MAESTRO
    public function validar(){
        $return = true;

        if(!$this->validar_identidad()){
            $return = false;
        }
        if(!$this->validtar_telefono_fijo()){
            $return = false;
        }
        if(!$this->validar_telefono_celular()){
            $return = false;
        }
        if(!$this->validar_direccion_calle()){
            $return = false;
        }
        if(!$this->validar_direccion_numero()){
            $return = false;
        }
        if(!$this->validar_direccion_depto()){
            $return = false;
        }
        if(!$this->validar_direccion_sector()){
            $return = false;
        }
        if(!$this->validar_direccion_id_comuna()){
            $return = false;
        }
        var_dump($this);
        return $return;

    }

}



?>