<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Mail {
    private $html;
    private $estado = "1";

    public function nueva_evaluacion($nombre_apoderado, $nombre_alumno, $nombre_profesor, $fecha, $coeficiente){
        $servidor = "eMuni/Contulmo";
        $this->html ="
        <div style='background-color:#40B1E2; padding: 1%; float: left; width: 98%'>
            <div style='width:98%; background-color:#FFFFFF; float: left; padding: 1%;'>
                <div style='width:100%; float: left'>
                    <img src='http://emuni-contulmo.tk/_code/vistas/img/logo.png' style='width:30%' />
                </div>
                <h1 style='margin-top: 40px; float: left'>Saludos $nombre_apoderado</h1>
                <div style='text-align: justify; width: 100%; float: left'>
                    <p>Le comunicamos que el Profesor: <strong>$nombre_profesor</strong>, ha generado una <strong>Evaluación coef $coeficiente</strong> para el <strong>$fecha</strong>,
                        para confirmar esta información y ver futuras evaluaciones ingrese a
                        <strong>$servidor</strong> > <strong>Ingreso</strong> > <strong>Ver Evaluaciones</strong>.</p>
                        <br/><br/>
                    <strong>Saludos cordiales de eMuni/Contulmo.</strong><br/>
                    <strong>Ilustre Municipalidad De Contulmo.</strong>
                </div>
            </div>
        </div>
        ";
    }

    public function enviar($to, $subject){
        $message  = $this->html;
        $headers  = 'From: eMuni Contulmo <no-reply@emuni-contulmo.cl>' . "\r\n".
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        mail($to, $subject, $message, $headers);
    }
}
?> 