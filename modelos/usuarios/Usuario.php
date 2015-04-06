<?php
echo __FILE__."<br/>";
header('Content-Type: text/html; charset=UTF-8'); 

class Usuario{
	private $run;
	private $id_joomla;
	private $id_usuario_movil;
	private $nombre1;
	private $nombre2;
	private $apellido1;
	private $apellido2;
	private $estado;

	//CONSTRUCTORES 
	//MANEJO DE MÚLTIPLES CONSTRUCTORES
	public function __construct(){ 
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    } 
	
	//CONSTRUCTOR VACÍO 
	public function __construct0(){
		
		$this->run              = NULL;
		$this->id_joomla        = NULL;
		$this->id_usuario_movil = NULL;
		$this->nombre1          = NULL;
		$this->nombre2          = NULL;
		$this->apellido1        = NULL;
		$this->apellido2        = NULL;
		$this->estado           = "1";
	}
	
	//CONSTRUCTOR CON IDENTIDAD COMPLETA
	function __construct5($run, $nombre1, $nombre2, $apellido1, $apellido2){
		$this->run              = $run;
		$this->id_joomla        = NULL;
		$this->id_usuario_movil = NULL;
		$this->nombre1          = $nombre1;
		$this->nombre2          = $nombre2;
		$this->apellido1        = $apellido1;
		$this->apellido2        = $apellido2;
		$this->estado           = "1";
	}
	
	//GETTERS Y SETTERS
	public function get_run(){ 
		return $this->run; 
	}
	public function set_run($run){ 
		$this->run = $run; 
	}
	public function get_id_joomla(){ 
		return $this->id_joomla; 
	}
	public function set_id_joomla($id_joomla){ 
		$this->id_joomla = $id_joomla; 
	}
	public function get_id_usuario_movil(){ 
		return $this->id_usuario_movil; 
	}
	public function set_id_usuario_movil($id_usuario_movil){ 
		$this->id_usuario_movil = $id_usuario_movil; 
	}
	public function get_nombre1(){ 
		return $this->nombre1; 
	}
	public function set_nombre1($nombre1){ 
		$this->nombre1 = $nombre1; 
	}
	public function get_nombre2(){ 
		return $this->nombre2; 
	}
	public function set_nombre2($nombre2){ 
		$this->nombre2 = $nombre2; 
	}
	public function get_apellido1(){ 
		return $this->apellido1; 
	}
	public function set_apellido1($apellido1){ 
		$this->apellido1 = $apellido1; 
	}
	public function get_apellido2(){ 
		return $this->apellido2; 
	}
	public function set_apellido2($apellido2){ 
		$this->apellido2 = $apellido2; 
	}
	public function get_estado(){ 
		return $this->estado; 
	}
	public function set_estado($estado){ 
		$this->estado = $estado; 
	}

	//VALIDAR RUN
	public function validar_run(){
        $r = $this->run;

        $r = str_replace(".","",$r);
        $r = str_replace("-","",$r);
        $r = str_replace(" ","",$r);
        $r = strtoupper($r);

        $numero = substr($r,0,strlen($r)-1);
        $digito_verificador = substr($r,strlen($r)-1,1);

        $serie = array(2,3,4,5,6,7);
        $digitos = array();
        $productos = array();
        $sumatoria = 0;
        $resto = 0;
        $j = 0;

        //VERIFICAR LONGITUD DEL NUMERO
        if(strlen($numero)<7 or strlen($numero)>8){
            //echo "<p>muy corto o my7 lartgo</p>";
            $this->run = NULL;
            return false;
        }

        //VERIFICAR SI SON SOLO NUMEROS ANTES DEL GUION
        if(!is_numeric($numero)){
            //echo "<p>hay letras antes del guion $numero</p>";
            $this->run = NULL;
            return false;
        }

        //VERIFICAR QUE SEAN NUMEROS O K DESPUES DEL GUION
        if(!is_numeric($digito_verificador) and $digito_verificador!="K"){
            $this->run = NULL;
            //echo "<br>ni numero k</br>";
            return false;
        }

        //VALIDART DIGITO VERIFICADOR
        for($i = (strlen($numero)-1); $i>=0; $i--){
            $digitos[$i] = substr($numero,$i,1);
            $productos[$i] = $digitos[$i]*$serie[$j];
            $sumatoria = $sumatoria + $productos[$i];
            $j++;
            if($j > 5){
                $j=0;
            }
        }
        $resto = $sumatoria % 11;
        switch ($digito_verificador) {
            case "0":
                $digito_verificador = "11";
                break;
            case "K":
                $digito_verificador = "10";
                break;
            default:
                break;
        }
        if((11-$resto) != $digito_verificador){
            echo "<p>rut no valido</p>";

            return false;
        }
        //echo $numero."<br/>".$digito_verificador;

        return true;
    }
	
