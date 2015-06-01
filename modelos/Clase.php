<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Clase {
    private $id_clase;
    private $run_profesor;
    private $id_curso;
    private $id_asignatura;
    private $id_bloque;
    private $rbd_establecimiento;
    private $periodo;
    private $estado = "1";

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_asignatura($id_asignatura)
    {
        $this->id_asignatura = $id_asignatura;
    }
    public function get_id_asignatura()
    {
        return $this->id_asignatura;
    }
    public function set_id_bloque($id_bloque)
    {
        $this->id_bloque = $id_bloque;
    }
    public function get_id_bloque()
    {
        return $this->id_bloque;
    }
    public function set_id_clase($id_clase)
    {
        $this->id_clase = $id_clase;
    }
    public function get_id_clase()
    {
        return $this->id_clase;
    }
    public function set_id_curso($id_curso)
    {
        $this->id_curso = $id_curso;
    }
    public function get_id_curso()
    {
        return $this->id_curso;
    }
    public function set_periodo($periodo)
    {
        $this->periodo = $periodo;
    }
    public function get_periodo()
    {
        return $this->periodo;
    }
    public function set_rbd_establecimiento($rbd_establecimiento)
    {
        $this->rbd_establecimiento = $rbd_establecimiento;
    }
    public function get_rbd_establecimiento()
    {
        return $this->rbd_establecimiento;
    }
    public function set_run_profesor($run_profesor)
    {
        $this->run_profesor = $run_profesor;
    }
    public function get_run_profesor()
    {
        return $this->run_profesor;
    }

    function set_identidad($id_curso, $id_asignatura, $id_bloque, $rbd_establecimiento){
        $this->id_asignatura = $id_asignatura;
        $this->id_bloque = $id_bloque;
        $this->id_curso = $id_curso;
        $this->rbd_establecimiento = $rbd_establecimiento;
    }

    function db_upd_clase_run_profesor_and_id_asignatura_by_id(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL upd_clase_run_profesor_and_id_asignatura_by_id(?,?,?)");
        $sentencia->bindParam(1, $this->id_clase, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(3, $this->id_asignatura, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        return $result;
    }
}
?> 