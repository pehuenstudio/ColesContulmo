<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
require_once ROOT_MODELOS."Direccion.php";
class Establecimiento {
    private $rbd_establecimiento;
    private $nombre;
    private $telefono;
    private $direccion;

    private $estado = 1;

    function __construct()
    {
    }
    //GETTERS Y SETTES

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function get_nombre()
    {
        return $this->nombre;
    }
    public function set_rbd_establecimiento($rbd_establecimiento)
    {
        $this->rbd_establecimiento = $rbd_establecimiento;
    }
    public function get_rbd_establecimiento()
    {
        return $this->rbd_establecimiento;
    }
    public function set_telefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function get_telefono()
    {
        return $this->telefono;
    }

    //agregar identidad
    public function set_identidad($rbd_establecimiento, $nombre, $telefono){
        $this->rbd_establecimiento = $rbd_establecimiento;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
    }

    //AGREGAR DIRECCION
    public function set_direccion(Direccion $direccion) {
        $this->direccion = $direccion;

    }

    //OBTENER DIRECCION
    public function get_direccion(){
        return $this->direccion;
    }

    //VALIDAR RBD
    public function validar_rbd_establecimiento(){
        global $v;
        if(!$v->validar_formato_numero($this->rbd_establecimiento,5,5)){
            //echo ERRORCITO.CLASE_ESTABLECIMIENTO." RBD ESTABLECIMIENTO INGRESADO INCORRECTAMENTE<br/>";
            $this->rbd_establecimiento = null;
            return false;
        }
        //echo INFO.CLASE_ESTABLECIMIENTO."RBD ESTABLECIMIENTO INGRESADO CORREECTAMENTE<br/>";
        return true;
    }

    //VALIDAR NOMBRE
    public  function validar_nombre(){
        global $v;
        if(!$v->validar_texto($this->nombre,3,45)){
            //echo ERRORCITO.CLASE_ESTABLECIMIENTO." NOMBRE INGRESADO INCORRECTAMENTE<br/>";
            $this->nombre = null;
            return false;
        }
        //echo ERRORCITO.CLASE_ESTABLECIMIENTO." NOMBRE INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR TELEFONO
    public function validar_telefono(){
        global $v;
        if(!$v->validar_formato_numero($this->telefono,9,9)){
            //echo ERRORCITO.CLASE_ESTABLECIMIENTO." TELEFONO INGRESADO ICORRECTAMENTE<br/>";
            $this->telefono = null;
            return false;
        }
        //echo INFO.CLASE_CLASE_ESTABLECIMIENTO." TELEFONO FIJO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

   //VALIDAR IDENTIDAD
    public function validar_identidad(){
        $result = true;
        if(!$this->validar_rbd_establecimiento()){
            $result = false;
        }
        if(!$this->validar_nombre()){
            $result = false;
        }
        if(!$this->validar_telefono()){
            $result = false;
        }
        return $result;
    }

    //VALIDAR DIRECCION
    public function validar_direccion(){
        if(isset($this->direccion)){
            if(!$this->direccion->validar()){
                return false;
            }
            return true;
        }
        return false;
    }


    public function db_get_datos(){

        global $myPDO;

        $sentencia = $myPDO->prepare("CALL get_establecimiento_datos(?);");
        $sentencia->bindParam(1, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        
        foreach($data as $row){
            $this->set_identidad(
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["telefono"]
            );
        }

        return $result;
    }





}
?> 