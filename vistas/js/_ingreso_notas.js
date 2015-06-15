jQuery(document).ready(function(){
    jQuery("#contenedor_selectores").sticky({topSpacing: 0});
    var run_profesor = jQuery("#run_profesor");
    var rbd_establecimiento = jQuery("#rbd_establecimiento");
    var id_curso = jQuery("#id_curso");
    var id_asignatura = jQuery("#id_asignatura");
    var formulario_notas = jQuery("#formulario_notas");
    var cartola = jQuery("#cartola");
    var cartola2 = cartola.clone();


    get_establecimientos(run_profesor.val());

    rbd_establecimiento.change(function(){
        del_selector(id_curso, "Seleccione Un Curso");
        del_selector(id_asignatura, "Seleccione Una Asignatura");
        jQuery("#cartola").remove();


        if(rbd_establecimiento.val() == "0"){
            id_curso.prop("disabled", true);
            return null;
        }
        cartola2.clone().insertAfter("#run_profesor");
        id_curso.prop("disabled", false);
        id_asignatura.prop("disabled", true);
        get_cursos(run_profesor.val(), rbd_establecimiento.val());
    });

    id_curso.change(function(){
        jQuery("#cartola").remove();
        del_selector(id_asignatura, "Seleccione Una Asignatura");

        if(id_curso.val() == "0"){
            id_asignatura.prop("disabled", true);
            return null;
        }
        cartola2.clone().insertAfter("#run_profesor");
        jQuery("#cartola").attr("style","display: table !important");
        id_asignatura.prop("disabled", false);
        get_alumnos(run_profesor.val(), id_curso.val());

    });

    id_asignatura.change(function(){
        jQuery(".fecha").remove();
        jQuery(".notas").empty();
        jQuery(".boton").remove();
        jQuery(".promedio")
            .find("p")
            .text("S/N")
            .removeClass("rojo azul")
        ;
        if(id_asignatura.val() == "0"){return null; }
        get_evaluaciones(id_curso.val(), id_asignatura.val())
    });

    formulario_notas.on("keyup","input",function(e){
        var nota = $(this);
        var regExp = new RegExp("(^[1-7]{1}$)|(^[1-7]{1}\\.$)");
        if(!regExp.test(nota.val())){
            var regExp = new RegExp("^([1-7]{1}\\.[0])|([1-6]{1}\\.[0-9]{1})$");
            if(!regExp.test(nota.val())){
                nota.val(nota.val().substring(0, nota.val().length - 1));
                nota.attr("data-nota","del-nota");
            }else{
                nota.attr("data-nota","ins-nota");
            }
        }else{
            nota.attr("data-nota","ins-nota");
        }
        //if(nota.val() == ""){nota.attr("data-nota","del-nota")}else{nota.removeAttr("data-nota")}
    });

    formulario_notas.on("focusout","input",function(e){
        var nota = $(this);
        var regExp = new RegExp("(^[1-7]\\.$)");
        if(regExp.test(nota.val())){
            nota.val(nota.val().substring(0, nota.val().length - 1)+".0")
        }
        var regExp = new RegExp("(^[1-7]$)");
        if(regExp.test(nota.val())){
            nota.val(nota.val()+".0")
        }

        if(nota.val() != ""){
            if(nota.val() < 4){
                var clase = "rojo";
            }else{
                var clase = "azul";
            }
        }

        jQuery(nota)
            .removeClass("rojo azul")
            .addClass(clase)
        ;

        var run_alumno = jQuery(this).parents(".registro").attr("data-run_alumno");
        var notas_alumno_inputs = jQuery(".notas[data-run_alumno="+run_alumno+"]").find("input");
        var notas_alumno = [];
        jQuery.each(notas_alumno_inputs, function(i,v){
            if(jQuery(notas_alumno_inputs[i]).val() != ""){
                notas_alumno.push({
                    nota: jQuery(notas_alumno_inputs[i]).val(),
                    coeficiente: jQuery(notas_alumno_inputs[i]).attr("data-coeficiente")
                });
            }
        });
        if(notas_alumno.length > 0){
            //console.log(notas_alumno);
            var sumatoria_total = 0;
            var sumatoria_coeficientes = 0;
            jQuery.each(notas_alumno, function(i, v){
                sumatoria_total += (notas_alumno[i].nota*notas_alumno[i].coeficiente);
                sumatoria_coeficientes += parseInt(notas_alumno[i].coeficiente);
            })
;
            var promedio = sumatoria_total/sumatoria_coeficientes;
            var promedio_formateado = promedio.toFixed(1);
            var clase = "";
            if(promedio_formateado < 4){
                var clase = "rojo";
            }else{
                var clase = "azul";
            }
            jQuery(".promedio[data-run_alumno="+run_alumno+"]")
                .find("p")
                .text(promedio_formateado)
                .removeClass("rojo azul")
                .addClass(clase)
            ;
        }else{
            var clase = "";
            promedio_formateado = "S/N";
            jQuery(".promedio[data-run_alumno="+run_alumno+"]")
                .find("p")
                .text(promedio_formateado)
                .removeClass("rojo azul")
                .addClass(clase)
        }
    });

    formulario_notas.on("click",".boton", function(e){
        var id_evaluacion = jQuery(this).attr("data-id_evaluacion");
        var notasArray = jQuery("input[data-id_evaluacion="+id_evaluacion+"]");
        jQuery.each(notasArray, function(i, v){
            if(jQuery(notasArray[i]).val() != ""){
                jQuery(notasArray[i])
                    .val("")
                    .attr("data-nota","del_nota")
                ;
            }
        });

        jQuery("#formulario_notas").find("input").focusout();
    });

    formulario_notas.submit(function(){
        event.preventDefault();
        var registros = jQuery(this).find(".registro");
        var alumnos = [];
        jQuery.each(registros, function(i, value){
            var notas= [];
            var notasArray = jQuery(registros[i]).find("input");
            jQuery.each(notasArray, function(i, value){
                if(jQuery(notasArray[i]).attr("data-nota")) {
                    notas.push({
                        id_evaluacion: jQuery(notasArray[i]).attr("data-id_evaluacion"),
                        nota: jQuery(notasArray[i]).val()
                    });
                }
            });

            if(notas.length > 0) {
                alumnos.push({
                    run_alumno: jQuery(registros[i]).attr("data-run_alumno"),
                    notas: notas
                });
            }
        });

        jQuery.ajax({
            method: "POST",
            url: "/_code/controladores/nota.controlador.php",
            data: {id_funcion: "1", alumnos: alumnos}
        })
            .done(function(data){
                console.log(data);
            })
            .fail(function(){
                alert("ERROR");
            })
        ;
    });
});

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
    console.log("cargando cursos");
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

