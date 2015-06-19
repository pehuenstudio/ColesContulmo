<?php
$user = JFactory::getUser();
if($user->username){
    $rbd_establecimiento = preg_split("/[adm_]+/", $user->username);
    $rbd_establecimiento = $rbd_establecimiento[0];
}else{
    $rbd_establecimiento = 51543;
}

date_default_timezone_set("America/Argentina/Buenos_Aires");
?>

<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link rel="stylesheet" href="/_code/vistas/css/load.css">
<link rel="stylesheet" href="/_code/vistas/css/validaciones.css">
<link rel="stylesheet" href="/_code/vistas/css/selectores.css">
<link rel="stylesheet" href="/_code/vistas/_administrador/css/manejo_clases.css">

<script src="/_code/vistas/js/jquery.min.js"></script>
<script src="/_code/vistas/js/jquery-ui.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script src="/_code/vistas/js/sticky.js"></script>
<script src="/_code/vistas/_administrador/js/manejo_clases.js"></script>

<h1 class="titulo">Manejo De Clases</h1>
<div id="contenedor_selectores">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_administrador/manejo_clases.selectores.php"?>
</div>
<div id="grilla10">&nbsp;</div>
<div id="contenedor_bloques">
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/_administrador/manejo_clases.bloques.php"?>
</div>
<div id="dialog"></div>
