<?php

//echo __FILE__."<br/>";

?>

<div id="contenedor_apoderado">
    <div class="contenedor_grillas">
        <div class="grilla5 izquierda">
            <div class="grilla10 titulo"><h3>Datos Personales</h3></div>
            <div class="grilla10">RUN<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" name="run_apoderado" id="run_apoderado" placeholder="ej. 12.345.678-k" maxlength="12">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Nombres<strong>*</strong></div>
            <div class="grilla5 izquierda">
                <input type="text" name="nombre1_apoderado" id="nombre1_apoderado" placeholder="Primer Nombre" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla5 derecha">
                <input type="text" name="nombre2_apoderado" id="nombre2_apoderado" placeholder="Segundo Nombre" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Apellidos<strong>*</strong></div>
            <div class="grilla5 izquierda">
                <input type="text" name="apellido1_apoderado" id="apellido1_apoderado" placeholder="Apellido Paterno" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla5 derecha">
                <input type="text" name="apellido2_apoderado" id="apellido2_apoderado" placeholder="Apellido Materno" maxlength="45">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Sexo<strong>*</strong></div>
            <div class="grilla10">
                <select name="sexo_apoderado" id="sexo_apoderado">
                    <option value="0">Seleccione Sexo</option>
                    <option value="F">Femenino</option>
                    <option value="M">Masculino</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Email</div>
            <div class="grilla10">
                <input type="email" name="email_apoderado" id="email_apoderado" placeholder="ej. yomi\@mail.com" maxlength="100">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Avatar</div>
            <div class="grilla10"> <img src="/_code/vistas/img/user.png" alt="Avatar Alumno" id="avatar_apoderado_preview"></div>
            <div class="grilla10"> <input type="file" name="avatar_apoderado" id="avatar_apoderado" accept="image/png,image/jpeg">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            
        </div>
        <!--PANEL DE DIRECCIONES-->
        <div class="grilla5 derecha">
            <div class="grilla10 titulo"><h3>Dirección</h3></div>
            <div class="grilla10">Calle<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" name="calle_apoderado" id="calle_apoderado" placeholder="ej. Los Tilos" maxlength="60">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Numero<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" name="numero_apoderado" id="numero_apoderado" placeholder="ej. 234" maxlength="5">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Depto</div>
            <div class="grilla10">
                <input type="text" name="depto_apoderado" id="depto_apoderado" placeholder="ej. 678" maxlength="5">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            
            <div class="grilla10">Región<strong>*</strong></div>
            <div class="grilla10">
                <select name="id_region_apoderado" id="id_region_apoderado">
                    <option value="0">Seleccione Región</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            
            <div class="grilla10">Provincia<strong>*</strong></div>
            <div class="grilla10">
                <select name="id_provincia_apoderado" id="id_provincia_apoderado" disabled="disabled">
                    <option value="0">Seleecione Provincia</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            
            <div class="grilla10">Comuna<strong>*</strong></div>
            <div class="grilla10">
                <select name="id_comuna_apoderado" id="id_comuna_apoderado" disabled="disabled">
                    <option value="0">Seleecione Comuna</option>
                </select>
                <div class="grilla10 error">&nbsp;</div>
            </div>
            <div class="grilla10">Sector<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" name="sector_apoderado" id="sector_apoderado" placeholder="ej. Villa Rivas" maxlength="60">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            
            <div class="grilla10"></div>
        </div>
        <div class="grilla10 titulo"><h3>Datos De Contacto</h3></div>
        <div class="grilla5 izquierda">
            <div class="grilla10">Teléfono Fijo</div>
            <div class="grilla10">
                <input type="text" name="telefono_fijo_apoderado" id="telefono_fijo_apoderado" placeholder="ej. 412123456" maxlength="9">
                <div class="grilla10 error">&nbsp;</div>
            </div>
        </div>
        <div class="grilla5 derecha">
            <div class="grilla10">Teléfono Celular<strong>*</strong></div>
            <div class="grilla10">
                <input type="text" name="telefono_celular_apoderado" id="telefono_celular_apoderado" placeholder="ej. 912345678" maxlength="9">
                <div class="grilla10 error">&nbsp;</div>
            </div>
            
        </div>
    </div>
</div>
