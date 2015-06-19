<?php
$user = JFactory::getUser();
if($user->username){
    $rbd_establecimiento = preg_split("/[adm_]+/", $user->username);
    $rbd_establecimiento = $rbd_establecimiento[0];
}else{
    $rbd_establecimiento = 51543;
}

date_default_timezone_set("America/Argentina/Buenos_Aires");
$periodo_actual = date("Y");
$periodo_futuro = $periodo_actual + 1;
?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/validaciones.css">
<link rel="stylesheet" href="/_code/vistas/css/selectores.css">
<link rel="stylesheet" href="/_code/vistas/_administrador/css/ingreso_curso.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/js/validaciones.js"></script>
<script src="/_code/vistas/_administrador/js/ingreso_curso.js"></script>

<h1 class="titulo">Ingreso De Cursos</h1>
<div id="contenedor_rapido">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_administrador/ingreso_curso.rapido.php"?>
</div>
<div id="contenedor_nuevo">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_administrador/ingreso_curso.nuevo.php"?>
</div>