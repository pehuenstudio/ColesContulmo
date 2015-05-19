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
    private $estado = '1';

    function __construct(){}

    function set_identidad($id_curso, $id_asignatura, $id_bloque, $rbd_establecimiento){
        $this->id_asignatura = $id_asignatura;
        $this->id_bloque = $id_bloque;
        $this->id_curso = $id_curso;
        $this->rbd_establecimiento = $rbd_establecimiento;

    }



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
    public function set_periodo($periodo)
    {
        $this->periodo = $periodo;
    }
    public function get_periodo()
    {
        return $this->periodo;
    }



    public function db_actualizar_clase(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL upd_clase(?,?,?,?,?,?)");
        $sentencia->bindParam(1, $this->id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->id_asignatura, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->run_profesor, \PDO::PARAM_STR. 9);
        $sentencia->bindParam(4, $this->id_bloque, \PDO::PARAM_INT);
        $sentencia->bindParam(5, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(6, $this->id_clase, \PDO::PARAM_INT);
        $result = $sentencia->execute();
        //echo("call upd_clase(".$this->id_curso.",'".$this->id_asignatura."',".$this->id_bloque.",".$this->rbd_establecimiento.",'".$estado."');\n");
        return $result;
    }

    public function db_actualizar_clase_null(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL upd_clase_null(?,?,?,?)");
        $sentencia->bindParam(1, $this->id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->id_bloque, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->id_clase, \PDO::PARAM_INT);
             $result = $sentencia->execute();
        //echo("call upd_clase(".$this->id_curso.",'".$this->id_asignatura."',".$this->id_bloque.",".$this->rbd_establecimiento.",'".$estado."');\n");
        return $result;
    }




}
?> 