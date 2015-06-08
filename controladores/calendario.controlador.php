<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Argentina/Buenos_Aires");
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/CalendarioMatriz.php";

$id_funcion = $_POST["id_funcion"];

switch($id_funcion){
    case "1":
        get_dias_mes();
        break;
    default:
        break;

}
function get_dias_mes(){
    //print_r($_POST);
    $mes_actual = $_POST["mes_actual"];
    $ano_actual = $_POST["ano_actual"];

    $primero = 1;
    $ultimo = cal_days_in_month(CAL_GREGORIAN, $mes_actual, $ano_actual);

    //print_r($ultimo);
    $matriz_calendario = new CalendarioMatriz();
    for($i = $primero; $i <= $ultimo; $i++){
        $dia_mes = $i;
        $mes = $mes_actual;
        $ano = sprintf("%04d", $ano_actual);

        $fecha = $ano. "-" . sprintf("%02d", $mes) . "-" . sprintf("%02d", $dia_mes);

        $dia_semana = sprintf("%00d", date('w', strtotime($fecha)));


        if($dia_semana != "00" and $dia_semana != "06") {
            $calendario = new Calendario();
            $calendario->set_identidad(
                $fecha,
                $mes,
                $dia_semana,
                $dia_mes
            );
            $matriz_calendario->to_matriz($calendario);
        }

    }

    print_r($matriz_calendario->to_json());
    /*$hoy = $_POST["hoy"];
    $primero = 1;
    $ultimo = (int)date("t", strtotime($hoy));

    $matriz_calendario = new CalendarioMatriz();

    //print_r(date("t"));
    for($i = $primero; $i <= $ultimo; $i++){
        $dia_mes = sprintf("%02d", $i);
        $mes = sprintf("%02d", date("m", strtotime($hoy)));
        $ano = date("Y", strtotime($hoy));
        $fecha = $ano. "-" . $mes . "-" . $dia_mes;

        $dia_semana = sprintf("%02d", date('w', strtotime($fecha)));


        if($dia_semana != "00" and $dia_semana != "06") {
            $calendario = new Calendario();
            $calendario->set_identidad(
                $fecha,
                $dia_semana,
                $dia_mes
            );
            $matriz_calendario->to_matriz($calendario);
        }

    }

    print_r($matriz_calendario->to_json());
    */
}
?>