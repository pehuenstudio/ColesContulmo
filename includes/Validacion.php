<?php


//echo __FILE__."<br/>";

class Validacion {
    private $regexp_run = "/^([0-9]{1,2}\.[0-9]{3}\.[0-9]{3}\-[0-9kK]{1}|[0-9]{7,8}\-{0,1}[0-9kK]{1})$/";
    private $regexp_sexo = "/^[mMfF]{1}$/";
    private $regexp_grado_educacional = "/^[1-9]{1}$/";



    function __construct() {

    }

    public function validar_formato_email($email){
        if(empty($email)){
            return true;
        }
        $regexp_email = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/";
        if(!preg_match($regexp_email,$email)){
            return false;
        }
        return true;
    }

    public function validar_formato_run($run){
        if(preg_match($this->regexp_run, $run)){
            $run = str_replace(".","",$run);
            $run = str_replace("-","",$run);
            $run = strtoupper($run);

            $numero = substr($run,0,strlen($run)-1);
            $digito_verificador = substr($run,strlen($run)-1,1);

            return true;
        }
        return false;
    }//VALIDAR FORMATO RUN

    public function validar_digito_run($run){
        $run = str_replace(".","",$run);
        $run = str_replace("-","",$run);
        $run = str_replace(" ","",$run);
        $run = strtoupper($run);

        $numero = substr($run,0,strlen($run)-1);
        $digito_verificador = substr($run,strlen($run)-1,1);

        $serie = array(2,3,4,5,6,7);
        $digitos = array();
        $productos = array();
        $sumatoria = 0;
        $resto = 0;
        $j = 0;

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
        if((11-$resto) == $digito_verificador){
            return true;
        }
        return false;
    }

    public function validar_texto($texto,$min,$max){
        $max = round($max / 2);
        $regexp_text = "/^[a-záéíóúñö\s]{".$min.",".$max."}$/i";
        //echo "<br/>".$regexp_text."<br/>";
        //echo "<br/>".$texto."<br/>";
        if(!preg_match($regexp_text,$texto)){
            return false;
        }
        return true;

    }

    public function validar_formato_sexo($sexo){
        if(preg_match($this->regexp_sexo,$sexo)){
            return true;
        }
        return false;
    }

    public function validar_formato_numero($numero,$min,$max){
        $regexp_numero = "/^[0-9]{".$min.",".$max."}$/";
        if(preg_match($regexp_numero,$numero)){
            return true;
        }
        return false;
    }

    public function validar_formato_numero_texto($numero_texo,$min,$max){
        $regexp_numero_texto = "/^[a-záéíóúñö0-9\s]{".$min.",".$max."}$/i";
        if(preg_match($regexp_numero_texto,$numero_texo)){
            return true;
        }
        return false;
    }

    public function validar_formato_fecha($fecha){
        $regexp_fecha = "/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/";
        if(preg_match($regexp_fecha,$fecha)){
            return true;
        }
        return false;
    }

    public function validar_formato_verdadero_falso($vf){
        $regexp_vf = "/^[12]{1}$/";
        if(preg_match($regexp_vf,$vf)){
            return true;
        }
        return false;
    }

    public function validar_grado_educacional($grado_educacional){
        if(preg_match($this->regexp_grado_educacional,$grado_educacional)){
            return true;
        }
        return false;
    }
}
$v = new Validacion();