jQuery(document).ready(function(){
    jQuery("#contenedor_formulario_ins").dialog({autoOpen: false});
    jQuery("#contenedor_formulario_upd").dialog({autoOpen: false});
    jQuery("#contenedor_selectores").sticky({topSpacing: 0});
    var contenedor_calendario = jQuery("#contenedor_calendario");
    var calendario = jQuery("#calendario");
    var calendario2 = calendario.clone();
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var id_curso = jQuery("#id_curso");
    var id_asignatura = jQuery("#id_asignatura");
    var id_clase_ins = jQuery("#id_clase_ins");
    var bloqueos = jQuery(".dia").find(".bloqueo");
    var coeficiente_ins = jQuery("#coeficiente_ins");
    var run_profesor_ins = jQuery("#run_profesor_ins");
    var boton_upd = jQuery("#boton_upd");
    var boton_del = jQuery("#boton_del");
    var meses = ["","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    var dias_semana = ["", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes"];
    var hoy = new Date();
    var mes_actual = (hoy.getMonth() + 1);
    var ano_actual = hoy.getFullYear();

    if(mes_actual == 1){
        ano_actual -= 1;
        mes_actual = 3;
    }
    if(mes_actual == 2){
        mes_actual = 3;
    }


    if (mes_actual <= 3) {
        jQuery("#boton_atras").css("visibility", "hidden");
    }

    cargar_botones(meses, mes_actual, ano_actual);
    get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
    get_establecimientos(run_profesor_ins.val());



    jQuery("#boton_atras").click(function(){
        //get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        del_selector(id_clase_ins, "Seleccione Una Clase");

        mes_actual = (mes_actual - 1);
        cargar_botones(meses, mes_actual, ano_actual);

        console.log(mes_actual+" "+meses[mes_actual]);
        if(mes_actual <=12){jQuery("#boton_siguiente").css("visibility","visible")}
        if(mes_actual <= 3){jQuery("#boton_atras").css("visibility","hidden")}
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        if(id_curso.val() != "0"){get_evaluaciones(run_profesor_ins.val(), id_curso.val(), mes_actual)}
        if(id_asignatura.val() != "0" && id_curso.val() != "0"){get_dias(run_profesor_ins.val(), id_curso.val(), id_asignatura.val())}
    });

    jQuery("#boton_siguiente").click(function(){
        //get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        del_selector(id_clase_ins, "Seleccione Una Clase");

        mes_actual = (mes_actual + 1);
        cargar_botones(meses, mes_actual, ano_actual);

        console.log(mes_actual);
        if(mes_actual >= 3){jQuery("#boton_atras").css("visibility","visible")}
        if(mes_actual >= 12){jQuery("#boton_siguiente").css("visibility","hidden")}
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        if(id_curso.val() != "0"){get_evaluaciones(run_profesor_ins.val(), id_curso.val(), mes_actual)}
        if(id_asignatura.val() != "0" && id_curso.val() != "0"){get_dias(run_profesor_ins.val(), id_curso.val(), id_asignatura.val())}
    });

    rbd_establecimiento.change(function(){
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        del_selector(id_curso, "Seleccione Un Curso");
        del_selector(id_asignatura, "Seleccione Una Asignatura");
        del_selector(id_clase_ins, "Seleccione Una Clase");


        if(rbd_establecimiento.val() == "0"){
            id_curso.prop("disabled", true);
            return null;
        }
        id_curso.prop("disabled", false);
        id_asignatura.prop("disabled", true);
        id_clase_ins.prop("disabled", true);
        get_cursos(run_profesor_ins.val(), rbd_establecimiento.val());
    });

    id_curso.change(function(){
        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
        del_selector(id_asignatura, "Seleccione Una Asignatura");
        del_selector(id_clase_ins, "Seleccione Una Clase");

        if(id_curso.val() == "0"){
            id_asignatura.prop("disabled", true);
            return null;
        }

        id_asignatura.prop("disabled", false);
        id_clase_ins.prop("disabled", true);

        get_asignaturas(run_profesor_ins.val(), id_curso.val());
        setTimeout(function(){get_evaluaciones(run_profesor_ins.val(), id_curso.val(), mes_actual)},500);
    });

    id_asignatura.change(function(){
        del_selector(id_clase_ins, "Seleccione Una Clase");
        get_dias(run_profesor_ins.val(), id_curso.val(), id_asignatura.val());
    });

    contenedor_calendario.on("click",".dia",function(target){
        var clase = jQuery(event.target).attr("class");
        if(clase != "contenedor_evaluaciones" && clase != "bloqueo"){return null;}
        var dia = jQuery(this);
        if(id_curso.val() == "0"){
            mostrar_dialogo("2", "Para ingresar una nota es necesario seleccionar establecimiento, curso y una asignatura.");
            return null;
        }
        if(id_asignatura.val() == "0"){
            mostrar_dialogo("2", "Para ingresar una nota es necesario seleccionar establecimiento, curso y una asignatura.");
            return null;
        }
        if(rbd_establecimiento.val() == "0"){
            mostrar_dialogo("2", "Para ingresar una nota es necesario seleccionar establecimiento, curso y una asignatura.");
            return null;
        }
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

        jQuery("#fecha_ins").val(fecha);
        jQuery("#fecha_completa_ins").text(dias_semana[id_dia]+" "+dia_mes+" de "+meses[mes_actual]+" ");

        del_selector(id_clase_ins, "Seleccione Una Clase");
        get_clases(run_profesor_ins.val(), id_curso.val(), id_asignatura.val(), id_dia, fecha);


    });

    contenedor_calendario.on("click",".evaluacion",function(target){
        var evaluacion = jQuery(event.target).parent();
        var id_evaluacion = evaluacion.attr("data-id_evaluacion");
        if(!id_evaluacion){return null}
        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/evaluacion.controlador.php",
            data: {id_funcion: "3", id_evaluacion: id_evaluacion},
            beforeSend: function(){

            }
        })
            .done(function(data){
                //console.log(data);
                var data = jQuery.parseJSON(data);
                if(data.length < 1){return null}

                jQuery("#id_evaluacion_upd").val(id_evaluacion);
                jQuery("#fecha_completa_upd").text(data.dia_mes+" de "+meses[data.id_mes]);
                jQuery("#horario_upd").val(dias_semana[data.id_dia]+" "+data.horario);
                jQuery("#coeficiente_upd").val(data.coeficiente);
                jQuery("#descripcion_upd").val(data.descripcion);
                jQuery("#contenedor_formulario_upd").dialog({
                    modal: true,
                    width: 600,
                    title: "Actualización De Evaluación"

                }).dialog("open");
            })
            .fail(function(){
                alert("ERROR");
            })
            .always(function(){

            })
        ;
    });

    jQuery("#formulario_ins").submit(function(){
        console.log("Validando ingreso evaluacion...")
        event.preventDefault();
        if(!validar_formulario_ins()){return null}
        var miFormData = new FormData(this);
        miFormData.append("id_funcion", "1");

        var asignatura = jQuery("#id_asignatura").find(":selected");
        var nombre_asignatura = asignatura.text();
        var id_asignatura = asignatura.val();
        var color1 = asignatura.attr("data-color1");
        var color2 = asignatura.attr("data-color2");

        var fecha_ins = jQuery("#fecha_ins").val();
        var dia = jQuery(".dia[data-fecha='"+fecha_ins+"']");

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
                        dia.find(".contenedor_evaluaciones").append(
                            jQuery("<div></div>")
                                .addClass("evaluacion")
                                .attr("data-id_evaluacion", data.id_evaluacion)
                                .append(
                                    jQuery("<div></div>")
                                        .addClass("asignatura")
                                        .text("Prueba de "+nombre_asignatura)
                                        .css({
                                            "background-color": color1,
                                            "color": color2
                                        })
                                )
                                .append(
                                    jQuery("<div></div>")
                                        .addClass("coeficiente")
                                        .text("C"+coeficiente_ins.val())
                                )

                        );
                        jQuery("#descripcion_ins").val("");
                        jQuery("#contenedor_formulario_ins").dialog("close");
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

    boton_upd.click(function(){
        event.preventDefault();
        if(!validar_formulario_upd()){return null;}
        var formulario_upd = document.getElementById("formulario_upd");
        var miFormData = new FormData(formulario_upd);
        miFormData.append("id_funcion", "4");

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
                    case "2":
                        mostrar_dialogo("2", "La fecha de esta evaluación es más antigua que el presente día, por tanto no puede ser modificada.");
                        return null;
                        break;
                    case "3":
                        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
                        get_dias(run_profesor_ins.val(), id_curso.val(), id_asignatura.val());
                        get_evaluaciones(run_profesor_ins.val(), id_curso.val(), mes_actual);
                        jQuery("#contenedor_formulario_upd").dialog("close");
                        break;
                }

            })
            .fail(function(){
                alert("ERROR");
            })
            .always(function(){

            })
        ;
    });

    boton_del.click(function(){
        event.preventDefault();
        var id_evaluacion = jQuery("#id_evaluacion_upd").val();

        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/evaluacion.controlador.php",
            data: {id_funcion: "5", id_evaluacion: id_evaluacion}
        })
            .done(function(data){
                //console.log(data);
                var data = jQuery.parseJSON(data);
                switch (data.result){
                    case "21":
                        mostrar_dialogo("2", "Esta evaluación presenta notas ingresadas, por tanto no puede ser eliminada.");
                        return null;
                        break;
                    case "2":
                        mostrar_dialogo("2", "La fecha de esta evaluación es más antigua que el presente día, por tanto no puede ser eliminada.");
                        return null;
                        break;
                    case "3":
                        get_calendario(contenedor_calendario, calendario2, mes_actual, ano_actual);
                        get_dias(run_profesor_ins.val(), id_curso.val(), id_asignatura.val());
                        get_evaluaciones(run_profesor_ins.val(), id_curso.val(), mes_actual);
                        jQuery("#contenedor_formulario_upd").dialog("close");
                        break;
                }

            })
            .fail(function(){
                alert("ERROR");
            })
            .always(function(){

            })
        ;
    });

});

