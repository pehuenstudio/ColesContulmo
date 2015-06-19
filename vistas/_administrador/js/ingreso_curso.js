jQuery(document).ready(function(){
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var id_tipo_ensenanza = jQuery("#id_tipo_ensenanza");
    var periodo_actual_rapido = jQuery("#periodo_actual_rapido");
    var periodo_futuro_rapido = jQuery("#periodo_futuro_rapido");
    var contenedor_cursos_izq = jQuery("#contenedor_cursos_izq");
    var contenedor_cursos_der = jQuery("#contenedor_cursos_der");
    var pasar_rapido = jQuery("#pasar_rapido");
    var ingresar_rapido = jQuery("#ingresar_rapido");
    var ingresar_nuevo = jQuery("#ingresar_nuevo");
    var botones_izq = jQuery(".contenedor_botones.izq").find("button");

    get_tipos_ensenanza(rbd_establecimiento.val());


    contenedor_cursos_izq.on("click", ".curso", function(){
        var selected = jQuery(this).attr("data-selected");
        switch (selected){
            case "no-selected":
                jQuery(this)
                    .removeClass("selected")
                    .addClass("selected")
                    .attr("data-selected","selected")
                ;
                break;
            case "selected":
                jQuery(this)
                    .removeClass("selected")
                    .attr("data-selected","no-selected")
                ;
                break;
        }


        ;
    });

    pasar_rapido.click(function(){
        var cursos_izq = jQuery(contenedor_cursos_izq).find(".curso[data-selected=selected]");
        jQuery.each(cursos_izq, function(i,v){
            var cursos_der = jQuery(contenedor_cursos_der)
                .find(".curso" +
                    "[data-id_grado="+jQuery(cursos_izq[i]).attr("data-id_grado")+"]" +
                    "[data-id_tipo_ensenanza="+jQuery(cursos_izq[i]).attr("data-id_tipo_ensenanza")+"]" +
                    "[data-id_ciclo="+jQuery(cursos_izq[i]).attr("data-id_ciclo")+"]" +
                    "[data-grupo="+jQuery(cursos_izq[i]).attr("data-grupo")+"]");
            if(cursos_der.length < 1){

                contenedor_cursos_der
                    .append(
                        jQuery("<div></div>")
                            .text(jQuery(jQuery(cursos_izq[i])).text())
                            .addClass("curso")
                            .attr({
                                "data-selected": "no-selected",
                                "data-id_grado": jQuery(cursos_izq[i]).attr("data-id_grado"),
                                "data-id_tipo_ensenanza": jQuery(cursos_izq[i]).attr("data-id_tipo_ensenanza"),
                                "data-id_ciclo": jQuery(cursos_izq[i]).attr("data-id_ciclo"),
                                "data-grupo": jQuery(cursos_izq[i]).attr("data-grupo")
                            })
                    )

                ;
            }
        });

        jQuery("body, html").animate({
            scrollTop: jQuery(jQuery("#contenedor_cursos_der_header")).offset().top
        }, 200);
    });

    periodo_actual_rapido.change(function(){
        contenedor_cursos_izq.empty();
        if(periodo_actual_rapido.val == "0"){
            return null
        }
        get_cursos(rbd_establecimiento.val(), periodo_actual_rapido.val(), contenedor_cursos_izq, contenedor_cursos_der);
    });

    periodo_futuro_rapido.change(function(){
        contenedor_cursos_der.empty();
        if(periodo_futuro_rapido.val == "0"){
            return null
        }
        get_cursos(rbd_establecimiento.val(), periodo_futuro_rapido.val(), contenedor_cursos_der, contenedor_cursos_izq);
    });

    ingresar_rapido.click(function(){
        if(periodo_futuro_rapido.val() == "0"){
            return null;
        }
        if(contenedor_cursos_der.find(".curso").length == 0){
            return null;
        }

        var data = [];
        var cursos = contenedor_cursos_der.find(".curso");
        jQuery.each(cursos, function(i, v){
            data.push({
                "id_grado": jQuery(cursos[i]).attr("data-id_grado"),
                "id_tipo_ensenanza": jQuery(cursos[i]).attr("data-id_tipo_ensenanza"),
                "id_ciclo": jQuery(cursos[i]).attr("data-id_ciclo"),
                "grupo": jQuery(cursos[i]).attr("data-grupo")
            });
        });

        console.log("Ingresando cursos...");
        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/curso.controlador.php",
            data: {id_funcion: "5", rbd_establecimiento: rbd_establecimiento.val(), periodo: periodo_futuro_rapido.val(), data: data}
        })
            .done(function(data){
                console.log(data);
                /*var data = jQuery.parseJSON(data);
                if(data.result == false){
                    return null;
                }*/


            })
            .fail(function(){
                alert("ERROR");
            })
            .always(function(){
                setTimeout(function(){load_off();},500);
            })
        ;
    });

    ingresar_nuevo.click(function(){
        event.preventDefault();
        if(!validar()){
            return null;
        }

        var form = document.getElementById("formulario_curso");
        var miFormData = new FormData(form);
        miFormData.append("id_funcion", "6");
        miFormData.append("rbd_establecimiento", jQuery("#rbd_establecimiento").val());

        console.log("Ingresando cursos...");
        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/curso.controlador.php",
            data: miFormData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                load_on("Actualizando horario...","#contenedor_nuevo");
            }
        })
            .done(function(data){
                console.log(data);
                /*var data = jQuery.parseJSON(data);
                 if(data.result == false){
                 return null;
                 }*/


            })
            .fail(function(){
                alert("ERROR");
            })
            .always(function(){
                setTimeout(function(){load_off();},500);
            })
        ;
    });

    botones_izq.click(function(){
        var boton = jQuery(this);
        boton.removeClass("selected").addClass("selected");
        boton.siblings().removeClass("selected");
        console.log(boton.attr("data-rol"));
        switch (boton.attr("data-rol")){
            case "limpiar":
                jQuery(contenedor_cursos_izq).find(".curso").removeClass("selected").attr("data-selected", "no-selected");
                break;
            case "seleccionar":
                jQuery(contenedor_cursos_izq).find(".curso").removeClass("selected").addClass("selected").attr("data-selected", "selected");
                break;
        }
    });

    id_tipo_ensenanza.change(function(){
        if(id_tipo_ensenanza.val() == "0"){
            return null;
        }

        get_grados(rbd_establecimiento.val(), id_tipo_ensenanza.val());
    });

});

