<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Ciclo {
    private $id_ciclo;
    private $nombre;
    private $estado = '1';

    function __construct(){}

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_id_ciclo($id_ciclo)
    {
        $this->id_ciclo = $id_ciclo;
    }
    public function get_id_ciclo()
    {
        return $this->id_ciclo;
    }
    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function get_nombre()
    {
        return $this->nombre;
    }



}
?> 