<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Persona.php";
//echo __FILE__."<br/>";
class Alumno extends Persona{
    private $fecha_nacimiento;
    private $pde;
    private $id_religion;
    private $grado_educacional_padre;
    private $grado_educacional_madre;
    private $persona_vive;

    private $estado = "1";

    public function set_fecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }
    public function get_fecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }
    public function set_grado_educacional_madre($grado_educacional_madre)
    {
        $this->grado_educacional_madre = $grado_educacional_madre;
    }
    public function get_grado_educacional_madre()
    {
        return $this->grado_educacional_madre;
    }
    public function set_grado_educacional_padre($grado_educacional_padre)
    {
        $this->grado_educacional_padre = $grado_educacional_padre;
    }
    public function get_grado_educacional_padre()
    {
        return $this->grado_educacional_padre;
    }
    public function set_id_religion($id_religion)
    {
        $this->id_religion = $id_religion;
    }
    public function get_id_religion()
    {
        return $this->id_religion;
    }
    public function set_pde($pde)
    {
        $this->pde = $pde;
    }
    public function get_pde()
    {
        return $this->pde;
    }
    public function set_persona_vive($persona_vive)
    {
        $this->persona_vive = $persona_vive;
    }
    public function get_persona_vive()
    {
        return $this->persona_vive;
    }

    public function validar_fecha_nacimiento(){
        global $v;
        if(!$v->validar_formato_fecha($this->fecha_nacimiento)){
            //echo ERRORCITO.CLASE_ALUMNO." FECHA CON FORMATO INCORRECTO<br/>";
            $this->fecha_nacimiento = null;
            return false;
        }
        $a = substr(str_replace("-","",$this->fecha_nacimiento),0,4);
        $m = substr(str_replace("-","",$this->fecha_nacimiento),4,2);
        $d = substr(str_replace("-","",$this->fecha_nacimiento),6,2);

        //VALIDAR AÑO
        if((date("Y")-(int)$a)<3){
            //echo ERRORCITO.CLASE_ALUMNO."FECHA CON AÑO DE NACIMIENTO ES MUY RECIENTE<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR MES
        if((int)$m<1 or (int)$m>12){
            //echo ERRORCITO.CLASE_ALUMNO."FECHA CON MES FUERA DE RANGO 1-12<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR DÍA
        if((int)$d<1 or (int)$d>cal_days_in_month(CAL_GREGORIAN, (int)$m, (int)$a)){
            //echo ERRORCITO.CLASE_ALUMNO."FECHA CON DIA QUE NO CORRESPONDE AL MES<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //echo INFO.CLASE_ALUMNO." FECHA INGRESADA CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR PDE
    public function validar_pde(){
        global $v;
        if(!$v->validar_formato_verdadero_falso($this->pde)){
            //echo ERRORCITO.CLASE_ALUMNO." PDE ".$this->pde." INGRESADO INCORECTAMENTE<br/>";
            $this->pde = null;
            return false;
        }
        //echo INFO.CLASE_ALUMNO." PDE ".$this->pde." INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR ID_RELIGION
    public function validar_id_religion(){
        global $v;
        $result = true;
        if(!$v->validar_formato_numero($this->id_religion,1,1)){
            //echo ERRORCITO.CLASE_ALUMNO." ID_RELIGION INGRESADO INCORRECTAMENTE<br/>";
            $this->id_religion = null;
            return false;
        }
        //echo INFO.CLASE_ALUMNO." ID_RELIGION INGRESADO CORRECTAMENTE<br/>";
        /*if($this->id_religion == "0"){
            $this->id_religion = null;
        }*/
        return true;
    }

    //VALIDAR GRADO EDUCACIONAL PADRE
    public function validar_grado_educacional_padre(){
        global $v;
        if(!$v->validar_grado_educacional($this->grado_educacional_padre)){
            //echo ERRORCITO.CLASE_ALUMNO." GEP INGRESADO INCORRECTAMENTE<br/>";
            $this->grado_educacional_padre = null;
            return false;
        }
        //echo INFO.CLASE_ALUMNO." GEP INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR GRADO EDUCACIONAL MADRW
    public function validar_grado_educacional_madre(){
        global $v;
        if(!$v->validar_grado_educacional($this->grado_educacional_madre)){
            //echo ERRORCITO.CLASE_ALUMNO." GEM INGRESADO INCORRECTAMENTE<br/>";
            $this->grado_educacional_madre = null;
            return false;
        }
        //echo INFO.CLASE_ALUMNO." GEM INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR PERSONA VIVE
    public function validar_persona_vive(){
        global $v;
        if(!$v->validar_formato_numero_texto($this->persona_vive,3,100)){
            //echo ERRORCITO.CLASE_ALUMNO." PERSONA VIVE ES MUY CORTO O MUY LARGO O0 CONTIENE CARACTERES NO ADMITIDOS<br/>";
            $this->persona_vive = null;
            return false;
        }
        //echo INFO.CLASE_ALUMNO." PERSONA VIVE INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //
    public function validar(){
        $result = true;

        if(!parent::validar_identidad()){
            $result = false;
        }
        if(!$this->validar_fecha_nacimiento()){
            $result = false;
        }
        if(!$this->validar_pde()){
            $result = false;
        }
        if(!$this->validar_id_religion()){
            $result = false;
        }
        if(!$this->validar_grado_educacional_padre()){
            $result = false;
        }
        if(!$this->validar_grado_educacional_madre()){
            $result = false;
        }

        if(!$this->validar_persona_vive()){
            $result = false;
        }

        return $result;
    }


    public function set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $email)
    {
        parent::set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $email); // TODO: Change the autogenerated stub

    }

    public function to_matriz()
    {
        $matriz = parent::to_matriz();
        $matriz["fecha_nacimiento"] = $this->get_fecha_nacimiento();
        $matriz["pde"] = $this->get_pde();
        $matriz["id_religion"] = $this->get_id_religion();
        $matriz["grado_educacional_padre"] = $this->get_grado_educacional_padre();
        $matriz["grado_educacional_madre"] = $this->get_grado_educacional_madre();
        $matriz["persona_vive"] = $this->get_persona_vive();

        return $matriz;
    }

    public function to_json(){
        $json = json_encode($this->to_matriz(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    public function db_con_alumno_by_run(){
        $run_alumno = $this->get_run();

        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_alumno_by_run(?)");
        $sentencia->bindParam(1, $run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        return $sentencia->rowCount();
    }

    public function db_get_alumno_by_run(){
        $run_alumno = $this->get_run();

        global $myPDO;
        $sentencia = $myPDO->prepare("CALL get_alumno_by_run(?)");
        $sentencia->bindParam(1, $run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->execute();

        $data = $sentencia->fetchAll(0);
        foreach($data as $row){
            $this->set_identidad(
                $row["run_alumno"],
                $row["nombre1"],
                $row["nombre2"],
                $row["apellido1"],
                $row["apellido2"],
                $row["sexo"],
                $row["email"]
            );
            $this->set_id_direccion($row["id_direccion"]);
            $this->set_avatar($row["avatar"]);
            $this->set_fecha_nacimiento($row["fecha_nacimiento"]);
            $this->set_pde($row["pde"]);
            $this->set_id_religion($row["id_religion"]);
            $this->set_grado_educacional_padre($row["grado_educacional_padre"]);
            $this->set_grado_educacional_madre($row["grado_educacional_padre"]);
            $this->set_persona_vive($row["persona_vive"]);
        }

        return $sentencia->rowCount();

    }

    public function db_upd_alumno_by_run(){
        $run_alumno = $this->get_run();
        $nombre1 = $this->get_nombre1();
        $nombre2 = $this->get_nombre2();
        $apellido1 = $this->get_apellido1();
        $apellido2 = $this->get_apellido2();
        $sexo = $this->get_sexo();
        $email = $this->get_email();
        $avatar = $this->get_avatar();

        global $myPDO;
        $sentencia = $myPDO->prepare("CALL upd_alumno_by_run(?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $sentencia->bindParam(1, $run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $nombre1, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(3, $nombre2, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(4, $apellido1, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(5, $apellido2, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(6, $sexo, \PDO::PARAM_STR, 1);
        $sentencia->bindParam(7, $this->fecha_nacimiento, \PDO::PARAM_STR, 10);
        $sentencia->bindParam(8, $this->pde, \PDO::PARAM_BOOL);
        $sentencia->bindParam(9, $this->id_religion, \PDO::PARAM_INT);
        $sentencia->bindParam(10, $this->grado_educacional_madre, \PDO::PARAM_INT);
        $sentencia->bindParam(11, $this->grado_educacional_padre, \PDO::PARAM_INT);
        $sentencia->bindParam(12, $this->persona_vive, \PDO::PARAM_STR, 100);
        $sentencia->bindParam(13, $email, \PDO::PARAM_STR, 100);
        $result = $sentencia->execute();

        return $result;
    }

    public function db_upd_alumno_avatar_by_run(){
        $run_alumno = $this->get_run();
        $avatar = $this->get_avatar();
        global $myPDO;
        $sentencia = $myPDO->prepare("CALL upd_alumno_avatar_by_run(?,?)");
        $sentencia->bindParam(1, $run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $avatar, \PDO::PARAM_STR, 100);
        $result = $sentencia->execute();

        return $result;
    }

    public function db_ins_alumno(){

        $run_alumno = $this->get_run();
        $nombre1 = $this->get_nombre1();
        $nombre2 = $this->get_nombre2();
        $apellido1 = $this->get_apellido1();
        $apellido2 = $this->get_apellido2();
        $sexo = $this->get_sexo();
        $email = $this->get_email();
        $id_direccion = $this->get_id_direccion();
        $avatar = $this->get_avatar();

        global $myPDO;
        $sentencia = $myPDO->prepare("CALL ins_alumno(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $sentencia->bindParam(1, $run_alumno, \PDO::PARAM_STR, 9);
        $sentencia->bindParam(2, $nombre1, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(3, $nombre2, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(4, $apellido1, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(5, $apellido2, \PDO::PARAM_STR, 45);
        $sentencia->bindParam(6, $sexo, \PDO::PARAM_STR, 1);
        $sentencia->bindParam(7, $this->fecha_nacimiento, \PDO::PARAM_STR, 10);
        $sentencia->bindParam(8, $this->pde, \PDO::PARAM_BOOL);
        $sentencia->bindParam(9, $id_direccion, \PDO::PARAM_INT);
        $sentencia->bindParam(10, $this->id_religion, \PDO::PARAM_INT);
        $sentencia->bindParam(11, $this->grado_educacional_madre, \PDO::PARAM_INT);
        $sentencia->bindParam(12, $this->grado_educacional_padre, \PDO::PARAM_INT);
        $sentencia->bindParam(13, $this->persona_vive, \PDO::PARAM_STR, 100);
        $sentencia->bindParam(14, $email, \PDO::PARAM_STR, 100);
        $result = $sentencia->execute();

        return $result;
    }



}
?> 