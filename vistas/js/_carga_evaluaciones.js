jQuery(document).ready(function(){
    var contenedor_formulario = jQuery("#contenedor_formulario");
    contenedor_formulario.dialog({autoOpen: false});
    jQuery("#contenedor_selectores").sticky({topSpacing: 0});
    var contenedor_calendario = jQuery("#contenedor_calendario");
    var calendario = jQuery("#calendario");
    var calendario2 = calendario.clone();
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var id_curso = jQuery("#id_curso");
    var id_asignatura = jQuery("#id_asignatura");
    var id_clase = jQuery("#id_clase");
    var bloqueos = jQuery(".dia").find(".bloqueo");
    var run_profesor = jQuery("#run_profesor").val();
    var meses = ["","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    var dias_semana = ["", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes"];
    var hoy = new Date();
    var mes_actual = (hoy.getMonth() + 1);
    var ano_actual = hoy.getFullYear();

    cargar_botones(meses, mes_actual);
    get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
    get_establecimientos(run_profesor);



    jQuery("#boton_atras").click(function(){
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);

        del_selector(id_clase, "Seleccione Una Clase");

        mes_actual = (mes_actual - 1);
        cargar_botones(meses, mes_actual);

        //console.log(mes_actual+" "+meses[mes_actual]);
        if(mes_actual <=12){jQuery("#boton_siguiente").css("visibility","visible")}
        if(mes_actual <= 3){jQuery("#boton_atras").css("visibility","hidden"); return null}
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        if(id_curso.val() != "0"){get_evaluaciones(id_curso.val(), mes_actual)}
        if(id_asignatura.val() != "0" && id_curso.val() != "0"){get_dias(run_profesor, id_curso.val(), id_asignatura.val())}
    });

    jQuery("#boton_siguiente").click(function(){
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);

        del_selector(id_clase, "Seleccione Una Clase");

        mes_actual = (mes_actual + 1);
        cargar_botones(meses, mes_actual);

        //console.log(mes_actual);
        if(mes_actual >= 3){jQuery("#boton_atras").css("visibility","visible")}
        if(mes_actual >= 12){jQuery("#boton_siguiente").css("visibility","hidden"); return null}
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        if(id_curso.val() != "0"){get_evaluaciones(id_curso.val(), mes_actual)}
        if(id_asignatura.val() != "0" && id_curso.val() != "0"){get_dias(run_profesor, id_curso.val(), id_asignatura.val())}
    });

    rbd_establecimiento.change(function(){
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);

        del_selector(id_curso, "Seleccione Un Curso");
        del_selector(id_asignatura, "Seleccione Una Asignatura");
        del_selector(id_clase, "Seleccione Una Clase");


        if(rbd_establecimiento.val() == "0"){
            id_curso.prop("disabled", true);
            id_asignatura.prop("disabled", true);
            id_clase.prop("disabled", true);
            return null;
        }
        id_curso.prop("disabled", false);
        id_asignatura.prop("disabled", false);
        id_clase.prop("disabled", false);
        get_cursos(run_profesor, rbd_establecimiento.val());
    });

    id_curso.change(function(){
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);

        del_selector(id_asignatura, "Seleccione Una Asignatura");
        del_selector(id_clase, "Seleccione Una Clase");

        if(id_curso.val() == "0"){
            id_asignatura.prop("disabled", true);
            id_clase.prop("disabled", true);
            return null;
        }

        id_asignatura.prop("disabled", false);
        id_clase.prop("disabled", false);

        get_asignaturas(run_profesor, id_curso.val());
        setTimeout(function(){get_evaluaciones(id_curso.val(), mes_actual)},500);
    });

    id_asignatura.change(function(){
        del_selector(id_clase, "Seleccione Una Clase");
        get_dias(run_profesor, id_curso.val(), id_asignatura.val());
    });

    contenedor_calendario.on("click",".dia",function(){
        var dia = jQuery(this);
        if(!dia.attr("data-fecha")){
            mostrar_dialogo("2", "Este día esta fuera del mes actual. Por favor seleccione un día dentro del rango.");
            return null;
        }
        if(dia.hasClass("sin_clases")){
            mostrar_dialogo("2", "Este día no tiene clases asignadas. Por favor seleccione un día que contenga clases.");
            return null;
        }
        var id_mes = dia.attr("data-id_mes");
        var id_dia = dia.attr("data-id_dia");
        var dia_mes = dia.attr("data-dia_mes");
        var fecha = dia.attr("data-fecha");

        jQuery("#fecha").val(fecha);
        jQuery("#fecha_completa").val(dias_semana[id_dia]+" "+dia_mes+" de "+meses[mes_actual]+" ");

        del_selector(id_clase, "Seleccione Una Clase");
        get_clases(run_profesor, id_curso.val(), id_asignatura.val(), id_dia, fecha);


    });

    contenedor_formulario.find("form").submit(function(){
        event.preventDefault();
        var miFormData = new FormData(this);
        miFormData.append("id_funcion", "1");

        var asignatura = jQuery("#id_asignatura").find(":selected");
        var nombre_asignatura = asignatura.text();
        var id_asignatura = asignatura.val();
        var color1 = asignatura.attr("data-color1");
        var color2 = asignatura.attr("data-color2");


        var fecha = jQuery("#fecha").val();
        var dia = jQuery(".dia[data-fecha='"+fecha+"']");

        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/evaluacion.controlador.php",
            data: miFormData,
            contentType: false,
            cache: false,
            processData:false
        })
            .done(function(data){
                //console.log(data);
                var data = jQuery.parseJSON(data);
                switch (data.result){
                    case "3":
                        dia.find(".contenedor_eventos").append(
                            jQuery("<div></div>")
                                .addClass("evento")
                                .text("Prueba de "+nombre_asignatura)
                                .css({
                                    "background-color": color1,
                                    "color": color2
                                })
                        );
                        jQuery("#descripcion").val("");
                        contenedor_formulario.dialog("close");
                        break;
                }


            })
            .fail(function(){
                alert("ERROR")
            })
            .always(function(){

            })
        ;
    });

});

