<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Evaluacion {
    private $id_evaluacion;
    private $id_clase;
    private $fecha;
    private $run_profesor;
    private $descripcion;
    private $estado = "1";

    public function set_descripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function get_descripcion()
    {
        return $this->descripcion;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_clase($id_clase)
    {
        $this->id_clase = $id_clase;
    }
    public function get_id_clase()
    {
        return $this->id_clase;
    }
    public function set_id_evaluacion($id_evaluacion)
    {
        $this->id_evaluacion = $id_evaluacion;
    }
    public function get_id_evaluacion()
    {
        return $this->id_evaluacion;
    }
    public function set_run_profesor($run_profesor)
    {
        $this->run_profesor = $run_profesor;
    }
    public function get_run_profesor()
    {
        return $this->run_profesor;
    }
    public function set_fecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function get_fecha()
    {
        return $this->fecha;
    }


    public function set_identidad($id_clase, $run_profesor, $fecha, $descripcion){
        $this->set_id_clase($id_clase);
        $this->set_run_profesor($run_profesor);
        $this->set_fecha($fecha);
        $this->set_descripcion($descripcion);
    }

    public function db_get_evaluacion_by_id_clase_and_fecha(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_evaluacion_by_id_clase_and_fecha(?,?)");
        $sentencia->bindParam(1, $this->id_clase, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->fecha,\PDO::PARAM_STR, 10);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_id_evaluacion($row["id_evaluacion"]);
            $this->set_identidad(
                $row["id_clase"],
                $row["run_profesor"],
                $row["fecha"],
                $row["descripcion"]
            );
        }

        return $sentencia->rowCount();
    }

    public function db_ins_evaluacion(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL ins_evaluacion(?,?,?,?)");
        $sentencia->bindParam(1, $this->id_clase, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->fecha, \PDO::PARAM_STR, 10);
        $sentencia->bindParam(3, $this->run_profesor, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(4, $this->descripcion, \PDO::PARAM_STR, 200);
        $result = $sentencia->execute();

        return $result;
    }



}
?> 