function get_alumnos(run_profesor, id_curso){
    console.log("Cargando alumnos...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/alumno.controlador.php",
        data: {id_funcion: "4", id_curso: id_curso},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            //console.log(data.length);
            if(data.length < 1){
                mostrar_dialogo("2", "Este curso no tiene alumnos asociados. Por favor contacta al administrador para obtener más información.");
                return null;
            }
            var ultimo = "";
            jQuery.each(data, function(i, value){
                if((data.length-1) == 1 || (data.length-1) == i){
                    ultimo = "ultimo"
                }
                jQuery("#cartola").find(".contenedor_registros")
                    .append(
                        jQuery("<div></div>")
                            .addClass("registro")
                            .attr("data-run_alumno", data[i].run_alumno)
                            .append(
                                jQuery("<div></div>")
                                    .addClass("alumno")
                                    .addClass(ultimo)
                                    .text(data[i].apellido1+" "+data[i].apellido2+" "+data[i].nombre1+" "+ data[i].nombre2)
                            )
                            .append(
                                jQuery("<div></div>")
                                    .addClass("notas")
                                    .addClass(ultimo)
                                    .attr("data-run_alumno",data[i].run_alumno)
                            )
                            .append(
                                jQuery("<div></div>")
                                    .addClass("promedio")
                                    .addClass(ultimo)
                                    .attr("data-run_alumno",data[i].run_alumno)
                                    .append(
                                        jQuery("<div></div>")
                                            .addClass("header")
                                            .text("Promedio")
                                    )
                                    .append(
                                        jQuery("<p></p>")
                                            .text("S/N")
                                    )
                            )
                    )
                ;
            });
            get_asignaturas(run_profesor, id_curso);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
        })
    ;
}

function get_evaluaciones(id_curso, id_asignatura){
    console.log("Cargando evaluaciones...");
    var meses = ["","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"]
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/evaluacion.controlador.php",
        data: {id_funcion: "6", id_curso: id_curso, id_asignatura: id_asignatura},
        beforeSend: function(){

        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            var clase = ""
            jQuery(".empty")
                .css({
                    "border-right": "1px solid transparent",
                    "border-top-right-radius": "10px"
                })
            jQuery.each(data, function(i, value){
                if((data.length-1) == 0 || (data.length-1) == i){
                    clase = "ultima"
                }
                if(i == 0){
                    var  clase = "primera"
                }
                jQuery(".header_fechas")
                    .append(
                        jQuery("<div></div>")
                            .addClass("fecha")
                            .addClass(clase)
                            .text(data[i].dia_mes+" - "+meses[data[i].id_mes])
                    )
                ;
                jQuery(".booter_fechas")
                    .append(
                    jQuery("<div></div>")
                        .addClass("boton")
                        .addClass(clase)
                        .text("Limpiar")
                        .attr("data-id_evaluacion",data[i].id_evaluacion)

                )

                ;
                jQuery(".notas")
                    .append(
                        jQuery("<div></div>")
                            .addClass("casillero")
                            .addClass(clase)
                            .append(
                            jQuery("<div></div>")
                                .addClass("coeficiente")
                                .text("C"+data[i].coeficiente)

                            )
                            .append(
                                jQuery("<input>")
                                    .attr({
                                        type: "text",
                                        maxLength: "3"
                                    })
                                    .prop("readonly",data[i].readonly)
                                    .attr({
                                        "data-id_evaluacion": data[i].id_evaluacion,
                                        "data-coeficiente": data[i].coeficiente
                                    })
                                    .attr("placeholder","S/N")

                            )
                    )
                ;
            });
            setTimeout(function(){get_notas(id_curso, id_asignatura)},500);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){

        })
    ;
}

function get_notas(id_curso, id_asignatura){
    console.log("Cargando notas...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/nota.controlador.php",
        data: {id_funcion: "2", id_curso: id_curso, id_asignatura: id_asignatura},
        beforeSend: function(){

        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, value){
                if(data[i].valor != ""){
                    if(data[i].valor < 4){
                        var clase = "rojo";
                    }else{
                        var clase = "azul";
                    }
                    var data_nota = "con-nota";
                }else{
                    var data_nota = "";
                }
                var notas_array = jQuery(".notas[data-run_alumno="+data[i].run_alumno+"]");
                var nota = jQuery(notas_array).find(("input[data-id_evaluacion="+data[i].id_evaluacion+"]"));
                nota
                    .val(data[i].valor)
                    .removeClass("rojo azul")
                    .addClass(clase)
                ;
            });
            jQuery("#formulario_notas").find("input").focusout();
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){

        })
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
            break;
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