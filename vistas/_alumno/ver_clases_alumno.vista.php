<?php
$user = JFactory::getUser();
if($user->username){
    $run_alumno = $user->username;
}else{
    $run_alumno = "166890837";
}
date_default_timezone_set("America/Argentina/Buenos_Aires");
?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/validaciones.css">
<link rel="stylesheet" href="/_code/vistas/css/selectores.css">
<link rel="stylesheet" href="/_code/vistas/_alumno/css/ver_clases_alumno.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/_alumno/js/ver_clases_alumno.js"></script>

<h1 class="titulo">Horario De Clases</h1>
<div id="contenedor_selectores">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_alumno/ver_clases_alumno.selectores.php"?>
</div>
<div id="contenedor_bloques">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_alumno/ver_clases_alumno.bloques.php"?>
</div>
<div id="dialog"></div>