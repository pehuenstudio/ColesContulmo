<?php
//require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
//require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Bloque {
    private $id_bloque;
    private $rbd_establecimiento;
    private $id_ciclo;
    private $id_dia;
    private $hora_inicio;
    private $hora_fin;
    private $estado = '1';

    function __construct(){}

    public function set_identidad($id_bloque, $rbd_establecimiento,  $id_ciclo, $id_dia, $hora_inicio, $hora_fin){
        $this->id_dia = $id_dia;
        $this->rbd_establecimiento = $rbd_establecimiento;
        $this->id_ciclo = $id_ciclo;
        $this->id_bloque = $id_bloque;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
    }

    public function set_id_dia($id_dia)
    {
        $this->id_dia = $id_dia;
    }
    public function get_id_dia()
    {
        return $this->id_dia;
    }
    public function set_id_ciclo($id_ciclo)
    {
        $this->id_ciclo = $id_ciclo;
    }
    public function get_id_ciclo()
    {
        return $this->id_ciclo;
    }
    public function set_id_bloque($id_bloque)
    {
        $this->id_bloque = $id_bloque;
    }
    public function get_id_bloque()
    {
        return $this->id_bloque;
    }
    public function set_hora_inicio($hora_inicio)
    {
        $this->hora_inicio = $hora_inicio;
    }
    public function get_hora_inicio()
    {
        return $this->hora_inicio;
    }
    public function set_hora_fin($hora_fin)
    {
        $this->hora_fin = $hora_fin;
    }
    public function get_hora_fin()
    {
        return $this->hora_fin;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_rbd_establecimiento($rbd_establecimiento)
    {
        $this->rbd_establecimiento = $rbd_establecimiento;
    }
    public function get_rbd_establecimiento()
    {
        return $this->rbd_establecimiento;
    }


}
?> 