<?php
echo __FILE__."<br/>";

require_once ROOT_MODELOS_USUARIOS."Usuario.php";

class Profesor extends Usuario{


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
    }

    //CONSTRUCTOR CON IDENTIDAD COMPLETA
    function __construct7($run, $nombre1, $nombre2, $apellido1, $apellido2){
        parent::__construct5($run, $nombre1, $nombre2, $apellido1, $apellido2);

    }


    public function validar(){
        $return = true;

        if(!$this->validar_identidad()){
            $return = false;
        }

        return $return;
    }
}
?>