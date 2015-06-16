<?php
$run_profesor = "5308978k";
date_default_timezone_set("America/Argentina/Buenos_Aires");


?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/validaciones.css">
<link rel="stylesheet" href="/_code/vistas/css/selectores.css">
<link rel="stylesheet" href="/_code/vistas/_profesor/css/carga_evaluaciones.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/js/validaciones.js"></script>
<script src="/_code/vistas/_profesor/js/carga_evaluaciones.js"></script>



<div id="contenedor_selectores">
    <?php require_once "/_code/vistas/_profesor/carga_evaluaciones.selectores.php"?>
</div>
<div id="contenedor_calendario">
    <?php require_once "/_code/vistas/_profesor/carga_evaluaciones.calendario.php"?>
</div>
<div id="contenedor_formularios">
    <?php require_once "/_code/vistas/_profesor/carga_evaluaciones.formularios.php"?>
</div>

<div id="dialog"></div>
