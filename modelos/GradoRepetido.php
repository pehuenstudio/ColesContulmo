<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
//echo __FILE__."<br/>";
class GradoRepetido {
    private $run_alumno;
    private $id_grado;
    private $id_tipo_ensenanza;
    private $cantidad;

    private $estado = "1";

    function __construct($run_alumno, $id_grado, $id_tipo_ensenanza, $cantidad){
        $this->run_alumno = $run_alumno;
        $this->id_grado = $id_grado;
        $this->id_tipo_ensenanza = $id_tipo_ensenanza;
        $this->cantidad = $cantidad;
    }

    public function set_cantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function get_cantidad()
    {
        return $this->cantidad;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
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
    public function set_run_alumno($run_alumno)
    {
        $this->run_alumno = $run_alumno;
    }
    public function get_run_alumno()
    {
        return $this->run_alumno;
    }

    public function validar(){
        global $v;
        if(!$v->validar_formato_numero($this->cantidad,1,2)){
            echo ERRORCITO.CLASE_GRADO_REPETIDO. "CANTIDAD INGRESADA INCORRECTAMENTE <br/>";
            $this->cantidad = null;
            return false;
        }
        echo INFO.CLASE_GRADO_REPETIDO. "CANTIDAD INGRESADA CORRECTAMENTE <br/>";
        return true;
    }



    // ++++++++++++++++++++++++++++++++++++++++++++++MANEJO DE BBDD++++++++++++++++++++++++++++++++++++++++++

    public function db_existencia(){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL get_grado_repetido(?,?,?)");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);

        $sentencia->execute();

        if($sentencia->rowCount()>=1){
            echo INFO.CLASE_GRADO_REPETIDO." DDBB FILA EXISTENTE <br/>";
           return true;
        }
        echo INFO.CLASE_GRADO_REPETIDO." DDBB FILA INEXISTENTE <br/>";
        return false;
    }

    public function db_actualizar(){
        global $myPDO;

        $sentencia = $myPDO->prepare("CALL upd_grados_repetidos(?,?,?,?)");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->cantidad, \PDO::PARAM_INT);

        if(!$sentencia->execute()){
            echo ERRORCITO.CLASE_GRADO_REPETIDO." DDBB ERROR EN ACTUALIZACION! <br/>";
            return false;
        }
        echo INFO.CLASE_GRADO_REPETIDO." DDBB EXITO EN ACTUALIZACION! <br/>";
        return true;
    }

    public function db_ingresar(){
        global $myPDO;

        $existencia = $this->db_existencia();

        if($existencia){
            $this->db_actualizar();
            return true;
        }

        $sentencia = $myPDO->prepare("CALL set_grados_repetidos(?,?,?,?)");
        $sentencia->bindParam(1, $this->run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $this->id_grado, \PDO::PARAM_INT);
        $sentencia->bindParam(3, $this->id_tipo_ensenanza, \PDO::PARAM_INT);
        $sentencia->bindParam(4, $this->cantidad, \PDO::PARAM_INT);

        if(!$sentencia->execute()){
            echo ERRORCITO.CLASE_GRADO_REPETIDO." DDBB ERROR EN INGRESO! <br/>";
            return false;
        }
        echo INFO.CLASE_GRADO_REPETIDO." DDBB EXITO EN INGRESO! <br/>";
        return true;


    }
}
?> 