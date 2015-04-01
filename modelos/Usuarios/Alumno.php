<?php
echo "<br/>".dirname(__FILE__)."\\".basename(__FILE__)."<br/>";

require_once($_SERVER["DOCUMENT_ROOT"]."/modelos/Usuarios/Usuario.php");

class Alumno extends Usuario{
    private $fecha_nacimiento;
    private $nees;

    //CONSTRUCTORES
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

    //GETTERS Y SETTERS
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

    //VALIDAR FECHA NACIMIENTO
    public function validar_fecha_nacimiento(){
        $fn = $this->fecha_nacimiento;
        $a = substr($fn,0,4);
        $m = substr($fn,4,2);
        $d = substr($fn,6,2);


        //SI SOLO CONTIENE NUMEROS Y LA LONGITUD SUFICIENTE
        if(!preg_match("/^[[:digit:]]{8}+$/", $fn)){
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR AÑO
        if((date("Y")-(int)$a)<3){
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR MES
        if((int)$m<1 or (int)$m>12){
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        //VALIDAR DÍA
        if((int)$d<1 or (int)$d>cal_days_in_month(CAL_GREGORIAN, (int)$m, (int)$a)){
            $this->fecha_nacimiento = NULL;
            return FALSE;
        }

        return true;
    }

    //VALIDAR NEES
    function validar_nees(){
        $n = $this->nees;

        //SI SE ENVIO
        if(empty($n)){
            $this->nees = NULL;
            return false;
        }

        //SI ES 1|0
        if($n != "1" and $n != "0"){
            $this->nees = NULL;
            return false;
        }

        return true;
    }


}
/*
$alumnoVacio= new Alumno();
$alumnoParametrizado = new Alumno("00000000-0","RODRIGO","AlBERTO","SEPULVEDA","CASTRO","28051988",1);
echo var_dump($alumnoVacio);
echo var_dump($alumnoParametrizado);
$alumnoVacio->validar_run();
$alumnoParametrizado->validar_run();
echo var_dump($alumnoVacio);
echo var_dump($alumnoParametrizado);
*/
?>