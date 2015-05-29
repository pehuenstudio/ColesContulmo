<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/validar.php";

//echo __FILE__."<br/>";
class Ciclo {
    private $id_ciclo;
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

    public function set_identidad($nombre){
        $this->set_nombre($nombre);
    }

    public function validar_is_ciclo(){
        global $v;
        if(!$v->validar_formato_numero($this->get_id_ciclo(),1,2)){
            $this->set_id_ciclo(null);
            return false;
        }
        return true;
    }

    public function validar_nombre(){
        global $v;
        if(!$v->validar_texto($this->get_nombre(),3,90)){
            $this->set_nombre(null);
            return false;
        }
        return true;

    }

}
?> 