<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Curso {
    private $id_curso;
    private $rbd_establecimiento;
    private $run_profesor_jefe;
    private $id_grado;
    private $id_tipo_ensenanza;
    private $id_ciclo;
    private $grupo;
    private $estado = "1";

    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_grupo($grupo)
    {
        $this->grupo = $grupo;
    }
    public function get_grupo()
    {
        return $this->grupo;
    }
    public function set_id_ciclo($id_ciclo)
    {
        $this->id_ciclo = $id_ciclo;
    }
    public function get_id_ciclo()
    {
        return $this->id_ciclo;
    }
    public function set_id_curso($id_curso)
    {
        $this->id_curso = $id_curso;
    }
    public function get_id_curso()
    {
        return $this->id_curso;
    }
    public function set_id_grado($id_grado)
    {
        $this->id_grado = $id_grado;
    }
    public function get_id_grado()
    {
        return $this->id_grado;
    }
    public function set_id_tipo_ensenanza($id_tipo_ensenanza)
    {
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
    }
    public function get_id_tipo_ensenanza()
    {
        return $this->id_tipo_ensenanza;
    }
    public function set_rbd_establecimiento($rbd_establecimiento)
    {
        $this->rbd_establecimiento = $rbd_establecimiento;
    }
    public function get_rbd_establecimiento()
    {
        return $this->rbd_establecimiento;
    }
    public function set_run_profesor_jefe($run_profesor_jefe)
    {
        $this->run_profesor_jefe = $run_profesor_jefe;
    }
    public function get_run_profesor_jefe()
    {
        return $this->run_profesor_jefe;
    }

    public function set_identidad($rbd_establecimiento, $run_profesor_jefe, $id_grado,
                                  $id_tipo_ensenanza, $id_ciclo, $grupo){

        $this->rbd_establecimiento = $rbd_establecimiento;
        $this->run_profesor_jefe = $run_profesor_jefe;
        $this->id_grado = $id_grado;
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
        $this->id_ciclo = $id_ciclo;
        $this->grupo = $grupo;
    }




}
?> 