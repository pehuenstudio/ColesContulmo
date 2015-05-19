<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
//echo __FILE__."<br/>";
class Curso {
    private $id_curso;
    private $rbd_establecimiento;
    private $run_profesor_jefe;
    private $id_grado;
    private $nombre_grado;
    private $id_tipo_ensenanza;
    private $nombre_tipo_ensenanza;
    private $id_ciclo;
    private $grupo;
    private $estado = "1";

    function __construct(){

    }

    function set_identidad($rbd_establecimiento, $id_grado, $id_tipo_ensenanza, $grupo){
        $this->rbd_establecimiento = $rbd_establecimiento;
        $this->id_grado = $id_grado;
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
        $this->grupo = $grupo;
    }

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
    public function set_id_ciclo($id_ciclo)
    {
        $this->id_ciclo = $id_ciclo;
    }
    public function get_id_ciclo()
    {
        return $this->id_ciclo;
    }

    public function set_nombre_tipo_ensenanza($nombre_tipo_ensenanza)
    {
        $this->nombre_tipo_ensenanza = $nombre_tipo_ensenanza;
    }

    public function get_nombre_tipo_ensenanza()
    {
        return $this->nombre_tipo_ensenanza;
    }

    public function set_nombre_grado($nombre_grado)
    {
        $this->nombre_grado = $nombre_grado;
    }

    public function get_nombre_grado()
    {
        return $this->nombre_grado;
    }




    function validar_rbd_establecimiento(){
        global $v;
        if(!$v->validar_formato_numero($this->rbd_establecimiento,1,6)){
            ////echo ERRORCITO.CLASE_CURSO. "RBD ESTABLECIMIENTO INGRESADO INCORRECTAMENTE <br/>";
            $this->rbd_establecimiento = null;
            return false;
        }
        //echo INFO.CLASE_CURSO. "RBD ESTABLECIMIENTO INGRESADO CORRECTAMENTE <br/>";
        return true;
    }
    function validar_id_grado(){
        global $v;
        if(!$v->validar_formato_numero($this->id_grado,0,3)){
            ////echo ERRORCITO.CLASE_CURSO. "ID GRADO INGRESADO INCORRECTAMENTE <br/>";
            $this->id_grado = null;
            return false;
        }
        //echo INFO.CLASE_CURSO. "ID GRADO INGRESADO CORRECTAMENTE <br/>";
        return true;
    }
    function validar_id_tipo_ensenanza(){
        global $v;
        if(!$v->validar_formato_numero($this->id_tipo_ensenanza,0,5)){
            ////echo ERRORCITO.CLASE_CURSO. "ID TIPO DE ENSENANZA INGRESADO INCORRECTAMENTE <br/>";
            $this->id_tipo_ensenanza = null;
            return false;
        }
        //echo INFO.CLASE_CURSO. "ID TIPO DE ENSENANZA CORRECTAMENTE <br/>";
        return true;
    }
    function validar_grupo(){
        global $v;
        if(!$v->validar_texto($this->grupo,0,2)){
            ////echo ERRORCITO.CLASE_CURSO. "GRUPO INGRESADO INCORRECTAMENTE <br/>";
            $this->grupo = null;
            return false;
        }
        //echo INFO.CLASE_CURSO. "GRUPO ENSENANZA CORRECTAMENTE <br/>";
        return true;
    }

    public function validar(){
        $result = true;

        if(!$this->validar_rbd_establecimiento()){$result = false;}
        if(!$this->validar_id_grado()){$result = false;}
        if(!$this->validar_id_tipo_ensenanza()){$result = false;}
        if(!$this->validar_grupo()){$result = false;}

        return $result;
    }
//+++++++++++++++++++++++++++++++++++MANEJO DE BBDD+++++++++++++++++++++++++++++++++++++++++++

    public function db_get_curso_id(){

        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_curso_id(?,?,?,?,@id_curso)");
        $sentencia->bindParam(1, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->grupo, \PDO::PARAM_STR, 1);
        $sentencia->bindParam(4, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->execute();

        $sentencia = $myPDO->query("SELECT @id_curso;");
        $this->id_curso = $sentencia->fetchColumn(0);

        return $this->id_curso;
    }

    public function db_get_datos(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_curso(?)");
        $sentencia->bindParam(1, $this->id_curso, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll();


        foreach($data as $row){
            $this->set_id_curso($row["id_curso"]);
            $this->set_rbd_establecimiento($row["rbd_establecimiento"]);
            $this->set_run_profesor_jefe($row["run_profesor_jefe"]);
            $this->set_id_grado($row["id_grado"]);
            $this->set_id_tipo_ensenanza($row["id_tipo_ensenanza"]);
            $this->set_grupo($row["grupo"]);
            $this->set_id_ciclo($row["id_ciclo"]);
        }

        return $result;
    }

    public function db_get_all(){

    }
}
?> 