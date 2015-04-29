
<?php
$presente = date("Y");
$futuro = date("Y")+1;

?>
<div id="contenedor_curso">
    <div class="contenedor_grillas">
    	<div class="grilla10 titulo"><h3>Datos Del Curso</h3></div>
        <div class="grilla10">Seleccione Periodo Academico</div>
        <div class="grilla10">
            <select id="periodo" name="periodo">
                <option value="<?php echo date("Y");?>"><?php echo date("Y");?></option>
                <option value="<?php echo (date("Y")+1);?>"><?php echo (date("Y")+1);?></option>
            </select>
            <div class="grilla10 error">&nbsp;</div>
        </div>
        <div class="grilla10">Seleccionar Establecimiento<strong>*</strong></div>
        <div class="grilla10">
            <select name="rbd_establecimiento" id="rbd_establecimiento">
                <option value="0">Seleccione Establecimiento</option>

            </select>
            <div class="grilla10 error">&nbsp;</div>
        </div>
        <div class="grilla10 error"></div>
        <div class="grilla10">Seleccionar Tipo De Ense&ntilde;anza<strong>*</strong></div>
        <div class="grilla10">
            <select name="id_tipo_ensenanza" id="id_tipo_ensenanza" disabled="disabled">
                <option value="0">Seleccione Tipo De Enseñanza</option>

            </select>
            <div class="grilla10 error">&nbsp;</div>
        </div>
        <div class="grilla10 error"></div>
        <div class="grilla10">Seleccionar Grado</div>
        <div class="grilla10">
            <select name="id_grado" id="id_grado" disabled="disabled">
                <option value="0">Seleccione Grado</option>
            </select>
            <div class="grilla10 error">&nbsp;</div>
        </div>
        <div class="grilla10 error"></div>
        <div class="grilla10">Seleccionar Grupo</div>
        <div class="grilla10">
            <select name="grupo" id="grupo" disabled="disabled">
                <option value="0">Seleccione Grupo</option>
            </select></div>
        <div class="grilla10 error">&nbsp;</div>
        <div class="grilla10 error"></div>
 	</div>
</div>
 