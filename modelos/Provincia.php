<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Provincia {
    private $id_provincia;
    private $id_region;
    private $nombre;
    private $prefijo_telefonico;
    private $estado = "1";

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_provincia($id_provincia)
    {
        $this->id_provincia = $id_provincia;
    }
    public function get_id_provincia()
    {
        return $this->id_provincia;
    }
    public function set_id_region($id_region)
    {
        $this->id_region = $id_region;
    }
    public function get_id_region()
    {
        return $this->id_region;
    }
    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function get_nombre()
    {
        return $this->nombre;
    }
    public function set_prefijo_telefonico($prefijo_telefonico)
    {
        $this->prefijo_telefonico = $prefijo_telefonico;
    }
    public function get_prefijo_telefonico()
    {
        return $this->prefijo_telefonico;
    }

    public function set_identidad($id_region, $nombre, $prefijo_telefonico){
        $this->set_id_region($id_region);
        $this->set_nombre($nombre);
        $this->set_prefijo_telefonico($prefijo_telefonico);
    }

    public function db_get_provincia_by_id(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_provincia_by_id(?)");
        $sentencia->bindParam(1, $this->id_provincia, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad(
                $row["id_region"],
                $row["nombre"],
                $row["prefijo_telefonico"]
            );
        }

        return $sentencia->rowCount();
    }
}
?> 