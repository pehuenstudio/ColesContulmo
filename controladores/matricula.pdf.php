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
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/TipoEnsenanza.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/GradoRepetidoMatriz.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Matricula.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/modelos/Establecimiento.php";
require_once($_SERVER["DOCUMENT_ROOT"]."/_dompdf/dompdf_config.inc.php");

//var_dump($_POST);
$plataforma= $_SERVER["HTTP_HOST"];

date_default_timezone_set("America/Argentina/Buenos_Aires");
$date = date("Y-m-d H:i:s");
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = $dias[date('w')]." ".date('j')." de ".$meses[date('n')-1]. " del ".date('Y').", ".date("H:i:s") ;
$escudo = $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/img/escudo.png";
$municipalidad_nombre = MUNICIPALIDAD;

$run_alumno = $_POST["run_alumno"];
$run_alumno = str_replace("-","",$run_alumno);
$run_alumno = str_replace(".","",$run_alumno);

$matricula = new Matricula();
$matricula->set_run_alumno($run_alumno);
$matricula->set_periodo($_POST["periodo"]);
$matricula->db_get_datos();



$matricula_numero = $matricula->get_id_matricula();
$tipo_ensenanza = new TipoEnsenanza();
$tipo_ensenanza->set_id_tipo_ensenanza($matricula->get_id_tipo_ensenanza());
$tipo_ensenanza->db_get_datos();
$matricula_tipo_ensenanza = $tipo_ensenanza->get_nombre();
$matricula_periodo = $matricula->get_periodo();
$matricula_fi = new DateTime($matricula->get_fecha_incorporacion());
$matricula_fecha_incorporacion = $matricula_fi->format("j")." de ".$meses[$matricula_fi->format("n")-1]." de ".$matricula_fi->format("Y");
$curso = new Curso();
$curso->set_id_curso($matricula->get_id_curso());
$curso->db_get_datos();
$id_grado = $curso->get_id_grado();
if($curso->get_id_tipo_ensenanza() == 10){
    switch ($curso->get_id_grado()){
        case 4:
            $id_grado = "Pre-Kinder";
            break;

        case 5:
            $id_grado = "Kinder";
            break;
    }
}
$matricula_curso = $id_grado." ".$curso->get_grupo();
$run_apoderado = $matricula->get_run_apoderado();

$establecimiento = new Establecimiento();
$establecimiento->set_rbd_establecimiento($matricula->get_rbd_establecimiento());
$establecimiento->db_get_datos();
$establecimiento_nombre = $establecimiento->get_nombre();



$alumno = new \personas\Alumno();
$alumno->set_run($matricula->get_run_alumno());
$alumno->db_get_datos();
$alumno_nombre_completo = $alumno->get_nombre1()." ".$alumno->get_nombre2()." ".$alumno->get_apellido1()." ".$alumno->get_apellido2();
$alumno_fn = new DateTime($alumno->get_fecha_nacimiento());
$alumno_fecha_nacimiento = $alumno_fn->format("j")." de ".$meses[$alumno_fn->format("n")-1]." de ".$alumno_fn->format("Y");

$alumno_dir = new Direccion();
$alumno_dir->set_id_direccion($alumno->get_id_direccion());
$alumno_dir->db_get_datos();
$alumno_dir->db_get_ids_nombres();

$alumno_direccion = $alumno_dir->get_calle()." "
    .$alumno_dir->get_numero()." "
    .$alumno_dir->get_depto()." "
    .$alumno_dir->get_sector().", "
    .$alumno_dir->get_nombre_comuna();

$apoderado = new \personas\Apoderado();
$apoderado->set_run($matricula->get_run_apoderado());
$apoderado->db_get_datos();
$apoderado_nombre_completo = $apoderado->get_nombre1()." ".$apoderado->get_nombre2()." ".$apoderado->get_apellido1()." ".$apoderado->get_apellido2();

$apoderado_dir = new Direccion();
$apoderado_dir->set_id_direccion($apoderado->get_id_direccion());
$apoderado_dir->db_get_datos();
$apoderado_dir->db_get_ids_nombres();

$apoderado_direccion = $apoderado_dir->get_calle()." "
    .$apoderado_dir->get_numero()." "
    .$apoderado_dir->get_depto()." "
    .$apoderado_dir->get_sector().", "
    .$apoderado_dir->get_nombre_comuna();

$apoderado_telefono_fijo = $apoderado->get_telefono_fijo();
$apoderado_telefono_celular = $apoderado->get_telefono_celular();
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
            font-size: x-small;
        }
        table{
            width: 100%;
        }
        table td{

        }
        table td.izq{
            width: 30%;
            font-weight: bold ;
        }
        table td.cen{
            width: 1%;
        }
        table td.der{
            width: 69%;
            font-weight: lighter;
        }
        table td.titulo{
            background-color: #AAD4FF;
            text-align: center;
            color: #ffffff;
        }

        #header{
            width: 100%;
        }
        #header td.escudo{
            width: 80px;
            text-align: center;
        }
        #header img {
            background-image: url('/_code/vistas/img/escudo.png');
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
<!-- +++++++++++++++++++++++++CABECERA+++++++++++++++++++++++ -->
<table id='header'>
    <tr>
        <td class='escudo'>
            <img src='$escudo'>
        </td>
        <td>
            <h1>$municipalidad_nombre</h1>
            <h2>$establecimiento_nombre</h2>
            <h3>Fecha De Emisión: $fecha</h3>
        </td>
    </tr>
