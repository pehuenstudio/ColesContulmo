<?php //echo __FILE__."<br/>";

$run_profesor = "5308978k";
$fecha_hoy = date("Y-m-d");
?>
<link rel="stylesheet" href="/_code/vistas/css/jquery-ui.css">
<link rel="stylesheet" href="/_code/vistas/css/grillas.css">
<link href="/_code/vistas/css/fullcalendar.css" rel='stylesheet' />
<link href="/_code/vistas/css/fullcalendar.print.css" rel='stylesheet' media='print' />
<link href="/_code/vistas/css/evaluacion.calendario.css" rel='stylesheet' />
<link rel="stylesheet" href="/_code/vistas/css/load.css">

<script src="/_code/vistas/js/moment.min.js"></script>
<script src="/_code/vistas/js/_jquery.min.js"></script>
<script src="/_code/vistas/js/_jquery-ui.js"></script>
<script src="/_code/vistas/js/fullcalendar.es.js"></script>
<script src="/_code/vistas/js/fullcalendar.js"></script>
<script src="/_code/vistas/js/mensajes.js"></script>
<script src="/_code/vistas/js/load.js"></script>
<script>

    var run_profesor = "<?php echo $run_profesor; ?>";
    var fecha_hoy = "<?php echo $fecha_hoy; ?>";

    //console.log("esta es "+fecha_hoy);
</script>
<script src="/_code/vistas/js/evaluacion.calendario.js"></script>

<div id="contenedor_cursos">
    <?php require_once "/_code/vistas/evaluacion.formulario.php"?>
</div>
<div id="contenedor_calendario">
<?php require_once "/_code/vistas/evaluacion.calendario.php"?>
</div>
