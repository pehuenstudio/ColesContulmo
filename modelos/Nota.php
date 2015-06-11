<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Nota {
    private $id_nota;
    private $id_evaluacion;
    private $run_alumno;
    private $valor;
    private $fecha_creacion;
    private $estado = "1";

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_fecha_creacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }
    public function get_fecha_creacion()
    {
        return $this->fecha_creacion;
    }
    public function set_id_evaluacion($id_evaluacion)
    {
        $this->id_evaluacion = $id_evaluacion;
    }
    public function get_id_evaluacion()
    {
        return $this->id_evaluacion;
    }
    public function set_id_nota($id_nota)
    {
        $this->id_nota = $id_nota;
    }
    public function get_id_nota()
    {
        return $this->id_nota;
    }
    public function set_run_alumno($run_alumno)
    {
        $this->run_alumno = $run_alumno;
    }
    public function get_run_alumno()
    {
        return $this->run_alumno;
    }
    public function set_valor($valor)
    {
        $this->valor = $valor;
    }
    public function get_valor()
    {
        return $this->valor;
    }

    public function set_identidad($id_evaluacion, $run_alumno, $valor, $fecha_creacion){
        $this->set_id_evaluacion($id_evaluacion);
        $this->set_run_alumno($run_alumno);
        $this->set_valor($valor);
        $this->set_fecha_creacion($fecha_creacion);
    }

    public function db_ins_nota(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL ins_nota(?,?,?,?)");
        $sentencia->bindParam(1, $this->id_evaluacion, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(3, $this->valor, \PDO::PARAM_STR, 3);
        $sentencia->bindParam(4, $this->fecha_creacion, \PDO::PARAM_STR, 10);
        $result = $sentencia->execute();

        return $result;
    }

    public function db_upd_nota_by_id_evaluacion_and_run_alumno(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL upd_nota_by_id_evaluacion_and_run_alumno(?,?,?)");
        $sentencia->bindParam(1, $this->id_evaluacion, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(3, $this->valor, \PDO::PARAM_STR, 3);
        $result = $sentencia->execute();

        return $result;
    }

    public function db_del_nota_by_id_evaluacion_and_run_alumno(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL del_nota_by_id_evaluacion_and_run_alumno(?,?)");
        $sentencia->bindParam(1, $this->id_evaluacion, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->run_alumno, \PDO::PARAM_STR, 9);
        $result = $sentencia->execute();

        return $result;
    }
}
?> 