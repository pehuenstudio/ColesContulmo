<?php
echo "<br/>".dirname(__FILE__)."\\".basename(__FILE__)."<br/>";
require_once($_SERVER["DOCUMENT_ROOT"]."/modelos/Usuarios/Usuario.php");

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

    //VALIDAR TELEFONOS
    public function validar_telefonos(){
        $tf = $this->telefono_fijo;
        $tc = $this->telefono_celular;

        //SI SON NUMEROS Y SI SE ENVIO
        if(!preg_match("/^[0-9]{7,8}+$/",str_replace(' ', '', $tf))){
            $this->telefono_fijo = NULL;
            return FALSE;
        }
        if(!preg_match("/^[0-9]{8}+$/",str_replace(' ', '', $tc))){
            $this->telefono_celular = NULL;
            return FALSE;
        }
    }

    //VALIDAR DIRECCION
    public function validar_direccion(){
        $dc = $this->direccion_calle;
        $dn = $this->direccion_numero;
        $dd = $this->direccion_depto;
        $ds = $this->direccion_sector;
        $di = $this->direccion_id_comuna;

        if(!preg_match("/^[0-9a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]{1,40}$/",str_replace(' ', '', $dc))){
            $this->direccion_calle = NULL;
            return FALSE;
        }

        if(!preg_match("/^[0-9]+$/",str_replace(' ', '', $dn))){
            $this->direccion_numero = NULL;
            return FALSE;
        }

        if(!preg_match("/^[0-9a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]{1,10}$/",str_replace(' ', '', $dd))){
            $this->direccion_depto = NULL;
            return FALSE;
        }

        if(!preg_match("/^[0-9a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]{1,40}+$/",str_replace(' ', '', $ds))){
            $this->direccion_sector = NULL;
            return FALSE;
        }

        if(!preg_match("/^[0-9]+$/",str_replace(' ', '', $di))){
            $this->direccion_id_comuna = NULL;
            return FALSE;
        }
    }
}
$apoderadoVacio = new Apoderado();
$apoderadoParametrizado = new Apoderado("166890837","RODRIGO","AlBERTO","SEPULVEDA","CASTRO","123456","123456789","mi calle","123",NULL,"mi sector","1");
echo var_dump($apoderadoVacio);
echo var_dump($apoderadoParametrizado);
$apoderadoVacio->validar_run();
$apoderadoParametrizado->validar_run();
echo var_dump($apoderadoVacio);
echo var_dump($apoderadoParametrizado);
/*
$apoderadoVacio = new Apoderado();
$apoderadoParametrizado = new Apoderado("166890837","RODRIGO","AlBERTO","SEPULVEDA","CASTRO","123456","123456789","mi calle","123",NULL,"mi sector","1");
echo var_dump($apoderadoVacio);
echo var_dump($apoderadoParametrizado);
$apoderadoVacio->validar_run();
$apoderadoParametrizado->validar_run();
echo var_dump($apoderadoVacio);
echo var_dump($apoderadoParametrizado);
*/


?>