<?php
namespace personas;


require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Validacion.php";
require_once ROOT_MODELOS."Direccion.php";
//echo __FILE__."<br/>";

class Persona {
    private $run;
    private $nombre1;
    private $nombre2;
    private $apellido1;
    private $apellido2;
    private $sexo;
    private $id_direccion;
    private $direccion;

    private $avatar;
    private $email;

    private $estado = "1";


    function __construct() {

    }

    //GETTERS Y SETTERS
    public function get_email()
    {
        return $this->email;
    }

    public function set_email($email)
    {
        $this->email = $email;
    }

    public function set_id_direccion($id_direccion){
        $this->id_direccion = $id_direccion;
    }
    public function get_id_direccion()
    {
        return $this->id_direccion;
    }
    public function set_apellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }
    public function get_apellido1()
    {
        return $this->apellido1;
    }
    public function set_apellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }
    public function get_apellido2()
    {
        return $this->apellido2;
    }
    public function set_avatar($avatar)
    {
        $this->avatar = $avatar;
    }
    public function get_avatar()
    {
        return $this->avatar;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_nombre1($nombre1)
    {
        $this->nombre1 = $nombre1;
    }
    public function get_nombre1()
    {
        return $this->nombre1;
    }
    public function set_nombre2($nombre2)
    {
        $this->nombre2 = $nombre2;
    }
    public function get_nombre2()
    {
        return $this->nombre2;
    }
    public function set_run($run)
    {
        $this->run = $run;
    }
    public function get_run()
    {
        return $this->run;
    }
    public function set_sexo($sexo)
    {
        $this->sexo = $sexo;
    }
    public function get_sexo()
    {
        return $this->sexo;
    }


   //AGREGAR DATOS DE IDENTIDAD
    public function set_identidad_nueva($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $email) {
        $this->run = $run;
        $this->nombre1 = $nombre1;
        $this->nombre2 = $nombre2;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->sexo = $sexo;
        $this->email = $email;


    }

    //AGREGAR DIRECCION
    public function set_direccion(\Direccion $direccion) {
        $this->direccion = $direccion;

    }

    //OBTENER DIRECCION
    public function get_direccion(){
        return $this->direccion;
    }

//++++++++++++++++++++++++++++++++++++++++VALIDACIONES+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VALIDAR RUN
    public function validar_run(){
        global $v;

        //VERIFICAR LONGITUD DEL NUMERO
        if(!$v->validar_formato_run($this->run)){
            ////echo ERRORCITO.CLASE_PERSONA."RUN DEMASIADO LARGO O DEMASIADO CORTO<br/>";
            $this->run = null;
            return false;
        }

        //VALIDAR DIGITO VERIFICADOR
        if(!$v->validar_digito_run($this->run)){
            ////echo ERRORCITO.CLASE_PERSONA. "RUN DIGITO VERIFICADOR NO COINCIDE CON NUMERO <br/>";
            $this->run = null;
            return false;
        }
        $this->run = str_replace("-","",$this->run);
        $this->run = str_replace(".","",$this->run);

        ////echo INFO.CLASE_PERSONA." RUN INGRESADO CORRECTAMENTE ".$this->get_run()."<br/>";
        return true;
    }

    //VALIDAR NOMBRE1
    function validar_nombre1(){
        global $v;
        if(!$v->validar_texto($this->nombre1,3,45)){
            //echo ERRORCITO.CLASE_PERSONA."EL NOMBRE1 CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO<br/>";
            $this->nombre1 = null;
            return false;
        }
        //echo INFO.CLASE_PERSONA."NOMBRE1 INGRESADO CORRECTAMENTE <br/>";
        $this->nombre1 = mb_convert_case($this->nombre1, MB_CASE_TITLE, "UTF-8");
        return true;
    }

    //VALIDAR NOMBRE2
    function validar_nombre2(){
        global $v;
        if(!$v->validar_texto($this->nombre2,3,45)){
            //echo ERRORCITO.CLASE_PERSONA."NOMBRE2 CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO<br/>";
            $this->nombre2 = null;
            return false;
        }
        //echo INFO.CLASE_PERSONA."NOMBRE2 INGRESADO CORRECTAMENTE <br/>";
        $this->nombre2 = mb_convert_case($this->nombre2, MB_CASE_TITLE, "UTF-8");
        return true;
    }

    //VALIDAR APELLIDO1
    function validar_apellido1(){
        global $v;
        if(!$v->validar_texto($this->apellido1,3,45)){
            //echo ERRORCITO.CLASE_PERSONA."APELLIDO1 ".$this->apellido1." CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO ".$this->apellido1."<br/>";
            $this->apellido1 = null;
            return false;
        }
        //echo INFO.CLASE_PERSONA."APELIIDO11 ".$this->apellido1." INGRESADO CORRECTAMENTE <br/>";
        $this->apellido1 = mb_convert_case($this->apellido1, MB_CASE_TITLE, "UTF-8");
        return true;
    }

    //VALIDAR APELLIDO2
    function validar_apellido2(){
        global $v;
        if(!$v->validar_texto($this->apellido2,3,45)){
            //echo ERRORCITO.CLASE_PERSONA."APELLIDO2 ".$this->apellido2." CONTIENE CARACTERES NO PERMITIDOS O ES MUY CORTO O MUY LARGO<br/>";
            $this->apellido2 = null;
            return false;
        }
        //echo INFO.CLASE_PERSONA."APELLIDO2 ".$this->apellido2." INGRESADO CORRECTAMENTE <br/>";
        $this->apellido2 = mb_convert_case($this->apellido2, MB_CASE_TITLE, "UTF-8");
        return true;
    }

    //VALIDAR SEXO
    public function validar_sexo(){
        global $v;
        //$this->sexo = strtoupper($this->sexo);
        if(!$v->validar_formato_sexo($this->sexo)){
            //echo ERRORCITO.CLASE_PERSONA." SEXO NO INGRESADO O NO ES VALIDO<br/>";
            $this->sexo = null;
            return false;
        }
        //echo INFO.CLASE_PERSONA." SEXO INGRESADO CORRECTAMENTE<br/>";
        return true;
    }

    //VALIDAR EMAIL
    public function validar_email(){
        global $v;
        if(!$v->validar_formato_email($this->email)){
            //echo ERRORCITO.CLASE_PERSONA. " EMAIL ".$this->email." INGRESADO INCORRECTAMENTE <br/>";
            $this->email = null;
            return false;
        }
        //echo INFO.CLASE_PERSONA." EMAIL ".$this->email." INGRESADO CORRECTAMENTE <br/>";
        return true;
    }
   /* //VALIDAR CONTRASEÑA MOVIL
    public function validar_contrasena_movil(){
        global $v;
        if(!$v->validar_formato_numero_texto($this->contrasena_movil,6,12)){
            //echo ERRORCITO.CLASE_PERSONA."CONTRASEÑA MOVIL ES MUY CORTA O MUY LAGRGA O NO CUMPLE REQUISITO<br/>";
            $this->contrasena_movil = null;
            return false;
        }
        //echo INFO.CLASE_PERSONA."CONTRASEÑA MOVIL INGREESADA CORECTAMENTE<br/>";
        return true;
    }*/

    //VALIDADOR IDENTIDAD
    public function validar_identidad(){
        $return = true;

        if(!$this->validar_run()){
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
        if(!$this->validar_sexo()){
            $return = false;
        }
        if(!$this->validar_direccion()){
            $return = false;
        }

        if(!$this->validar_email()){
            $return = false;
        }

        return $return;
    }

    //VALIDAR DIRECCION
    public function validar_direccion(){
        if(isset($this->direccion)){
            if(!$this->direccion->validar()){
                return false;
            }
            return true;
        }
        return false;
    }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //PASAR JSON
    public function to_json0(){
       /* $json = array(
            "identidad"=> array(
                "run" => $this->run,
                "nombre1" => $this->nombre1,
                "nombre2" => $this->nombre2,
                "apellido1" => $this->apellido1,
                "apellido2" => $this->apellido2,
                "sexo" => $this->sexo
            ),
            "direccion" => array(
                "calle" => $this->direccion->get_calle(),
                "numero" => $this->direccion->get_numero(),
                "depto" => $this->direccion->get_depto(),
                "sector" => $this->direccion->get_sector(),
                "id_comuna" => $this->direccion->get_id_comuna(),
            ),
        );*/
        $json["identidad"]["run"]= $this->run;
        $json["identidad"]["nombre1"]= $this->nombre1;
        $json["identidad"]["nombre2"]= $this->nombre2;
        $json["identidad"]["apellido1"]= $this->apellido1;
        $json["identidad"]["apellido2"]= $this->apellido2;
        $json["identidad"]["sexo"]= $this->sexo;
        $json["identidad"]["email"]= $this->email;
        $json["identidad"]["avatar"]= $this->avatar;

        $json["direccion"]["calle"] = $this->direccion->get_calle();
        $json["direccion"]["numero"] = $this->direccion->get_numero();
        $json["direccion"]["depto"] = $this->direccion->get_depto();
        $json["direccion"]["sector"] = $this->direccion->get_sector();
        $json["direccion"]["id_comuna"] = $this->direccion->get_id_comuna();
       // var_dump($json);
        $json = json_encode($json,JSON_UNESCAPED_UNICODE);
       // var_dump($json);
        return $json;
    }

    //
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


/*



$p = new Persona();
$p->set_identidad_nueva("166890837", "RodÏrigo", "Alberto", "Sepúlveda", "Castro", "M");
$p->set_direccion(new \Direccion("Esmeralda", 1234, null, "Villa Rivas", 1));
$p->validar_identidad();
$p->validar_direccion();
$p->set_contrasena_movil("galatea198");
$p->validar_contrasena_movil();
var_dump($p);
*/
?>