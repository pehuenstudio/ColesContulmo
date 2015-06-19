<input type="hidden" id="rbd_establecimiento" name="rbd_establecimiento" value="<?php echo $rbd_establecimiento;?>">

<div id="contenedor_cursos_cen_header">Ingreso Rápido</div>
<div id="contenedor_cursos_izq_header">Cursos Actuales</div>
<div id="contenedor_cursos_der_header">Cursos Futuros</div>

<div id="contenedor_periodo_actual">
    <select id="periodo_actual_rapido" name="periodo_actual">
        <option value="0">Seleccione Periodo Actual</option>
        <option value="<?php echo $periodo_actual;?>"><?php echo $periodo_actual;?></option>
        <option value="<?php echo $periodo_futuro;?>"><?php echo $periodo_futuro;?></option>
    </select>
</div>

<div id="contenedor_periodo_futuro">
    <select id="periodo_futuro_rapido" name="periodo_futuro">
        <option value="0">Seleccione Periodo futuro</option>
        <option value="<?php echo $periodo_futuro;?>"><?php echo $periodo_futuro;?></option>
        <option value="<?php echo $periodo_actual;?>"><?php echo $periodo_actual;?></option>
    </select>
</div>


<div class="contenedor_botones izq">
    <button class="seleccionar" data-rol="seleccionar">Seleccionar Todo</button>
    <button class="limpiar selected" data-rol="limpiar">Limpiar Todo</button>
</div>

<div class="empty der">
    <div class="empty">


    </div>

</div>

<div id="contenedor_cursos_izq"></div>
<div id="contenedor_cursos_der"></div>

<div class="contenedor_botones">
    <div class="contenedor_boton_izq">
        <button id="pasar_rapido">Pasar</button>
    </div>
    <div class="contenedor_boton_der">
        <button id="ingresar_rapido">Ingresar</button>
    </div>
</div>