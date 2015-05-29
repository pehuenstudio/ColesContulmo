<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Establecimiento {
    private $rbd_establecimiento;
    private $nombre;
    private $telefono;
    private $id_direccion;
    private $estado = "1";

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_direccion($id_direccion)
    {
        $this->id_direccion = $id_direccion;
    }
    public function get_id_direccion()
    {
        return $this->id_direccion;
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

    public function set_identidad($rbd_establecimiento, $nombre, $telefono, $id_direccion){
        $this->set_rbd_establecimiento($rbd_establecimiento);
        $this->set_nombre($nombre);
        $this->set_telefono($telefono);
        $this->set_id_direccion($id_direccion);
    }

    public function db_get_establecimiento_by_rbd(){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL get_establecimiento_by_rbd(?)");
        $sentencia->bindParam(1, $this->rbd_establecimiento, PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad(
                $row["rbd_establecimiento"],
                $row["nombre"],
                $row["telefono"],
                $row["id_direccion"]
            );

        }
    }
}
?> 