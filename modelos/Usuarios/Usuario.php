<?php 
echo "<br/>".dirname(__FILE__)."<br/>"; 
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
		if((!$r) or (is_array($r))){
			$this->run = NULL;
			return false; /* Hace falta el rut */
		}
		if(!$r = preg_replace('|[^0-9kK]|i', '', $r)){
			$this->run = NULL;
			return false; /* Era código basura */
		}
		if(!((strlen($r) == 8) or (strlen($r) == 9))){
			$this->run = NULL;
			return false; /* La cantidad de carácteres no es válida. */
		}
		$v = strtoupper(substr($r, -1));
		if(!$r = substr($r, 0, -1)){
			$this->run = NULL;
			return false; 
		}
		if(!((int)$r > 0)){
			$this->run = NULL;
			return false; /* No es un valor numérico */
		}
		$x = 2; $s = 0;
		for($i = (strlen($r) - 1); $i >= 0; $i--){
			if($x > 7)
				$x = 2;
			$s += ($r[$i] * $x);
			$x++;
		}
		$dv=11-($s % 11);
		if($dv == 10)
			$dv = 'K';
		if($dv == 11)
			$dv = '0';
		if($dv == $v){
			$this->run = number_format($r, 0, '', '.').'-'.$v; /* Formatea el RUT */
			return true;
		}else{
			$this->run = NULL;
			return false;
		}
	}
	
	//VALIDAR NOMBRE COMPLETO
	function validar_nombre_completo(){
		$n1 = $this->nombre1;
		$n2 = $this->nombre2;
		$a1 = $this->apellido1;
		$a2 = $this->apellido2;
		
		//SI NO SON INGRESADOS
		if(empty($n1)){
			$this->nombre1 = NULL;
			return FALSE;
		}
		if(empty($n2)){
			$this->nombre2 = NULL;
			return FALSE;
		}
		if(empty($a1)){
			$this->apellido1 = NULL;
			return FALSE;
		}
		if(empty($a2)){
			$this->apellido2 = NULL;
			return FALSE;
		}
		
		//SI SON MUY CORTOS O MUY LARGOS
		if(strlen($n1)<3 or strlen($n1)>30){
			$this->nombre1 = NULL;
			return FALSE;
		}
		if(strlen($n2)<3 or strlen($n2)>30){
			$this->nombre2 = NULL;
			return FALSE;
		}
		if(strlen($a1)<3 or strlen($a1)>30){
			$this->apellido1 = NULL;
			return FALSE;
		}
		if(strlen($a2)<3 or strlen($a2)>30){
			$this->apellido2 = NULL;
			return FALSE;
		}
		
		// SI CONTIENEN CARACTERES QUE NO SON LETRAS
		if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $n1))){
			$this->nombre1 = NULL;
			return FALSE;
		}
		if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $n2))){
			$this->nombre2 = NULL;
			return FALSE;
		}
		if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $a1))){
			$this->apellido1 = NULL;
			return FALSE;
		}
		if(!preg_match("/^[a-zA-ZñÑöÖáéíóúÁÉÍÓÚ]+$/",str_replace(' ', '', $a2))){
			$this->apellido2 = NULL;
			return FALSE;
		}
	}

}

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
	}

}



$apoderadoParametrizado = new Apoderado("166890837","RODRIGO","AlBERTO","SEPULVEDA","CASTRO","12345678","12345678","mi calle","123","303b","mi sector","34");
echo var_dump($apoderadoParametrizado);
$apoderadoParametrizado->validar_direccion();
echo var_dump($apoderadoParametrizado);
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