</table><hr>
<!-- +++++++++++++++++++++++++TITULO+++++++++++++++++++++++ -->
<h2>Comprobante De Matricula</h2>
<!-- +++++++++++++++++++++++++Resumen Matricula+++++++++++++++++++++++ -->
<table>
    <tr>
        <td colspan='3' class='titulo'><h3>Resumen De La Matricula</h3></td>
    </tr>
    <tr>
        <td class='izq'>Periodo</td>
        <td class='cen'>:</td>
        <td class='der'>$matricula_periodo</td>
    </tr>
    <tr>
        <td class='izq'>Numero</td>
        <td class='cen'>:</td>
        <td class='der'>$matricula_numero</td>
    </tr>
    <tr>
        <td class='izq'>Tipo De Enseñanza </td>
        <td class='cen'>:</td>
        <td class='der'>$matricula_tipo_ensenanza</td>
    </tr>
    <tr>
        <td class='izq'>Curso</td>
        <td class='cen'>:</td>
        <td class='der'>$matricula_curso</td>
    </tr>
    <tr>
        <td class='izq'>Fecha De Incorporación</td>
        <td class='cen'>:</td>
        <td class='der'>$matricula_fecha_incorporacion</td>
    </tr>

</table><br/><br/>
<!-- +++++++++++++++++++++++++DATOS DE ALUMNO+++++++++++++++++++++++ -->
<table id='tabla_alumno'>
    <tr>
        <td colspan='3' class='titulo'><h3>Datos de Alumno</h3></td>
    </tr>
    <tr>
        <td class='izq'>RUN</td>
        <td class='cen'>:</td>
        <td class='der'>$run_alumno</td>
    </tr>
    <tr>
        <td class='izq'>Nombre Completo</td>
        <td class='cen'>:</td>
        <td class='der'>$alumno_nombre_completo</td>
    </tr>
    <tr>
        <td class='izq'>Fecha De Nacimineto</td>
        <td class='cen'>:</td>
        <td class='der'>$alumno_fecha_nacimiento</td>
    </tr>
    <tr>
        <td class='izq'>Dirección</td>
        <td class='cen'>:</td>
        <td class='der'>$alumno_direccion</td>
    </tr>
</table><br/><br/>
<!-- +++++++++++++++++++++++++DATOS DEL CURSO+++++++++++++++++++++++ -->

<!-- +++++++++++++++++++++++++DATOS DE APODERADO+++++++++++++++++++++++ -->
<table>
    <tr>
        <td colspan='3' class='titulo'><h3>Datos de Apoderado</h3></td>
    </tr>
    <tr>
        <td class='izq'>RUN</td>
        <td class='cen'>:</td>
        <td class='der'>$run_apoderado</td>
    </tr>
    <tr>
        <td class='izq'>Nombre Completo</td>
        <td class='cen'>:</td>
        <td class='der'>$apoderado_nombre_completo</td>
    </tr>
    <tr>
        <td class='izq'>Dirección</td>
        <td class='cen'>:</td>
        <td class='der'>$apoderado_direccion</td>
    </tr>
    <tr>
        <td class='izq'>Teléfono Fijo</td>
        <td class='cen'>:</td>
        <td class='der'>$apoderado_telefono_fijo</td>
    </tr>
    <tr>
        <td class='izq'>Teléfono Celular</td>
        <td class='cen'>:</td>
        <td class='der'>$apoderado_telefono_celular</td>
    </tr>
</table><br/><br/><hr>
<h2>Acceso a la plataforma www.$plataforma</h2>
<table>
    <tr>
        <td colspan='3' class='titulo'><h3>Alumno</h3></td>

    </tr>
    <tr>
        <td class='izq'>Usuario</td>
        <td class='cen'>:</td>
        <td class='der'>$run_alumno</td>
    </tr>
        <tr>
        <td class='izq'>Contraseña</td>
        <td class='cen'>:</td>
        <td class='der'>$run_alumno</td>
    </tr>
</table>
<br/>
<table>
    <tr>
        <td colspan='3' class='titulo'><h3>Apoderado</h3></td>

    </tr>
    <tr>
        <td class='izq'>Usuario</td>
        <td class='cen'>:</td>
        <td class='der'>$run_apoderado</td>
    </tr>
        <tr>
        <td class='izq'>Contraseña</td>
        <td class='cen'>:</td>
        <td class='der'>$run_apoderado</td>
    </tr>
</table>
</body>
</html>
";

//echo $html;

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($run_alumno.".pdf");

?>

 