function get_cursos(rbd_establecimiento, periodo, contenedor1, contenedor2){
    console.log("Cargando cursos...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.controlador.php",
        data: {id_funcion: "4", rbd_establecimiento: rbd_establecimiento, periodo_actual: periodo}
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function (i, value){
                contenedor1
                    .append(
                    jQuery("<div></div>")
                        .text(data[i].nombre_grado+" "+data[i].grupo)
                        .addClass("curso")
                        .attr({
                            "data-selected": "no-selected",
                            "data-id_grado": data[i].id_grado,
                            "data-id_tipo_ensenanza": data[i].id_tipo_ensenanza,
                            "data-id_ciclo": data[i].id_ciclo,
                            "data-grupo": data[i].grupo
                        })
                    )

            });

            if(contenedor1.height() > contenedor2.height()){
                contenedor2.css({
                    "min-height": contenedor1.height()+10,
                    "height": "auto"
                });
            }else{
                contenedor1.css({
                    "min-height": contenedor2.height()+10,
                    "height": "auto"
                });
            }

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_tipos_ensenanza(rbd_establecimiento){
    console.log("Cargando tipos de enseñanza...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/tipo_ensenanza.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_off();
            load_on("Cargando tipos de enseñanza...", "#contenedor_nuevo");
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.length < 1){
                return null;
            }
            jQuery.each(data, function(i, value){
                jQuery("#id_tipo_ensenanza")
                    .append(jQuery("<option></option>")
                        .val(data[i].id_tipo_ensenanza)
                        .text(data[i].nombre))
                ;

            });
            get_ciclos(rbd_establecimiento);

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            load_off();
        })
    ;
}

function get_grados(rbd_establecimiento, id_tipo_ensenanza){
    console.log("Invocando grados...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/grado.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento, id_tipo_ensenanza: id_tipo_ensenanza},
        beforeSend: function(){
            load_off();
            load_on("Cargando grados...", "#contenedor_nuevo");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.length < 1){
                return null;
            }
            jQuery.each(data, function(i, value){
                jQuery("#id_grado")
                    .append(jQuery("<option></option>")
                        .val(data[i].id_grado)
                        .text(data[i].nombre))
                ;
            });

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            load_off();
        })
    ;
}

function get_ciclos(rbd_establecimiento){
    console.log("Cargando ciclos...")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/ciclo.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_off();
            load_on("Cargando ciclos...", "#contenedor_nuevo");
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function (i, value){
                jQuery("#id_ciclo")
                    .append(
                        jQuery("<option></option>")
                            .val(data[i].id_ciclo)
                            .text(data[i].nombre))
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            load_off();
        })
    ;
}

function validar(){
    var result = true;
    if(!validar_select(jQuery("#id_tipo_ensenanza"), "Debe seleccionar un tipo de enseñanza")){result = false}
    if(!validar_select(jQuery("#id_grado"), "Debe seleccionar un grado")){result = false}
    if(!validar_numeroMinMax(jQuery("#id_ciclo"),1,2, "Debe seleccionar un ciclo")){result = false}
    if(!validar_select(jQuery("#grupo"), "Debe seleccionar un grupo")){result = false}
    if(!validar_select(jQuery("#periodo_futuro"), "Debe seleccionar un perido")){result = false}
    return result;
}