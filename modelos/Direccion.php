<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Direccion {
    private $id_direccion;
    private $calle;
    private $numero;
    private $depto;
    private $sector;
    private $id_comuna;
    private $estado = '1';

    public function set_calle($calle)
    {
        $this->calle = $calle;
    }
    public function get_calle()
    {
        return $this->calle;
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
    public function set_id_direccion($id_direccion)
    {
        $this->id_direccion = $id_direccion;
    }
    public function get_id_direccion()
    {
        return $this->id_direccion;
    }
    public function set_numero($numero)
    {
        $this->numero = $numero;
    }
    public function get_numero()
    {
        return $this->numero;
    }
    public function set_sector($sector)
    {
        $this->sector = $sector;
    }
    public function get_sector()
    {
        return $this->sector;
    }

    public function set_identidad($calle, $numero, $depto, $sector, $id_comuna){
        $this->calle = $calle;
        $this->depto = $depto;
        $this->id_comuna = $id_comuna;
        $this->numero = $numero;
        $this->sector = $sector;
    }

    //VALIDACIONES INICIO//
    public function validar_calle(){
        global $v;
        if(!$v->validar_texto($this->calle,3,60)){
            //echo ERRORCITO.CLASE_DIRECCION."DIRECCION CALLE VACIA O MUY LARGO <br/>";
            $this->calle = null;
            return false;
        }
        //echo INFO.CLASE_DIRECCION."DIRECCION CALLE INGRESADA CORRECTAMENTE <br/>";
        $this->calle =  mb_convert_case($this->calle, MB_CASE_TITLE, "UTF-8");
        return true;
    }
    public function validar_numero(){
        global $v;
        if(!$v->validar_formato_numero($this->numero,2,4)){
            //echo ERRORCITO.CLASE_DIRECCION." DIRECCION NUMERO NO ES NUMERO O ES MUY CORTO O MUY LARGO<br/>";
            $this->numero = null;
            return faLse;
        }
        //echo INFO.CLASE_DIRECCION." DIRECCION NUMERO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }
    public function validar_depto(){
        global $v;
        if(empty($this->depto)){
            //echo INFO.CLASE_DIRECCION."DIRECCION DEPTO INGRESADO CORRECTAMENTE<br/>";
            return true;
        }
        if(!$v->validar_formato_numero_texto($this->depto,3,5)){
            //echo ERRORCITO.CLASE_DIRECCION."DIRECCION DEPTO TIENE CARACTERES NO PERMITIDOS<br/>";
            $this->depto = NULL;
            return false;
        }
        //echo INFO.CLASE_DIRECCION."DIRECCION DEPTO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }
    public function validar_sector(){
        global $v;
        if(!$v->validar_texto($this->sector,3,60)){
            //echo ERRORCITO.CLASE_DIRECCION."DIRECCION SECTOR ES MUY CORTO O MUY LARGO<br/>";
            $this->sector = null;
            return false;
        }
        //echo INFO.CLASE_DIRECCION."DIRECCION SECTOR INGRESADO CORRECTAMENTE<br/>";
        $this->sector = mb_convert_case($this->sector, MB_CASE_TITLE, "UTF-8");
        return true;
    }
    public function validar_id_comuna(){
        global $v;
        if(!$v->validar_formato_numero($this->id_comuna,1,5)){
            //echo ERRORCITO.CLASE_DIRECCION."DIRECCION ID NO ES NUMERO<br/>";
            $this->id_comuna = null;
            return FALSE;
        }
        //echo INFO.CLASE_DIRECCION."DIRECCION ID COMUNA INGRESADO CORRECTAMENTE<br/>";
        return true;
    }
    public function validar(){
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
    //VALIDACIONES INICIO//

    public function db_get_datos(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_direccion(?)");
        $sentencia->bindParam(1, $this->id_direccion, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad(
                $row["calle"],
                $row["numero"],
                $row["depto"],
                $row["sector"],
                $row["id_comuna"]
            );
        }
        return $result;
    }
}
?> 