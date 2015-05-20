<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Comuna {
    private $id_comuna;
    private $id_provincia;
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
    public function set_id_comuna($id_comuna)
    {
        $this->id_comuna = $id_comuna;
    }
    public function get_id_comuna()
    {
        return $this->id_comuna;
    }
    public function set_id_provincia($id_provincia)
    {
        $this->id_provincia = $id_provincia;
    }
    public function get_id_provincia()
    {
        return $this->id_provincia;
    }
    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function get_nombre()
    {
        return $this->nombre;
    }

    public function set_identidad($id_provincia, $nombre){
        $this->set_id_provincia($id_provincia);
        $this->set_nombre($nombre);
    }

}
?> 