    function validar_nombre1(){
        //SI ES INGRESADO
        $n = str_replace(" ","",$this->nombre1);
        if(empty($n)){
            $this->nombre1 = NULL;
            return FALSE;
        }

        //SI TIENE LA LONGITUD CORRECTA
        if(strlen($this->nombre1)<3 or strlen($this->nombre1)>30){
            $this->nombre1 = NULL;
            return FALSE;
        }
        // VALIDAR SOLO LETRAS
        if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $this->nombre1))){
            $this->nombre1 = NULL;
            return FALSE;
        }
        return true;
    }
    function validar_nombre2(){
        //SI ES INGRESADO
        $n = str_replace(" ","",$this->nombre2);
        if(empty($n)){
            $this->nombre2 = NULL;
            return FALSE;
        }

        //SI TIENE LA LONGITUD CORRECTA
        if(strlen($this->nombre2)<3 or strlen($this->nombre2)>30){
            $this->nombre2 = NULL;
            return FALSE;
        }
        // VALIDAR SOLO LETRAS
        if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $this->nombre2))){
            $this->nombre2 = NULL;
            return FALSE;
        }
        return true;
    }
    function validar_apellido1(){
        //SI ES INGRESADO
        $n = str_replace(" ","",$this->apellido1);
        if(empty($n)){
            $this->apellido1 = NULL;
            return FALSE;
        }

        //SI TIENE LA LONGITUD CORRECTA
        if(strlen($this->apellido1)<3 or strlen($this->apellido1)>30){
            $this->apellido1 = NULL;
            return FALSE;
        }
        // VALIDAR SOLO LETRAS
        if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $this->apellido1))){
            $this->apellido1 = NULL;
            return FALSE;
        }
        return true;
    }
    function validar_apellido2(){
        //SI ES INGRESADO
        $n = str_replace(" ","",$this->apellido2);
        if(empty($n)){
            $this->apellido2 = NULL;
            return FALSE;
        }

        //SI TIENE LA LONGITUD CORRECTA
        if(strlen($this->apellido2)<3 or strlen($this->apellido2)>30){
            $this->apellido2 = NULL;
            return FALSE;
        }
        // VALIDAR SOLO LETRAS
        if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $this->apellido2))){
            $this->apellido2 = NULL;
            return FALSE;
        }
        return true;
    }

    //VALIDADOR MAESTRO
    public function validarIdentidad(){
        $return = true;

        if (!$this->validar_run()){
            $return = false;
        }
        if(!$this->validar_nombre1()){
            $return = false;
        }
        if(!$this->validar_nombre2()){
            $return = false;
        }
        if(!$this->validar_apellido1()){
            $return = false;
        }
        if(!$this->validar_apellido2()){
            $return = false;
        }

        return $return;
    }
}






/*
$usuarioVacio         = new Usuario();
$usuarioParametrizado = new Usuario("00000000-0","RODRIGO","AlBERTO","SEPULVEDA","CASTRO");
echo var_dump($usuarioVacio);
echo var_dump($usuarioParametrizado);
$usuarioVacio->validar_run();
$usuarioParametrizado->validar_run()
echo var_dump($usuarioVacio);
echo var_dump($usuarioParametrizado);
*/

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

/*
$apoderadoVacio = new Apoderado();
$apoderadoParametrizado = new Apoderado("166890837","RODRIGO","AlBERTO","SEPULVEDA","CASTRO","123456","123456789","mi calle","123",NULL,"mi sector","1");
echo var_dump($apoderadoVacio);
echo var_dump($apoderadoParametrizado);
$apoderadoVacio->validar_run();
$apoderadoParametrizado->validar_run();
echo var_dump($apoderadoVacio);
echo var_dump($apoderadoParametrizado);
*/


?>