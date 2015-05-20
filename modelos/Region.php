<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Region {
    private $id_region;
    private $letra_romana;
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
    public function set_id_region($id_region)
    {
        $this->id_region = $id_region;
    }
    public function get_id_region()
    {
        return $this->id_region;
    }
    public function set_letra_romana($letra_romana)
    {
        $this->letra_romana = $letra_romana;
    }
    public function get_letra_romana()
    {
        return $this->letra_romana;
    }
    public function set_nombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function get_nombre()
    {
        return $this->nombre;
    }

    public function set_identidad($letra_romana, $nombre){
        $this->set_letra_romana($letra_romana);
        $this->set_nombre($nombre);
    }


}
?> 