<?php
header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/Resize.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Persona.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Alumno.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/personas/Apoderado.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Direccion.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Curso.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetido.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/MatrizGradosRepetidos.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Matricula.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Establecimiento.php";
require_once($_SERVER["DOCUMENT_ROOT"]."/_dompdf/dompdf_config.inc.php");

date_default_timezone_set("America/Argentina/Buenos_Aires");
$date = date("Y-m-d H:i:s");

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$fecha = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

$escudo = $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/img/escudo.png";

$municipalidad_nombre = MUNICIPALIDAD;

$establecimiento = new Establecimiento();
$establecimiento->set_rbd_establecimiento($_POST["rbd_establecimiento"]);
$establecimiento->db_get_datos();
$establecimiento_nombre = $establecimiento->get_nombre();


$alumno = new \personas\Alumno();
$alumno->set_run($_POST["run_alumno"]);
$alumno->db_get_datos();
$alumno_nombre_completo = $alumno->get_nombre1()." ".$alumno->get_nombre2()." ".$alumno->get_apellido1()." ".$alumno->get_apellido2();
$alumno_fn = new DateTime($alumno->get_fecha_nacimiento());
$alumno_fecha_nacimiento = $alumno_fn->format("d")." de ".$meses[$alumno_fn->format("n")-1]." de ".$alumno_fn->format("Y");

$alumno_dir = new Direccion();
$alumno_dir->set_id_direccion($alumno->get_id_direccion());
$alumno_dir->db_get_datos();
$alumno_direccion = $alumno_dir->get_calle()." "
    .$alumno_dir->get_numero()." "
    .$alumno_dir->get_depto()." "
    .$alumno_dir->get_sector();

var_dump($alumno_dir);
$html = "
<!DOCTYPE HTML>
<html>
<head>
    <title>Matricula $date</title>
    <style>
        @page {
            margin: 1cm;
        }
        body{
            color: #808080;
            font-family: monospace;
        }
        table{
            width: 100%;
        }
        table td{
            border-style: solid;
        }
        #header{
            width: 100%;
        }
        #header td.escudo{
            width: 80px;
            text-align: center;
        }
        #header img {
            background-image: url('http://static.forosdelweb.com/images/misc/cross.png');
            width: 79px;
            height: 119px;
        }
        #header h1,#header h2,#header h3 {
            margin-bottom: 1px;
            margin-top: 0;
        }

    </style>
</head>
<body>
<table id='header'>
    <tr>
        <td class='escudo'>
            <img src='$escudo'>
        </td>
        <td>
            <h1>$establecimiento_nombre</h1>
            <h2>$municipalidad_nombre</h2>
            <h3>$fecha</h3>
        </td>
    </tr>
</table>

<table id='tabla_alumno'>
    <tr>
        <td colspan='2'></td>
    </tr>
    <tr>
        <td>Nombre Completo</td>
        <td>$alumno_nombre_completo</td>
    </tr>
    <tr>
        <td>Fecha Nacimineto</td>
        <td>$alumno_fecha_nacimiento</td>
    </tr>
    <tr>
        <td>Direccion</td>
        <td>$alumno_direccion</td>
    </tr>
</table>
</body>
</html>
";

echo $html;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
//$dompdf->stream("sample.pdf");
?>

 