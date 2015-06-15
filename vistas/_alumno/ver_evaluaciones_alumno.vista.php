<?php
$run_alumno = "166890837";
date_default_timezone_set("America/Argentina/Buenos_Aires");

?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/validaciones.css">
<link rel="stylesheet" href="/_code/vistas/_alumno/css/_ver_evaluaciones_alumno.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/js/validaciones.js"></script>
<script src="/_code/vistas/_alumno/js/_ver_evaluaciones_alumno.js"></script>


<h1 class="titulo">Calendario De Evaluaciones</h1>
<div id="contenedor_selectores">
    <?php require_once "/_code/vistas/_alumno/ver_evaluaciones_alumno.selectores.php"?>
</div>
<div id="contenedor_calendario">
    <?php require_once "/_code/vistas/_alumno/ver_evaluaciones_alumno.calendario.php"?>
</div>
<div id="dialog"></div>
