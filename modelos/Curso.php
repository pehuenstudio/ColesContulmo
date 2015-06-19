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
    private $id_tipo_ensenanza;
    private $id_ciclo;
    private $grupo;
    private $periodo;
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
    public function set_periodo($periodo)
    {
        $this->periodo = $periodo;
    }
    public function get_periodo()
    {
        return $this->periodo;
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
    function validar_periodo(){
        global $v;
        if(!$v->validar_formato_numero($this->periodo,4,4)){
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
        if(!$this->validar_periodo()){$result = false;}

        return $result;
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

    public function db_get_curso_by_rbd_esta_and_id_tipo_ense_and_id_grado_and_grupo(){
        global $myPDO;
        print_r($this);
        $sentencia = $myPDO->prepare("CALL get_curso_by_rbd_esta_and_id_tipo_ense_and_id_grado_and_grupo(?,?,?,?)");
        $sentencia->bindParam(1, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->grupo, \PDO::PARAM_STR,1);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        //print_r($data);
        foreach($data as $row){
            $this->set_identidad(
                $row["rbd_establecimiento"],
                $row["run_profesor_jefe"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["id_ciclo"],
                $row["grupo"]
            );
            $this->set_id_curso($row["id_curso"]);
        }

        return $sentencia->rowCount();
    }

    public function db_get_curso_by_id(){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL get_curso_by_id(?)");
        $sentencia->bindParam(1, $this->id_curso, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        //print_r($data);
        foreach($data as $row){
            $this->set_identidad(
                $row["rbd_establecimiento"],
                $row["run_profesor_jefe"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["id_ciclo"],
                $row["grupo"]
            );

        }

        return $sentencia->rowCount();
    }

    public function db_ins_curso(){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL ins_curso(?,?,?,?,?,?)");
        $sentencia->bindParam(1, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->id_ciclo, \PDO::PARAM_INT);
        $sentencia->bindParam(5, $this->grupo, \PDO::PARAM_STR, 1);
        $sentencia->bindParam(6, $this->periodo, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        return $result;
    }

    public function db_get_curso_by_rbd_esta_and_id_grad_and_id_tip_and_grup_and_per(){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL get_curso_by_rbd_esta_and_id_grad_and_id_tip_and_grup_and_per(?,?,?,?,?)");
        $sentencia->bindParam(1, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->grupo, \PDO::PARAM_STR, 1);
        $sentencia->bindParam(5, $this->periodo, \PDO::PARAM_INT);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        //print_r($data);
        foreach($data as $row){
            $this->set_identidad(
                $row["rbd_establecimiento"],
                $row["run_profesor_jefe"],
                $row["id_grado"],
                $row["id_tipo_ensenanza"],
                $row["id_ciclo"],
                $row["grupo"]
            );

        }

        return $sentencia->rowCount();
    }


}
?> 