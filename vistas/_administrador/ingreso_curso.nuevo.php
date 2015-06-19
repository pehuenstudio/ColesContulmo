<div id="contenedor_cursos_cen_header">Ingreso Nuevo</div>
<form enctype="multipart/form-data" id="formulario_curso">
    <div class="contenedor_grillas">
        <div class="grilla10">
            <div class="grilla10">Tipo De Enseñanza<strong>*</strong></div>
            <select id="id_tipo_ensenanza" name="id_tipo_ensenanza">
                <option value="0">Seleccione Tipo De Enseñanza</option>
            </select>
            <div class="grilla10 error"></div>
        </div>
        <div class="grilla10">
            <div class="grilla10">Grado<strong>*</strong></div>
            <select id="id_grado" name="id_grado">
                <option value="0">Seleccione Un Grado</option>
            </select>
            <div class="grilla10 error"></div>
        </div>
        <div class="grilla10">
            <div class="grilla10">Ciclo<strong>*</strong></div>
            <select id="id_ciclo" name="id_ciclo">
                <option value="0">Seleccione Un Ciclo</option>
                <option value="0">Sin Ciclo</option>
            </select>
            <div class="grilla10 error"></div>
        </div>
        <div class="grilla10">
            <div class="grilla10">Grupo<strong>*</strong></div>
            <select id="grupo" name="grupo">
                <option value="0">Seleccione Un Grupo</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            <div class="grilla10 error"></div>
        </div>
        <div class="grilla10">
            <div class="grilla10">Periodo<strong>*</strong></div>
            <select id="periodo_futuro" name="periodo">
                <option value="0">Seleccione Periodo</option>
                <option value="<?php echo $periodo_futuro;?>"><?php echo $periodo_futuro;?></option>
                <option value="<?php echo $periodo_actual;?>"><?php echo $periodo_actual;?></option>
            </select>
            <div class="grilla10 error">&nbsp;</div>
        </div>
        <div class="grilla10">
            <button id="ingresar_nuevo">Ingresar</button>
        </div>
    </div>
</form>