function cargar_botones(meses, mes_actual){
    var mes_anterior = (mes_actual - 1);
    var mes_siguiente = (mes_actual + 1);
    jQuery("#boton_atras").val(meses[mes_anterior]);
    jQuery("#boton_siguiente").val(meses[mes_siguiente]);
    jQuery("#mes_actual").text(meses[mes_actual]);
}

function get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual){
    jQuery("#calendario").remove();
    contenedor_calendario.append(calendario2.clone());
    console.log("Cargando calendario...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/calendario.controlador.php",
        data: {id_funcion: "1", mes_actual: mes_actual, ano_actual: ano_actual}
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            var dias = jQuery(".mes").find(".dia");
            dias.find(".fecha").html("&nbsp;");
            dias.attr("data-fecha","");
            var j = 0;
            for (var i = 0; i < dias.length; i++){
                var dia = jQuery(dias[i]);
                if(dia.attr("data-id_dia") == data[j].id_dia){
                    dia.find(".fecha").text(data[j].dia_mes);
                    dia.attr({
                        "data-id_mes": data[j].id_mes,
                        "data-dia_mes":data[j].dia_mes,
                        "data-fecha": data[j].fecha
                    });
                    j++;
                }
                if(j >= data.length){break;}
            }
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){

        })
    ;
}

