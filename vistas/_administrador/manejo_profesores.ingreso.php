<style>
.columna{
    /*border: 1px solid #000000;*/
}
</style>
<form id="formulario_ingreso" enctype="multipart/form-data">
<div class="contenedor_formulario">
    <div class="columna n50">
        <h3>Ingreso/Actualización De Profesores</h3>
        <div class="fila">
            <label>RUN <strong>*</strong></label>
            <input id="run_profesor" name="run_profesor" placeholder="ej: 12345678-k">
            <div class="celda n100 ultima error">&nbsp;</div>
        </div>
        <div class="fila">
            <label>Nombres <strong>*</strong></label>
            <div class="celda n50">
                <input id="nombre1" name="nombre1" placeholder="Primer Nombre">
                <div class="celda n100 ultima error">&nbsp;</div>
            </div>
            <div class="celda n50 ultima">
                <input id="nombre2" name="nombre2" placeholder="Segundo Nombre">
                <div class="celda n100 ultima error">&nbsp;</div>
            </div>
        </div>
        <div class="fila">
            <label>Apellidos <strong>*</strong></label>
            <div class="celda n50">
                <input id="apellido1" name="apellido1" placeholder="Apellido Paterno">
                <div class="celda n100 ultima error">&nbsp;</div>
            </div>
            <div class="celda n50 ultima">
                <input id="apellido2" name="apellido2" placeholder="Apellido Materno">
                <div class="celda n100 ultima error">&nbsp;</div>
            </div>
        </div>
        <div class="fila">
            <label>Sexo <strong>*</strong></label>
            <select id="sexo" name="sexo">
                <option value="0">Seleccione Sexo</option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
            </select>
            <div class="celda n100 ultima error">&nbsp;</div>
        </div>
        <div class="fila">
            <label>Avatar </label>
            <div class="celda n20">
                <img id="avatar_preview" src="/_code/vistas/img/user.png" width="100px"/>
            </div>
            <div class="celda n80 ultima">
                <input id="avatar" name="avatar" type="file">
                <div class="celda n100 ultima error">&nbsp;</div>
            </div>
        </div>
        <div class="fila ultima">
            <label>Email <strong>*</strong></label>
            <input id="email" name="email" type="email">
            <div class="celda n100 ultima error">&nbsp;</div>
        </div>
        <div class="fila">
            <input type="submit" value="Ingresar">
        </div>
    </div>
    <div class="columna n50 ultima">
        <h3>Eliminar Profesor</h3>
    </div>
</div>
</form>