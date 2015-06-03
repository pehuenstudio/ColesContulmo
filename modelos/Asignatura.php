<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Asignatura {
    private $id_asignatura;
    private $id_asignatura_tipo;
    private $rbd_establecimiento;
    private $nombre;
    private $color1 = "#C8C8C8";
    private $color2 = "#EFEFEF";
    private $descripcion = "Pendiente";
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
    public function set_id_asignatura($id_asignatura)
    {
        $this->id_asignatura = $id_asignatura;
    }
    public function get_id_asignatura()
    {
        return $this->id_asignatura;
    }
    public function set_id_asignatura_tipo($id_asignatura_tipo)
    {
        $this->id_asignatura_tipo = $id_asignatura_tipo;
    }
    public function get_id_asignatura_tipo()
    {
        return $this->id_asignatura_tipo;
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
    public function set_color1($color1)
    {
        $this->color1 = $color1;
    }
    public function get_color1()
    {
        return $this->color1;
    }
    public function set_color2($color2)
    {
        $this->color2 = $color2;
    }
    public function get_color2()
    {
        return $this->color2;
    }


    public function set_identidad($id_asignatura_tipo, $rbd_establecimiento, $nombre, $descripcion){
        $this->set_id_asignatura_tipo($id_asignatura_tipo);
        $this->set_rbd_establecimiento($rbd_establecimiento);
        $this->set_nombre($nombre);
        $this->set_descripcion($descripcion);
    }

    public function db_get_asignatura_by_id(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL  get_asignatura_by_id(?)");
        $sentencia->bindParam(1, $this->id_asignatura, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad(
                $row["id_asignatura_tipo"],
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["descripcion"]
            );
            $this->set_color1($row["color1"]);
            $this->set_color2($row["color2"]);
        }

        return $sentencia->rowCount();
    }

}
?> 