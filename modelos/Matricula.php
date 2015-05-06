<?php



use personas\Alumno;

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
require_once ROOT_MODELOS_PERSONAS."Persona.php";
require_once ROOT_MODELOS_PERSONAS."Alumno.php";
require_once ROOT_MODELOS_PERSONAS."Apoderado.php";
//echo __FILE__."<br/>";

class Matricula {
    private $id_matricula;
    private $id_tipo_ensenanza;
    private $periodo;
    private $run_alumno;
    private $rbd_establecimiento;
    private $run_apoderado;
    private $id_curso;
    private $establecimiento_procedencia;
    private $fecha_incorporacion;
    private $fecha_retiro;
    private $causa_retiro;
    private $fecha_egreso;
    private $estado = 1;

    //CONSTRUCTOR
    function __construct(){}

    public function set_identidad($id_tipo_ensenanza, $periodo, $run_alumno, $rbd_establecimiento, $run_apoderado, $id_curso,
                         $establecimiento_procedencia, $fecha_incorporacion)
    {
        $this->run_apoderado = $run_apoderado;
        $this->id_curso = $id_curso;
        $this->run_alumno = $run_alumno;
        $this->rbd_establecimiento = $rbd_establecimiento;
        $this->periodo = $periodo;
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
        $this->fecha_incorporacion = $fecha_incorporacion;
        $this->establecimiento_procedencia = $establecimiento_procedencia;

    }