function cargar_botones(meses, mes_actual, ano_actual){
    var mes_anterior = (mes_actual - 1);
    var mes_siguiente = (mes_actual + 1);
    jQuery("#boton_atras").val(meses[mes_anterior]);
    jQuery("#boton_siguiente").val(meses[mes_siguiente]);
    jQuery("#mes_actual").text(meses[mes_actual]+" "+ano_actual);
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
    console.log("Cargando establecimientos..."+run_profesor);
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
            if(data.length < 1){
                mostrar_dialogo("2", "No estas asociado a ningún establecimiento. Por favor contacta al administrador para obtener más información.")
                return null;
            }
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
            if(data.length < 1){
                mostrar_dialogo("2", "No existen clases asociadas tu RUN. Por favor contacta al administrador para obtener mas información.");
                return null;
            }
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
            if(data.length < 1){
                mostrar_dialogo("2", "Este curso no cuenta con ninguna clase asociada. Por favor contacta al administrador para obtener más información.");
                return null;
            }
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
                jQuery("#id_clase_ins")
                    .append(
                    jQuery("<option></option>")
                        .val(data[i].id_clase)
                        .text(data[i].nombre_dia+" "+data[i].hora_inicio)
                )
                    .prop("disabled", false)
            });

            jQuery("#contenedor_formulario_ins").dialog({
                modal: true,
                width: 600,
                title: "Ingreso De Evaluación"

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

function get_evaluaciones(run_profesor, id_curso, mes_actual){
    console.log("Cargando evaluaciones...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/evaluacion.controlador.php",
        data: {id_funcion: "2", run_profesor: run_profesor, id_curso: id_curso, mes_actual: mes_actual},
        beforeSend: function(){

        }
    })
        .done(function(data){
            console.log(data);

            var data = jQuery.parseJSON(data);

            jQuery.each(data, function(i, value){
                var fecha = data[i].fecha;
                var dia = jQuery(".dia[data-fecha='"+fecha+"']");
                dia.find(".contenedor_evaluaciones").append(
                    jQuery("<div></div>")
                        .addClass("evaluacion")
                        .attr("data-id_evaluacion", data[i].id_evaluacion)
                        .append(
                            jQuery("<div></div>")
                                .addClass("asignatura")
                                .text("Prueba de "+data[i].nombre_asignatura)
                                .css({
                                    "background-color": data[i].color1,
                                    "color": data[i].color2
                                })
                        )
                        .append(
                            jQuery("<div></div>")
                                .addClass("coeficiente")
                                .text("C"+data[i].coeficiente)
                        )

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

function validar_formulario_ins(){
    var result = true;
    if(!validar_select(jQuery("#id_clase_ins"),"Debe seleccionar una clase.")){console.log("No selecciono clase"); result = false;}
    if(!validar_select(jQuery("#coeficiente_ins"),"Debe seleccionar un coeficiente.")){console.log("No selecciono coeficiente"); result = false;}
    if(!validar_textareaMinMax(jQuery("#descripcion_ins"),3,200,"Debe ingresar una descripción.")){console.log("No ingreso descripcion"); result = false;}

    return result;
}
function validar_formulario_upd(){
    var result = true;
    if(!validar_select(jQuery("#coeficiente_upd"),"Debe seleccionar un coeficiente.")){console.log("No selecciono coeficiente"); result = false;}
    if(!validar_textareaMinMax(jQuery("#descripcion_upd"),3,200,"Debe ingresar una descripción.")){console.log("No ingreso descripcion"); result = false;}

    return result;
}