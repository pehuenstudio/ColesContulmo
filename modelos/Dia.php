<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Dia {
    private $id_dia;
    private $nombre;
    private $estado = "1";

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_dia($id_dia)
    {
        $this->id_dia = $id_dia;
    }
    public function get_id_dia()
    {
        return $this->id_dia;
    }
    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function get_nombre()
    {
        return $this->nombre;
    }

    public function set_identidad($nombre){
        $this->set_nombre($nombre);
    }

    public function db_get_dia_by_id(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_dia_by_id(?)");
        $sentencia->bindParam(1, $this->id_dia, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad($row["nombre"]);
        }

        $sentencia->rowCount();
    }
}
?> 