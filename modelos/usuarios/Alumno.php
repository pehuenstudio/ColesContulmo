<?php
echo __FILE__."<br/>";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/connect.php";


class Alumno extends Usuario{
    private $fecha_nacimiento;
    private $nees;


    //MANEJO DE MÚLTIPLES CONSTRUCTORES
    function __construct(){
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    //CONSTRUCTOR VACÍO
    function __construct0(){
        parent::__construct0();

        $this->fecha_nacimiento = NULL;
        $this->nees             = NULL;
    }

    //CONSTRUCTOR CON IDENTIDAD COMPLETA
    function __construct7($run, $nombre1, $nombre2, $apellido1, $apellido2,$fecha_nacimiento,$nees){
        parent::__construct5($run, $nombre1, $nombre2, $apellido1, $apellido2);

        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->nees             = $nees;
    }
    //CONSTRUCTORES

    public function get_fecha_nacimiento(){
        return $this->fecha_nacimiento;
    }
    public function set_fecha_nacimiento($fecha_nacimiento){
        $this->fecha_nacimiento = $fecha_nacimiento;
    }
    public function get_nees(){
        return $this->nees;
    }
    public function set_nees($nees){
        $this->nees = $nees;
    }
    //GETTERS Y SETTERS

    //VALIDAR FECHA NACIMIENTO
    public function validar_fecha_nacimiento(){
        $a = substr($this->fecha_nacimiento,0,4);
        $m = substr($this->fecha_nacimiento,4,2);
        $d = substr($this->fecha_nacimiento,6,2);


        //SI SOLO CONTIENE NUMEROS Y LA LONGITUD SUFICIENTE
        if(!preg_match("/^[[:digit:]]{8}+$/", $this->fecha_nacimiento)){
            echo ERRORCITO.CLASE_ALUMNO."FECHA CONTIENE LETRAS<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR AÑO
        if((date("Y")-(int)$a)<3){
            echo ERRORCITO.CLASE_ALUMNO."FECHA CON AÑO DE NACIMIENTO ES MUY RECIENTE<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR MES
        if((int)$m<1 or (int)$m>12){
            echo ERRORCITO.CLASE_ALUMNO."FECHA CON MES FUERA DE RANGO 1-12<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR DÍA
        if((int)$d<1 or (int)$d>cal_days_in_month(CAL_GREGORIAN, (int)$m, (int)$a)){
            echo ERRORCITO.CLASE_ALUMNO."FECHA CON DIA QUE NO CORRESPONDE AL MES<br/>";
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }
        echo INFO.CLASE_ALUMNO."FECHA INGRESADA CORRECTAMENTE<br/>";
        $this->fecha_nacimiento = $a."-".$m."-".$d;
        return true;
    }

    //VALIDAR NEES
    function validar_nees(){
        $this->nees = str_replace(" ","",$this->nees);

        //SI SE ENVIO
        if(empty($this->nees)){
            echo ERRORCITO.CLASE_ALUMNO."NESS NO INGRESADO<br/>";
            $this->nees = NULL;
            return false;
        }

        //SI ES 1|0
        if($this->nees != "1" and $this->nees != "0"){
            echo ERRORCITO.CLASE_ALUMNO."NEES ES DISTINTO DE 0|1<br/>";
            $this->nees = NULL;
            return false;
        }
        echo INFO.CLASE_ALUMNO."NESS INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDADOR MAESTRO
    public function validar(){
        $return = true;

        if(!$this->validar_identidad()){
            $return = false;
        }
        if(!$this->validar_fecha_nacimiento()){
            $return = false;
        }
        if(!$this->validar_nees()){
            $return = false;
        }
        return $return;

    } //VALIDACIONES

    //MANEJO DE DATOS
    //VERIFICAR EXISTENCIA
    public function db_verificar_existencia(){
        echo INFO.CLASE_ALUMNO."VERIFICANDO EXISTENCIA DE RUN<br/>";
        global $myPDO;
        $comando = $myPDO->prepare("CALL alumnosExistencia(?)");
        $comando->bindValue(1,$this->get_run());
        $comando->execute();
        $result = $comando->fetch(PDO::FETCH_ASSOC);
        if($result["num_run"] == '1'){
            echo INFO.CLASE_ALUMNO."RUN EXISTE EN BBDD<br/>";
            return true;
        }
        echo INFO.CLASE_ALUMNO."RUN NO EXISTE EN BBDD<br/>";
        return false;
    }

    //INSERTAR ALUMNO
    public function db_ingresar(){
        echo INFO.CLASE_ALUMNO."INGRESANDO NUEVO USUARIO ".$this->get_run()."<br>";
        global $myPDO;
        $comando = $myPDO->prepare("CALL alumnosInsertar(?,?,?,?,?,?,?)");
        $comando->bindValue(1,$this->get_run());
        $comando->bindValue(2,$this->get_nombre1());
        $comando->bindValue(3,$this->get_nombre2());
        $comando->bindValue(4,$this->get_apellido1());
        $comando->bindValue(5,$this->get_apellido2());
        $comando->bindValue(6,$this->get_fecha_nacimiento());
        $comando->bindValue(7,$this->get_nees());
        $comando->execute();
        echo INFO.CLASE_ALUMNO."NUEVO USUARIO INGRESADO<br>";
    }

    //POBLAR PARAMETRO DE ALUMNO
    public function db_poblar(){
        echo INFO.CLASE_ALUMNO."BUSCANDO DATOS DE ".$this->get_run()."<br/>";
        global $myPDO;
        $alumno = array();
        $comando = $myPDO->prepare("CALL alumnosSeleccionar(?)");
        $comando->bindValue(1,$this->get_run());
        $comando->execute();
        $alumno = $comando->fetch(PDO::FETCH_ASSOC);
        echo INFO.CLASE_ALUMNO."POBLANDO DATOS DE USUARIO<br>";
        $this->set_id_usuario_movil($alumno["id_usuario_movil"]);
        $this->set_id_joomla($alumno["id_joomla"]);
        $this->set_nombre1($alumno["nombre1"]);
        $this->set_nombre2($alumno["nombre2"]);
        $this->set_apellido1($alumno["apellido1"]);
        $this->set_apellido2($alumno["apellido2"]);
        $this->set_fecha_nacimiento($alumno["fecha_nacimiento"]);
        $this->set_nees($alumno["nees"]);
        echo INFO.CLASE_ALUMNO."USUARIO POBLADO EXITOSAMENTE<br>";
        var_dump($this);
    }




}

?>