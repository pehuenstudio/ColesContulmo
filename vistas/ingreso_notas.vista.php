<?php
$run_profesor = "5308978k";
date_default_timezone_set("America/Argentina/Buenos_Aires");
$hoy = "2015-05-06";

?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/_ingreso_notas.css">


<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/mensajes.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/js/validaciones.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/_ingreso_notas.js"></script>

<div id="contenedor_selectores">
    <?php require_once "/_code/vistas/ingreso_notas.selectores.php"?>
</div>
<div id="contenedor_cartola">
    <?php require_once "/_code/vistas/ingreso_notas.cartola.php"?>
</div>
<div id="dialog"></div>