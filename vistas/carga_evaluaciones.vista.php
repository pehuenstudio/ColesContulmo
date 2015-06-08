<?php
$run_profesor = "5308978k";
date_default_timezone_set("America/Argentina/Buenos_Aires");
$hoy = "2015-05-06";

?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/fullcalendar.css">
<link rel="stylesheet" href="/_code/vistas/css/fullcalendar.print.css" media='print'>
<link rel="stylesheet" href="/_code/vistas/css/_carga_evaluaciones.css">

<script>//var hoy = "<?php //echo $hoy; ?>";</script>
<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/moment.min.js"></script>
<script src="/_code/vistas/js/fullcalendar.js"></script>
<script src="/_code/vistas/js/fullcalendar.es.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/js/_carga_evaluaciones.js"></script>



<div id="contenedor_selectores">
    <?php require_once "/_code/vistas/carga_evaluaciones.selectores.php"?>
</div>
<div id="contenedor_calendario">
    <?php require_once "/_code/vistas/carga_evaluaciones.calendario.php"?>
</div>
<div id="contenedor_formulario">
    <?php require_once "/_code/vistas/carga_evaluaciones.formulario.php"?>
</div>

<div id="dialog"></div>
