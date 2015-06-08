<?php

class Calendario {
    private $fecha;
    private $id_mes;
    private $id_dia;
    private $dia_mes;
    private $estado = "1";

    public function get_dia_mes()
    {
        return $this->dia_mes;
    }
    public function set_dia_mes($dia_mes)
    {
        $this->dia_mes = $dia_mes;
    }
    public function get_id_dia()
    {
        return $this->id_dia;
    }
    public function set_id_dia($id_dia)
    {
        $this->id_dia = $id_dia;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_fecha()
    {
        return $this->fecha;
    }
    public function set_fecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function get_id_mes()
    {
        return $this->id_mes;
    }
    public function set_id_mes($id_mes)
    {
        $this->id_mes = $id_mes;
    }

    public function set_identidad($fecha, $id_mes,  $id_dia, $dia_mes){
        $this->set_fecha($fecha);
        $this->set_id_mes($id_mes);
        $this->set_id_dia($id_dia);
        $this->set_dia_mes($dia_mes);
    }

}

?>