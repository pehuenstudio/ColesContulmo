<?php
namespace personas;
use validaciones\Validacion;

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/validaciones/Validacion.php";
echo __FILE__."<br/>";

class Persona {
    private $run;
    private $nombre1;
    private $nombre2;
    private $apellido1;
    private $apellido2;
    private $sexo;

    private $calle;
    private $numero;
    private $depto;
    private $sector;
    private $id_comuna;

    private $id_joomla;
    private $avatar;
    private $contrasena_movil;

    private $estado = "1";

    //GETTERS Y SETTERS
    public function set_apellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }
    public function get_apellido1()
    {
        return $this->apellido1;
    }
    public function set_apellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }
    public function get_apellido2()
    {
        return $this->apellido2;
    }
    public function set_avatar($avatar)
    {
        $this->avatar = $avatar;
    }
    public function get_avatar()
    {
        return $this->avatar;
    }
    public function set_calle($calle)
    {
        $this->calle = $calle;
    }
    public function get_calle()
    {
        return $this->calle;
    }
    public function set_contrasena_movil($contrasena_movil)
    {
        $this->contrasena_movil = $contrasena_movil;
    }
    public function get_contrasena_movil()
    {
        return $this->contrasena_movil;
    }
    public function set_depto($depto)
    {
        $this->depto = $depto;
    }
    public function get_depto()
    {
        return $this->depto;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_comuna($id_comuna)
    {
        $this->id_comuna = $id_comuna;
    }
    public function get_id_comuna()
    {
        return $this->id_comuna;
    }
    public function set_id_joomla($id_joomla)
    {
        $this->id_joomla = $id_joomla;
    }
    public function get_id_joomla()
    {
        return $this->id_joomla;
    }
    public function set_nombre1($nombre1)
    {
        $this->nombre1 = $nombre1;
    }
    public function get_nombre1()
    {
        return $this->nombre1;
    }
    public function set_nombre2($nombre2)
    {
        $this->nombre2 = $nombre2;
    }
    public function get_nombre2()
    {
        return $this->nombre2;
    }
    public function set_numero($numero)
    {
        $this->numero = $numero;
    }
    public function get_numero()
    {
        return $this->numero;
    }
    public function set_run($run)
    {
        $this->run = $run;
    }
    public function get_run()
    {
        return $this->run;
    }
    public function set_sector($sector)
    {
        $this->sector = $sector;
    }
    public function get_sector()
    {
        return $this->sector;
    }
    public function set_sexo($sexo)
    {
        $this->sexo = $sexo;
    }
    public function get_sexo()
    {
        return $this->sexo;
    }

    function __construct() {

    }

    //AGREGAR DATOS DE IDENTIDAD
    public function set_identidad_nueva($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo) {
        $this->run = $run;
        $this->nombre1 = $nombre1;
        $this->nombre2 = $nombre2;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->sexo = $sexo;
    }

    //AGREGAR DIRECCION
    public function set_direccion($calle, $numero, $depto, $sector, $id_comuna) {
        $this->calle = $calle;
        $this->numero = $numero;
        $this->depto = $depto;
        $this->sector = $sector;
        $this->id_comuna = $id_comuna;
    }

//++++++++++++++++++++++++++++++++++++++++VALIDACIONES+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VALIDAR RUN
    public function validar_run(){
        global $v;

        //VERIFICAR LONGITUD DEL NUMERO
        if(!$v->validar_formato_run($this->run)){
            echo ERRORCITO.CLASE_PERSONA."RUN DEMASIADO LARGO O DEMASIADO CORTO<br/>";
            $this->run = null;
            return false;
        }

        //VALIDAR DIGITO VERIFICADOR
        if(!$v->validar_digito_run($this->run)){
            echo ERRORCITO.CLASE_PERSONA. "RUN DIGITO VERIFICADOR NO COINCIDE CON NUMERO <br/>";
            $this->run = null;
            return false;
        }
        echo INFO.CLASE_PERSONA." RUN INGRESADO CORRECTAMENTE ".$this->get_run()."<br/>";
        return true;
    }

    //VALIDAR NOMBRE1
    function validar_nombre1(){
        global $v;
        if(!$v->validar_texto($this->nombre1,3,45)){
            echo ERRORCITO.CLASE_PERSONA."EL NOMBRE1 CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO<br/>";
            $this->nombre1 = null;
            return false;
        }
        echo INFO.CLASE_PERSONA."NOMBRE1 INGRESADO CORRECTAMENTE <br/>";
        $this->nombre1 = ucwords(strtolower($this->nombre1));
        return true;
    }

    //VALIDAR NOMBRE2
    function validar_nombre2(){
        global $v;
        if(!$v->validar_texto($this->nombre2,3,45)){
            echo ERRORCITO.CLASE_PERSONA."NOMBRE2 CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO<br/>";
            $this->nombre2 = null;
            return false;
        }
        echo INFO.CLASE_PERSONA."NOMBRE2 INGRESADO CORRECTAMENTE <br/>";
        $this->nombre2 = ucwords(strtolower($this->nombre2));
        return true;
    }

    //VALIDAR APELLIDO1
    function validar_apellido1(){
        global $v;
        if(!$v->validar_texto($this->apellido1,3,45)){
            echo ERRORCITO.CLASE_PERSONA."APELLIDO1 CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO<br/>";
            $this->apellido1 = null;
            return false;
        }
        echo INFO.CLASE_PERSONA."APELIIDO1 INGRESADO CORRECTAMENTE <br/>";
        $this->apellido1 = ucwords(strtolower($this->apellido1));
        return true;
    }

    //VALIDAR APELLIDO2
    function validar_apellido2(){
        global $v;
        if(!$v->validar_texto($this->apellido2,3,45)){
            echo ERRORCITO.CLASE_PERSONA."APELLIDO2 CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO<br/>";
            $this->apellido2 = null;
            return false;
        }
        echo INFO.CLASE_PERSONA."APELLIDO2 INGRESADO CORRECTAMENTE <br/>";
        $this->apellido2 = ucwords(strtolower($this->apellido2));
        return true;
    }

    //VALIDAR SEXO
    public function validar_sexo(){
        global $v;
        //$this->sexo = strtoupper($this->sexo);
        if(!$v->validar_formato_sexo($this->sexo)){
            echo ERRORCITO.CLASE_PERSONA." SEXO NO INGRESADO O NO ES VALIDO<br/>";
            $this->sexo = null;
            return false;
        }
        echo INFO.CLASE_PERSONA." SEXO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR CALLE
    public function validar_calle(){
        global $v;
        if(!$v->validar_texto($this->calle,5,60)){
            echo ERRORCITO.CLASE_PERSONA."DIRECCION CALLE VACIA O MUY LARGO <br/>";
            $this->direccion_calle = NULL;
            return false;
        }
        echo INFO.CLASE_PERSONA."DIRECCION CALLE INGRESADA CORRECTAMENTE <br/>";
        return true;
    }

    //VALIDAR NUMERO
    public function validar_numero(){
        global $v;
        if(!$v->validar_formato_numero($this->numero,2,4)){
            echo ERRORCITO.CLASE_PERSONA." DIRECCION NUMERO NO ES NUMERO O ES MUY CORTO O MUY LARGO<br/>";
            $this->numero = null;
            return faLse;
        }
        echo INFO.CLASE_PERSONA." DIRECCION NUMERO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR DEPTO
    public function validar_depto(){
        global $v;
        if(empty($this->depto)){
            echo INFO.CLASE_PERSONA."DIRECCION DEPTO INGRESADO CORRECTAMENTE<br/>";
            return true;
        }
        if(!$v->validar_formato_numero_texto($this->depto,2,5)){
            echo ERRORCITO.CLASE_PERSONA."DIRECCION DEPTO TIENE CARACTERES NO PERMITIDOS<br/>";
            $this->direccion_depto = NULL;
            return false;
        }
        echo INFO.CLASE_PERSONA."DIRECCION DEPTO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR SECTOR
    public function validar_sector(){
        global $v;
        if(!$v->validar_texto($this->sector,5,60)){
            echo ERRORCITO.CLASE_PERSONA."DIRECCION SECTOR ES MUY CORTO O MUY LARGO<br/>";
            $this->direccion_sector = NULL;
            return false;
        }
        echo INFO.CLASE_PERSONA."DIRECCION SECTOR INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR ID COMUNA
    public function validar_id_comuna(){
        global $v;
        if(!$v->validar_formato_numero($this->id_comuna,1,3)){
            echo ERRORCITO.CLASE_PERSONA."DIRECCION ID NO ES NUMERO<br/>";
            $this->id_comuna = null;
            return FALSE;
        }
        echo INFO.CLASE_PERSONA."DIRECCION ID COMUNA INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR CONTRASEÑA MOVIL
    public function validar_contrasena_movil(){
        global $v;
        if(!$v->validar_formato_numero_texto($this->contrasena_movil,6,10)){
            echo ERRORCITO.CLASE_PERSONA."CONTRASEÑA MOVIL ES MUY CORTA O MUY LAGRGA O NO CUMPLE REQUISITO<br/>";
            $this->contrasena_movil = NULL;
            return FALSE;
        }
        echo INFO.CLASE_PERSONA."CONTRASEÑA MOVIL INGREESADA CORECTAMENTE<br/>";
        return true;
    }

    //VALIDADOR IDENTIDAD
    public function validar_identidad(){
        $return = true;

        if(!$this->validar_run()){
            $return = false;
        }
        if(!$this->validar_nombre1()){
            $return = false;
        }
        if(!$this->validar_nombre2()){
            $return = false;
        }
        if(!$this->validar_apellido1()){
            $return = false;
        }
        if(!$this->validar_apellido2()){
            $return = false;
        }
        if(!$this->validar_sexo()){
            $return = false;
        }

        return $return;
    }

    //VALIDAR DIRECCION
    public function validar_direccion(){
        $result = true;

        if(!$this->validar_calle()){
            $result = false;
        }
        if(!$this->validar_numero()){
            $result = false;
        }
        if(!$this->validar_depto()){
            $result = true;
        }
        if(!$this->validar_sector()){
            $result = false;
        }
        if(!$this->validar_id_comuna()){
            $result = false;
        }
        return $result;
    }






}/*
$p = new Persona();
$p->set_identidad("166890837", "RodÏrigo", "Alberto", "Sepúlveda", "Castro", "M");
$p->set_direccion("Esmeralda", 12345, null, "Villa Rivas", 1);
$p->validar_identidad();
$p->validar_direccion();
$p->set_contrasena_movil("galatea198");
$p->validar_contrasena_movil();
var_dump($p);*/
?>