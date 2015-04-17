<?php echo __FILE__."<br/>"; ?>
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
    	<div class="grilla10 titulo"><h3>Datos Del Curso</h3></div>
        <div class="grilla10">Seleccionar Establecimiento</div>
        <div class="grilla10"><select></select></div
        ><div class="grilla10 error">aquio error</div>
        <div class="grilla10">Seleccionar Tipo De Ense&ntilde;anza</div>
        <div class="grilla10"><select></select></div
        ><div class="grilla10 error">aquio error</div>
        <div class="grilla10">Seleccionar Grado</div>
        <div class="grilla10"><select></select></div
        ><div class="grilla10 error">aquio error</div>
        <div class="grilla10">Seleccionar Grupo</div>
        <div class="grilla10"><select></select></div>
        <div class="grilla10 error">aquio error</div>
 	</div>
</form>
 