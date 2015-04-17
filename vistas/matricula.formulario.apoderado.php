<?php

echo __FILE__."<br/>";

?>

<style>

    .contenedor_grillas {
        width: 90% !important;
        margin:auto !important;
    }
    .contenedor_grillas div {
        float: left !important;
        display: inline !important;
        margin-bottom: 5px !important;
        padding:0 !important;
    }
    .contenedor_grillas div h3{
        width:100%;
        text-align:center;
    }
    .grilla1 {
        width: 8% !important;
    }
    .grilla9 {
        width: 90% !important;
    }
    .grilla2 {
        width: 18% !important;
    }
    .grilla8 {
        width: 80% !important;
    }
    .grilla3 {
        width: 28% !important;
    }
    .grilla7 {
        width: 70% !important;
    }
    .grilla4 {
        width: 38% !important;
    }
    .grilla6 {
        width: 60% !important;
    }
    .grilla5 {
        width: 49% !important;
    }
    .grilla10 {
        width: 100% !important;
    }

    .grilla5.derecha{
        margin-left: 1% !important;

    }
    .grilla5.izquierda{
        margin-right: 1% !important;

    }
</style>

<style>
    #matricula_formulario {
        width:100% !important;
    }
    #matricula_formulario div{

    }
    #matricula_formulario div.titulo{
        margin-bottom:1px !important;
        padding:0 !important;
    }
    #matricula_formulario div.titulo h3{
        margin:0 !important;
        height:60px;

    }
    #matricula_formulario input, #matricula_formulario select, #matricula_formulario textarea{
        width:100% !important;
        height:30px !important;
        margin:0 !important;
    }

    #matricula_formulario div.error{
        font-size:small !important;
        font-style:italic !important;
        color:red !important;
        margin-top:-10px !important;
    }

    #matricula_formulario div.error p{
        margin: 0 !important;
    }
</style>




<form id="matricula_formulario">
    <div class="contenedor_grillas">
        <div class="grilla5 izquierda">
            <div class="grilla10 titulo"><h3>Datos Personales</h3></div>
            <div class="grilla10">RUN</div>
            <div class="grilla10"> <input type="text"></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Nombres</div>
            <div class="grilla5 izquierda"> <input type="text"></div><div class="grilla5 derecha"> <input type="text"></div>
            <div class="grilla5 error izquierda">aquierror</div><div class="grilla5 error derecha">aquierror</div>
            <div class="grilla10">Apellidos</div>
            <div class="grilla5 izquierda"> <input type="text"></div><div class="grilla5 derecha"> <input type="text"></div>
            <div class="grilla5 error izquierda">aquierror</div><div class="grilla5 error derecha">aquierror</div>
            <div class="grilla10">Sexo</div>
            <div class="grilla10"> <select><option>Seleccione Sexo</option><option>Femenino</option><option>Masculino</option></select></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Avatar</div>
            <div class="grilla2"> <img src="#" alt="Avatar Alumno"></div><div class="grilla8"> <input type="file"></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Email</div>
            <div class="grilla10"><input type="email"></div>
            <div class="grilla10 error">aquierror</div>
        </div>
        <!--PANEL DE DIRECCIONES-->
        <div class="grilla5 derecha">
            <div class="grilla10 titulo"><h3>Direccion</h3></div>
            <div class="grilla10">Calle</div>
            <div class="grilla10"> <input type="text"></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Numero</div>
            <div class="grilla10"> <input type="number"></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Depto</div>
            <div class="grilla10"> <input type="text"></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Regi&oacute;n</div>
            <div class="grilla10"> <select><option>Seleccione Regi&oacute;n</option></select></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Provincia</div>
            <div class="grilla10"> <select></select></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Comuna</div>
            <div class="grilla10"><select></select></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10">Sector</div>
            <div class="grilla10"><input type="text"></div>
            <div class="grilla10 error">aquierror</div>
            <div class="grilla10"></div>
        </div>
        <div class="grilla10 titulo"><h3>Datos De Contacto</h3></div>
        <div class="grilla5 izquierda">
            <div class="grilla10">Tel&eacute;fono Fijo</div>
            <div class="grilla10"><input type="number"></div>
            <div class="grilla10 error">aquierror</div>
        </div>
        <div class="grilla5 derecha">
            <div class="grilla10">Tel&eacute;fono Celular</div>
            <div class="grilla10"><input type="number"></div>
            <div class="grilla10 error">aquierror</div>
        </div>
    </div>
</form>