    //GETTERS Y SETTERS
    public function get_causa_retiro()
    {
        return $this->causa_retiro;
    }
    public function set_causa_retiro($causa_retiro)
    {
        $this->causa_retiro = $causa_retiro;
    }
    public function get_establecimiento_procedencia()
    {
        return $this->establecimiento_procedencia;
    }
    public function set_establecimiento_procedencia($establecimiento_procedencia)
    {
        $this->establecimiento_procedencia = $establecimiento_procedencia;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_fecha_egreso()
    {
        return $this->fecha_egreso;
    }
    public function set_fecha_egreso($fecha_egreso)
    {
        $this->fecha_egreso = $fecha_egreso;
    }
    public function get_fecha_incorporacion()
    {
        return $this->fecha_incorporacion;
    }
    public function set_fecha_incorporacion($fecha_incorporacion)
    {
        $this->fecha_incorporacion = $fecha_incorporacion;
    }
    public function get_fecha_retiro()
    {
        return $this->fecha_retiro;
    }
    public function set_fecha_retiro($fecha_retiro)
    {
        $this->fecha_retiro = $fecha_retiro;
    }
    public function get_id_curso()
    {
        return $this->id_curso;
    }
    public function set_id_curso($id_curso)
    {
        $this->id_curso = $id_curso;
    }
    public function get_id_matricula()
    {
        return $this->id_matricula;
    }
    public function set_id_matricula($id_matricula)
    {
        $this->id_matricula = $id_matricula;
    }
    public function get_id_tipo_ensenanza()
    {
        return $this->id_tipo_ensenanza;
    }
    public function set_id_tipo_ensenanza($id_tipo_ensenanza)
    {
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
    }
    public function get_periodo()
    {
        return $this->periodo;
    }
    public function set_periodo($periodo)
    {
        $this->periodo = $periodo;
    }
    public function get_rbd_establecimiento()
    {
        return $this->rbd_establecimiento;
    }
    public function set_rbd_establecimiento($rbd_establecimiento)
    {
        $this->rbd_establecimiento = $rbd_establecimiento;
    }
    public function get_run_alumno()
    {
        return $this->run_alumno;
    }
    public function set_run_alumno($run_alumno)
    {
        $this->run_alumno = $run_alumno;
    }
    public function get_run_apoderado()
    {
        return $this->run_apoderado;
    }
    public function set_run_apoderado($run_apoderado)
    {
        $this->run_apoderado = $run_apoderado;
    }

    //VALIDAR PERIODO

    public function validar_periodo(){
        global $v;
        if(!$v->validar_formato_numero($this->periodo,4,4)){
            //echo ERRORCITO.CLASE_MATRICULA." PERIODO INGRESADO INCORRECTAMENTE<br/>";
            $this->periodo = null;
            return false;
        }
        //echo INFO.CLASE_MATRICULA." PERIODO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR ESTABLECIMEINTO PROCEDENCIA
    public function validar_establecimiento_porcedencia(){
        global $v;
        if(!$v->validar_formato_numero_texto($this->establecimiento_procedencia,3,60)){
            //echo ERRORCITO.CLASE_MATRICULA." ESTABLECIMIENTO PROCEDENCIA INGRESADO INCORRECTAMENTE<br/>";
            $this->establecimiento_procedencia = null;
            return false;
        }
        //echo INFO.CLASE_MATRICULA." ESTABLECIMIENTO PROCEDENCIA INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR FECHA INCORPORACION
    public function validar_fecha_incorporacion(){
        global $v;
        if(!$v->validar_formato_fecha($this->fecha_incorporacion)){
            //echo ERRORCITO.CLASE_MATRICULA."<FECHA DE INCORPORACION INGRESADFA INCORRECTAMERNTEbr/>";
            $this->fecha_incorporacion = null;
            return false;
        }
        //echo INFO.CLASE_MATRICULA."FECHA DE INCORPORACION INGRESADA CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR FECHA DE RETIRO
    public function validar_fecha_retiro(){
        global $v;
        if(!empty($this->causa_retiro)){
            if(!$v->validar_formato_fecha($this->fecha_retiro)){
                //echo ERRORCITO.CLASE_MATRICULA."FECHA DE RETIRO INGRESADA ICORRECTAMENTE<br/>";
                $this->fecha_retiro = false;
                return false;
            }
            //echo INFO.CLASE_MATRICULA."FECHA DE RETIRO INGRESADA CORRECTAMENTE <br/>";
            return true;
        }
        //echo INFO.CLASE_MATRICULA."FECHA DE RETIRO INGRESADA CORRECTAMENTE <br/>";
        return true;
    }

    //validar causa retiro
    public function validar_causa_retiro(){
        global $v;
        if(!$v->validar_formato_numero_texto($this->causa_retiro,0,100)){
            //echo ERRORCITO.CLASE_MATRICULA."CUASA DE RETIRO INGRESADA INCORRECTAMENTE<br/>";
            $this->causa_retiro = null;
            return false;
        }
        //echo INFO.CLASE_MATRICULA."CAUSA DE RETIRO INGRESADA CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR FECHA DE EGRESO
    public function  validar_fecha_egreso(){
        global $v;
        if(!empty($this->fecha_egreso)){
            if(!$v->validar_formato_fecha($this->fecha_egreso)){
                //echo ERRORCITO.CLASE_MATRICULA."FECHA DE EGRESO INGRESA INCORECTAMENTE<br/>";
                $this->fecha_egreso = null;
                return true;
            }
            //echo INFO.CLASE_MATRICULA." FECHA DE EGRESO INGRESADA CORRECTAMENTE <br/>";
            return true;
        }
        //echo INFO.CLASE_MATRICULA." FECHA DE EGRESO INGRESADA CORRECTAMENTE <br/>";
        return true;
    }

    //VALIDADOR MAESTRO
    public function  validar(){
        $result = true;
        if(!$this->validar_periodo()){
            $result = false;
        }
        if(!$this->validar_establecimiento_porcedencia()){
            $result = false;
        }
        if(!$this->validar_fecha_incorporacion()){
            $result = false;
        }
        if(!$this->validar_fecha_retiro()){

            $result = false;
        }
        if(!$this->validar_causa_retiro()){
            $result = false;
        }
        if(!$this->validar_fecha_egreso()){
            $result = false;
        }
        return $result;
    }

    //+++++++++++++++++++++++++++++++++++++++++++MANEJO DE BBDD++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function db_existencia(){
        global $myPDO;
        $sentencia = $myPDO->prepare("SELECT id_matricula FROM matriculas WHERE run_alumno = ? AND periodo = ?");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR,9);
        $sentencia->bindParam(2, $this->periodo, \PDO::PARAM_INT);
        $sentencia->execute();

        if($sentencia->rowCount() >= 1){
            //echo ERRORCITO.CLASE_MATRICULA."ESTE ALUMNO YA REGISTRA MATRICULA PARA ESTE PERIODO<br/>";
            return true;
        }

        return false;
    }

    public function db_ingresar(){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL set_matricula(?,?,?,?,?,?,?,?,@id_matricula)");
        $sentencia->bindParam(1, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(2, $this->periodo, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(4, $this->rbd_establecimiento, \PDO::PARAM_INT);
        $sentencia->bindParam(5, $this->run_apoderado, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(6, $this->id_curso, \PDO::PARAM_INT);
        $sentencia->bindParam(7, $this->establecimiento_procedencia, \PDO::PARAM_STR, 60);
        $sentencia->bindParam(8, $this->fecha_incorporacion, \PDO::PARAM_STR, 10);

        $result = $sentencia->execute();

        $sentencia = $myPDO->query("SELECT @id_matricula;");
        //var_dump($sentencia->fetchColumn(0));
        $this->id_matricula = $sentencia->fetchColumn(0);

        return $result;
    }

    public function db_get_datos(){
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_matricula(?,?)");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $this->periodo, \PDO::PARAM_INT);
        $result = $sentencia->execute();

        $data = $sentencia->fetchAll();
        foreach($data as $row){
            $this->set_id_matricula($row["id_matricula"]);
            $this->set_identidad(
                $row["id_tipo_ensenanza"],
                $row["periodo"],
                $row["run_alumno"],
                $row["rbd_establecimiento"],
                $row["run_apoderado"],
                $row["id_curso"],
                $row["establecimiento_procedencia"],
                $row["fecha_incorporacion"]
            );
        }

        return $result;
    }

}
?> 