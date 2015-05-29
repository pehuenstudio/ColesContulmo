<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/validacion.php";
//echo __FILE__."<br/>";
class GradoRepetido {
    private $run_alumno;
    private $id_grado;
    private $id_tipo_ensenanza;
    private $cantidad;
    private $estado = "1";

    public function set_cantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function get_cantidad()
    {
        return $this->cantidad;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_grado($id_grado)
    {
        $this->id_grado = $id_grado;
    }
    public function get_id_grado()
    {
        return $this->id_grado;
    }
    public function set_id_tipo_ensenanza($id_tipo_ensenanza)
    {
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
    }
    public function get_id_tipo_ensenanza()
    {
        return $this->id_tipo_ensenanza;
    }
    public function set_run_alumno($run_alumno)
    {
        $this->run_alumno = $run_alumno;
    }
    public function get_run_alumno()
    {
        return $this->run_alumno;
    }

    public function validar(){
        global $v;
        if(!$v->validar_formato_numero($this->cantidad,1,2)){
            echo ERRORCITO.CLASE_GRADO_REPETIDO. "CANTIDAD INGRESADA INCORRECTAMENTE ".$this->cantidad."<br/>";
            $this->cantidad = null;
            return false;
        }
        //echo INFO.CLASE_GRADO_REPETIDO. "CANTIDAD INGRESADA CORRECTAMENTE <br/>";
        return true;
    }

    public function set_identidad($run_alumno, $id_grado, $id_tipo_ensenanza, $cantidad){
        $this->set_run_alumno($run_alumno);
        $this->set_id_grado($id_grado);
        $this->set_id_tipo_ensenanza($id_tipo_ensenanza);
        $this->set_cantidad($cantidad);
    }

    public function db_get_grado_repetido_by_run_and_id_grado_and_id_tipo_ensenanza(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_grado_repetido_by_run_and_id_grado_and_id_tipo_ensenanza(?,?,?)");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->execute();

        return $sentencia->rowCount();
    }

    public function db_upd_grado_repetido_by_run_and_id_grado_and_id_tipo_ensenanza(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL upd_grado_repetido_by_run_and_id_grado_and_id_tipo_ensenanza(?,?,?,?)");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->cantidad, \PDO::PARAM_INT);
        $sentencia->execute();

        return $sentencia->rowCount();
    }

    public function db_ins_grado_repetido(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL ins_grado_repetido(?,?,?,?)");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->cantidad, \PDO::PARAM_INT);
        $sentencia->execute();

        return $sentencia->rowCount();
    }


}
?> 