function get_establecimientos(run_profesor){
    console.log("Cargando establecimientos...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/establecimiento.controlador.php",
        data: {id_funcion: "2", run_profesor: run_profesor},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, value){
                jQuery("#rbd_establecimiento")
                    .append(
                    jQuery("<option></option>")
                        .val(data[i].rbd_establecimiento)
                        .text(data[i].nombre)
                )
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_cursos(run_profesor, rbd_establecimiento){
    console.log("cargando cursos")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.controlador.php",
        data: {id_funcion: "3", run_profesor: run_profesor, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, value){
                jQuery("#id_curso")
                    .append(
                    jQuery("<option></option>")
                        .val(data[i].id_curso)
                        .text(data[i].id_grado+" "+data[i].nombre_curso+" "+data[i].grupo)
                )
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_asignaturas(run_profesor, id_curso){
    console.log("Cargando asignaturas...")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/asignatura.controlador.php",
        data: {id_funcion: "2", run_profesor: run_profesor, id_curso: id_curso},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, value){
                jQuery("#id_asignatura")
                    .append(
                    jQuery("<option></option>")
                        .val(data[i].id_asignatura)
                        .text(data[i].nombre)
                        .attr({
                            "data-color1": data[i].color1,
                            "data-color2": data[i].color2
                        })
                )
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_clases(run_profesor, id_curso, id_asignatura, id_dia, fecha){
    console.log("Cargando clases...")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/clase.controlador.php",
        data: {id_funcion: "3", run_profesor: run_profesor, id_curso: id_curso, id_asignatura: id_asignatura, id_dia: id_dia, fecha: fecha},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.length == 0){
                mostrar_dialogo("2", "Este día no cuenta con más clases para esta asignatura. Por favor seleccione un día diferente o comuníquese con el administrador para agregar más clases a este día.");
                return null;
            }
            jQuery.each(data, function(i, value){
                jQuery("#id_clase")
                    .append(
                    jQuery("<option></option>")
                        .val(data[i].id_clase)
                        .text(data[i].nombre_dia+" "+data[i].hora_inicio)
                )
                    .prop("disabled", false)
            });

            jQuery("#contenedor_formulario").dialog({
                modal: true,
                width: 600,
                title: "Datos De Evaluación"

            }).dialog("open");
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_dias(run_profesor, id_curso, id_asignatura){
    jQuery(".dia").find(".bloqueo").css({"display": "block"});
    console.log("Cargando dias de clases...")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/dia.controlador.php",
        data: {id_funcion: "1", run_profesor: run_profesor, id_curso: id_curso, id_asignatura: id_asignatura},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            var dias = jQuery(".mes").find(".dia");
            dias.removeClass("con_clases sin_clases")
                .addClass("sin_clases")
            jQuery.each(data, function(i, value){
                var con_clases = jQuery("[data-id_dia='"+data[i].id_dia+"']");

                con_clases
                    .removeClass("sin_clases")
                    .addClass("con_clases")
                ;
                con_clases.find(".bloqueo").css({"display": "none"})
            });

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_evaluaciones(id_curso, mes_actual){
    console.log("Cargando evaluaciones...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/evaluacion.controlador.php",
        data: {id_funcion: "2", id_curso: id_curso, mes_actual: mes_actual},
        beforeSend: function(){

        }
    })
        .done(function(data){
            //console.log(data);

            var data = jQuery.parseJSON(data);

            jQuery.each(data, function(i, value){
                var fecha = data[i].fecha;
                var dia = jQuery(".dia[data-fecha='"+fecha+"']");
                dia.find(".contenedor_eventos").append(
                    jQuery("<div></div>")
                        .addClass("evento")
                        .text("Prueba de "+data[i].nombre_asignatura)
                        .css({
                            "background-color": data[i].color1,
                            "color": data[i].color2
                        })
                );
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){

        })
    ;
}

function del_selector(selector, msg){
    selector
        .empty()
        .append(
            jQuery("<option></option>")
                .val("0")
                .text(msg)
        )
        .prop("disabled",true)
    ;
}

function mostrar_dialogo(val,msg){
    var clase = "";
    var titulo = "Mensaje";
    var dialogo = jQuery("#dialog");

    switch (val){
        case "1":
            clase = "error-ui";
            titulo = "Error Fatal";
            dialogo.dialog({
                autoOpen: false,
                buttons:[
                    {
                        text: "Intentar Nuevamente",
                        click: function(){
                            jQuery("#dialog").dialog("close");
                        }
                    }
                ]
            });
            break;

        case "2":
            clase = "peligro-ui";
            titulo = "Operación Interrumpida";
            dialogo.dialog({
                autoOpen: false,
                buttons:[
                    {
                        text: "Aceptar",
                        click: function(){
                            jQuery("#dialog").dialog("close");
                        }
                    }
                ]
            });
            break;

        case "3":
            clase = "exito-ui";
            titulo = "Operación exitosa";

            dialogo.dialog({
                autoOpen: false,
                buttons:[]
            });
    }



    dialogo
        .html("<p>"+msg+"</p>")
        .dialog({
            modal:true,
            autoOpen: false,
            dialogClass: clase,
            title: titulo,
            width: "auto"
        })
        .dialog("open");
}
