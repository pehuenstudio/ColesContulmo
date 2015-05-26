 <?php

//echo __FILE__."<br/>";

?>

<div id="contenedor_alumno">
    <div class="contenedor_grillas">
        <div class="grilla5 izquierda">
            <div class="grilla10 titulo"><h3>Datos Personales</h3></div>
            <div class="grilla10">RUN<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" value="166890837" name="run_alumno" id="run_alumno" title="ej. 12.345.678-8" placeholder="ej. 12.345.678-8" maxlength="12">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Nombres<strong>*</strong></div>
            <div class="grilla5 izquierda">
                <input name="nombre1_alumno" id="nombre1_alumno" placeholder="Primer Nombre" type="text" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla5 derecha">
                <input name="nombre2_alumno" id="nombre2_alumno" placeholder="Segundo Nombre" type="text" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Apellidos<strong>*</strong></div>
            <div class="grilla5 izquierda">
                <input type="text" name="apellido1_alumno" id="apellido1_alumno" placeholder="Apellido Paterno" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla5 derecha">
                <input type="text" name="apellido2_alumno" id="apellido2_alumno" placeholder="Apellido Materno" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Sexo<strong>*</strong></div>
            <div class="grilla10">
                <select name="sexo_alumno" id="sexo_alumno">
                    <option value="0">Seleccione Sexo</option>
                    <option value="F">Femenino</option>
                    <option value="M">Masculino</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla5 izquierda">Fecha De Nacimiento<strong>*</strong></div><div class="grilla5 derecha">Edad al 31 marzo</div>
            <div class="grilla5 izquierda">
                <input name="fecha_nacimiento_alumno" id="fecha_nacimiento_alumno" type="date">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla5 derecha">
                <input type="number" class="grilla5 derecha" id="edad" readonly>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Email</div>
            <div class="grilla10">
                <input name="email_alumno" id="email_alumno" placeholder="ej. minombre\@bremail.cl" type="email" maxlength="100">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Avatar</div>
            <div class="grilla10">
                <img src="/_code/vistas/img/user.png" alt="Avatar Alumno" id="avatar_alumno_preview">
            </div>
            <div class="grilla10">
                <input type="file" name="avatar_alumno" id="avatar_alumno" accept="image/png,image/jpeg">
                <div class="grilla10 error">&nbsp;</div>
            </div>
        </div>

        <!--PANEL DE DIRECCIONES-->

        <div class="grilla5 derecha">
            <div class="grilla10 titulo"><h3>Dirección</h3></div>

            <div class="grilla10">Calle<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" name="calle_alumno" id="calle_alumno" placeholder="ej. Las Rosas" maxlength="60">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Numero<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" name="numero_alumno" id="numero_alumno" placeholder="ej. 123" maxlength="5">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Depto</div>
            <div class="grilla10">
                <input type="text" name="depto_alumno" id="depto_alumno" placeholder="ej. 101" maxlength="5">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Región<strong>*</strong></div>
            <div class="grilla10">
                <select name="id_region_alumno" id="id_region_alumno">
                    <option value="0">Seleccione Región</option>

                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Provincia<strong>*</strong></div>
            <div class="grilla10">
                <select name="id_provincia_alumno" id="id_provincia_alumno" disabled="disabled">
                    <option value="0">Seleccione Provincia</option>

                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Comuna<strong>*</strong></div>
            <div class="grilla10">
                <select name="id_comuna_alumno" id="id_comuna_alumno" disabled="disabled">
                    <option value="0">Seleccione Comuna</option>

                </select>
                <div class="grilla10 error">&nbsp;</div>

            </div>
            <div class="grilla10">Sector</div>
            <div class="grilla10">
                <input type="text" name="sector_alumno" id="sector_alumno" placeholder="ej. Calebu" maxlength="60"/>
                <div class="grilla10 error">&nbsp;</div>
            </div>

            <div class="grilla10"></div>
        </div>
        <div class="grilla10">&nbsp;</div>

        <!--PANEL DE DATOS ADICIONALES-->
        <div class="grilla10 titulo"><h3>Datos Adicionales Del Alumno </h3></div>
        <div class="grilla5 izquierda">
            <div class="grilla10">Establecimiento De Procedencia<strong>*</strong></div>
            <div class="grilla10">
                <input id="establecimiento_procedencia" name="establecimiento_procedencia" maxlength="60" value="Escuela San Luis de Contulmo">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Grados Repetidos</div>
            <div class="grilla10">
            <?php require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/matricula/formulario.repeticiones.vista.php"?>
                <div class="grilla10 error" id="error_cantidad">&nbsp;</div>
            </div>
        </div>
        <div class="grilla5 derecha">
            <div class="grilla10">¿Problemas De Aprendizaje?<strong>*</strong></div>
            <div class="grilla10">
                <select name="pde" id="pde">
                    <option value="0">Seleccione Una Opción</option>
                    <option value="1">Si</option>
                    <option value="2">No</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Religion<strong>*</strong></div>
            <div class="grilla10">
                <select name="id_religion_alumno" id="id_religion_alumno">
                    <option value="0">Ninguna</option>
                </select>
            </div>
        </div>
        <div class="grilla10">&nbsp;</div>

        <!--PANEL DE LOS PADRES-->
        <div class="grilla10 titulo"><h3>Datos De Los Padres</h3></div>
        <div class="grilla5 izquierda">
            <div class="grilla10">Grado Educacional Del Padre<strong>*</strong></div>
            <div class="grilla10">
                <select name="grado_educacional_padre" id="grado_educacional_padre">
                    <option value="0" >Seleccione Un Grado</option>

                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
        </div>
        <div class="grilla5 derecha">
            <div class="grilla10">Grado Educacional De La Madre<strong>*</strong></div>
            <div class="grilla10">
                <select name="grado_educacional_madre" id="grado_educacional_madre">
                    <option value="0" >Seleccione Un Grado</option>

                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>

        </div>
        <div class="grilla10">Persona Con Quien Vive<strong>*</strong></div>
        <div class="grilla10">
            <input type="text" name="persona_vive_alumno" id="persona_vive_alumno" placeholder="ej. Con el padre" list="persona_vive_lista">
            <datalist id="persona_vive_lista">
                <option value="Con la madre">
                <option value="Con el padre">
                <option value="Con los padres">
                <option value="Con la abuela">
                <option value="Con el abuelo">
                <option value="Con los abuelos">
                <option value="Con una hermana">
                <option value="Con un hermano">
            </datalist>
            <div class="grilla10 error">&nbsp;</div>
        </div>
  	</div>
</div>
<script>
    var hoydia = new Date();
    jQuery("#fecha_nacimiento_alumno").attr("max",hoydia.getFullYear()+"-12-31");
    jQuery("#fecha_nacimiento_alumno").attr("min",hoydia.getFullYear()-100+"-12-31");
</script>