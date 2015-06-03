window.onunload = unloadPage("hola");
function unloadPage(txt)
{

    var myEvent = window.attachEvent || window.addEventListener;
    var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compatable

    myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
        var confirmationMessage = 'Si abandona este MÓDULO sin INGRESAR la matricula los datos se perderán.';  // a space
        (e || window.event).returnValue = confirmationMessage;
        return confirmationMessage;
    });
    return false;
}
jQuery(document).ready(function(){
    var contenedor_alumno = "#contenedor_alumno";
    var contenedor_apoderado = "#contenedor_apoderado";
    var contenedor_curso = "#contenedor_curso";


    crear_furmulario();
    get_regiones("#id_region_alumno", contenedor_alumno);
    setTimeout(function(){get_religiones("#id_religion_alumno", contenedor_alumno);},500);
    setTimeout(function(){get_grados_educacionales("#grado_educacional_padre", "#grado_educacional_madre", contenedor_alumno)},1000);

    jQuery("#id_region_alumno").change(function(){
        var id_region = jQuery(this).val();
        var disabled = false;

        if(id_region == "0"){disabled = true;}

        jQuery("#id_provincia_alumno")
            .empty()
            .attr("disabled", disabled)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Provincia"));
        jQuery("#id_comuna_alumno")
            .empty()
            .attr("disabled", true)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Comuna"));
        if(id_region == "0"){return null}

        get_provincias("#id_provincia_alumno", contenedor_alumno, id_region);
        return null;
    });

    jQuery("#id_provincia_alumno").change(function(){
        var id_provincia = jQuery(this).val();
        var disabled = false;

        if(id_provincia == "0"){disabled = true;}

        jQuery("#id_comuna_alumno")
            .empty()
            .attr("disabled", disabled)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Comuna"));
        if(id_provincia == "0"){return null}

        get_comunas("#id_comuna_alumno", contenedor_alumno, id_provincia);
        return null;
    });

    jQuery("#run_alumno").focusout(function(){
        var run_alumno = jQuery(this).val();
        run_alumno = run_alumno.replace(/\./g,"");
        run_alumno = run_alumno.replace(/\-/g,"");

        get_alumno(run_alumno, contenedor_alumno);
    });

    jQuery("#grados_repetidos").find("input:checkbox").click(function(){
        var id_grado = "[data-id_grado="+jQuery(this).attr("data-id_grado")+"]";
        var id_tipo_ensenanza = "[data-id_tipo_ensenanza="+jQuery(this).attr("data-id_tipo_ensenanza")+"]";
        var readonly = false;
        var cantidad = "0";
        if(!jQuery(this).prop("checked")){readonly = true;};
        jQuery("#grados_repetidos_cantidad")
            .find(id_grado+id_tipo_ensenanza)
            .prop("readonly", readonly)
            .val(cantidad)
        ;

    });

    jQuery("#avatar_alumno").change(function(){
        var avatar_preview = jQuery("#avatar_alumno_preview");
        readURL(this, avatar_preview);
    });


    jQuery("#id_region_apoderado").change(function(){
        var id_region = jQuery(this).val();
        var disabled = false;

        if(id_region == "0"){disabled = true;}

        jQuery("#id_provincia_apoderado")
            .empty()
            .attr("disabled", disabled)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Provincia"));
        jQuery("#id_comuna_apoderado")
            .empty()
            .attr("disabled", true)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Comuna"));
        if(id_region == "0"){return null}

        get_provincias("#id_provincia_apoderado", contenedor_alumno, id_region);
        return null;
    });

    jQuery("#id_provincia_apoderado").change(function(){
        var id_provincia = jQuery(this).val();
        var disabled = false;

        if(id_provincia == "0"){disabled = true;}

        jQuery("#id_comuna_apoderado")
            .empty()
            .attr("disabled", disabled)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Comuna"));
        if(id_provincia == "0"){return null}

        get_comunas("#id_comuna_apoderado", contenedor_alumno, id_provincia);
        return null;
    });

    jQuery("#run_apoderado").focusout(function(){
        var run_apoderado = jQuery(this).val();
        get_apoderado(run_apoderado, contenedor_apoderado);
    });

    jQuery("#avatar_apoderado").change(function(){
        var avatar_preview = jQuery("#avatar_apoderado_preview");
        readURL(this, avatar_preview);
    });

    jQuery("#periodo").change(function(){
        var periodo = jQuery(this).val();

        jQuery("#id_tipo_ensenanza").val("0");

        jQuery("#id_grado")
            .empty()
            .attr("disabled", true)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Grado"));

        jQuery("#id_curso")
            .empty()
            .attr("disabled", true)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Grupo Curso"));


    });

    jQuery("#id_tipo_ensenanza").change(function(){
        var rbd_establecimiento = jQuery("#rbd_establecimiento").val();
        var id_tipo_ensenanza = jQuery(this).val();
        var disabled = false;

        if(id_tipo_ensenanza == "0"){disabled = true}

        jQuery("#id_grado")
            .empty()
            .attr("disabled", disabled)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Grado"));

        jQuery("#id_curso")
            .empty()
            .attr("disabled", true)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Grupo Curso"));

        if(id_tipo_ensenanza == "0"){return null}

        get_grados("#id_grado", contenedor_curso, rbd_establecimiento, id_tipo_ensenanza);
    });

    jQuery("#id_grado").change(function(){
        var rbd_establecimiento = jQuery("#rbd_establecimiento").val();
        var id_tipo_ensenanza = jQuery("#id_tipo_ensenanza").val();
        var id_grado = jQuery(this).val();
        var periodo = jQuery("#periodo").find(":selected").val();
        var disabled = false;

        if(id_grado == "0"){disabled = true}

        jQuery("#id_curso")
            .empty()
            .attr("disabled", disabled)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Grupo Curso"));

        if(id_grado == "0"){return null}

        get_cursos("#id_curso", contenedor_curso, rbd_establecimiento, id_tipo_ensenanza, id_grado, periodo);
    });





});

function crear_furmulario(){
    var visto_regiones = 0;
    var visto_tipo_ensenanza = 0;
    var rbd_establecimiento = jQuery("#rbd_establecimiento").val();
    jQuery("#modulo_matriculas").steps({
        headerTag: "h2",
        bodyTag: "section",

        labels:{
            finish: "Ingresar",
            next: "Siguiente",
            previous: "Atras",
            loading: "Procesando ..."
        },
        transitionEffect: jQuery.fn.steps.transitionEffect.slide,
        transitionEffectSpeed: 200,
        onStepChanging: function (event, currentIndex, newIndex) {
            switch (newIndex){
                case 1:
                    if(!validar_alumno()){
                        jQuery("#matricula_formulario").find("input, select").change(function(){
                            validar_alumno();
                        });

                        return false;
                    }
                    break;
                case 2:
                    if(!validar_apoderado()){
                        jQuery("#matricula_formulario").find("input, select").change(function(){
                            validar_apoderado();
                        });
                        return false;
                    }
                    break;
                case 3:
                    if(!validar_curso()){
                        jQuery("#matricula_formulario").find("input, select").change(function(){
                            validar_curso();
                        });

                        return false;
                    }

                    jQuery("#resumen_run_alumno").text(jQuery("#run_alumno").val());
                    jQuery("#resumen_nombre_alumno").text(
                        jQuery("#nombre1_alumno").val()+" "+
                            jQuery("#nombre2_alumno").val()+" "+
                            jQuery("#apellido1_alumno").val()+" "+
                            jQuery("#apellido2_alumno").val()
                    );
                    var depto = "";
                    if(jQuery("#depto_alumno").val() != ""){
                        depto = "Depto "+jQuery("#depto_alumno").val()+" ";
                    }
                    jQuery("#resumen_direccion_alumno").text(
                        jQuery("#calle_alumno").val()+" "+
                            jQuery("#numero_alumno").val()+" "+
                            depto+
                            jQuery("#sector_alumno").val()+", "+
                            jQuery("#id_comuna_alumno").find(":selected").text()
                    );
                    jQuery("#resumen_email_alumno").text(jQuery("#email_alumno").val());

                    jQuery("#resumen_establecimiento_alumno").text(jQuery("#establecimiento_procedencia").val());

                    jQuery("#resumen_run_apoderado").text(jQuery("#run_apoderado").val());
                    jQuery("#resumen_nombre_apoderado").text(
                        jQuery("#nombre1_apoderado").val()+" "+
                            jQuery("#nombre2_apoderado").val()+" "+
                            jQuery("#apellido1_apoderado").val()+" "+
                            jQuery("#apellido2_apoderado").val()
                    );
                    var depto = "";
                    if(jQuery("#depto_apoderado").val() != ""){
                        depto = "Depto "+jQuery("#depto_apoderado").val()+" ";
                    }
                    jQuery("#resumen_direccion_apoderado").text(
                        jQuery("#calle_apoderado").val()+" "+
                            jQuery("#numero_apoderado").val()+" "+
                            depto+
                            jQuery("#sector_apoderado").val()+", "+
                            jQuery("#id_comuna_apoderado").find(":selected").text()
                    );
                    jQuery("#resumen_email_apoderado").text(jQuery("#email_apoderado").val());

                    jQuery("#resumen_tel1_apoderado").text(jQuery("#telefono_fijo_apoderado").val());
                    jQuery("#resumen_tel2_apoderado").text(jQuery("#telefono_celular_apoderado").val());

                    jQuery("#resumen_periodo").text(jQuery("#periodo").find(":selected").text());
                    jQuery("#resumen_establecimiento").text(jQuery("#rbd_establecimiento").find(":selected").text());
                    jQuery("#resumen_tipo_ensenanza").text(jQuery("#id_tipo_ensenanza").find(":selected").text());
                    jQuery("#resumen_grado_grupo").text(jQuery("#id_grado").find(":selected").text()+" "+jQuery("#id_curso").find(":selected").text());



                    break;
                default :
                    break;
            }
            return true;
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            //alert(currentIndex);
            switch  (currentIndex){
                case 1:
                    if(visto_regiones == 0){//si no se an cargado aun las regiones que se cargen
                        get_regiones("#id_region_apoderado","#contenedor_apoderado");
                        visto_regiones = 1;
                    }
                    break;
                case 2:
                    if(visto_tipo_ensenanza == 0){//si no an cargado las establecimientos que s ecargen
                        get_tipos_ensenanza("#id_tipo_ensenanza", "#contenedor_curso", rbd_establecimiento);
                        visto_tipo_ensenanza = 1;
                    }
                    break;
            }
        },
        onFinished: function (event, currentIndex) {
            var form = document.getElementById("formulario");
            var formData = new FormData(form);

            ins_alumno(formData);

        }
    });

}

function get_regiones(select, contenedor){
    console.log("Invocando Regiones...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/region.controlador.php",
        data: {id_funcion: "1" },
        beforeSend: function() {
            load_on("Cargando regiones...",contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i,v){
                var id_region = data[i].id_region;
                var nombre = data[i].nombre;

                jQuery(select)
                    .append(jQuery("<option></option>")
                        .val(id_region)
                        .text(nombre));
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);


        });
}

function get_provincias(select, contenedor, id_region){
    console.log("Invocando Provincias...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/provincia.controlador.php",
        data: {id_funcion: "1" , id_region: id_region},
        beforeSend: function() {
            load_on("Cargando provincias...",contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i,v){
                var id_provincia = data[i].id_provincia;
                var nombre = data[i].nombre;

                jQuery(select)
                    .append(jQuery("<option></option>")
                        .attr("value",id_provincia)
                        .text(nombre));
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);


        });
}

function get_comunas(select, contenedor, id_provincia){
    console.log("Invocando Comunas...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/comuna.controlador.php",
        data: {id_funcion: "1" , id_provincia: id_provincia},
        beforeSend: function() {
            load_on("Cargando provincias...",contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i,v){
                var id_comuna = data[i].id_comuna;
                var nombre = data[i].nombre;

                jQuery(select)
                    .append(jQuery("<option></option>")
                        .attr("value",id_comuna)
                        .text(nombre));
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);


        });
}

function get_religiones(select, contenedor){
    console.log("Invocando Religiones..");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/religion.controlador.php",
        data: {id_funcion: "1"},
        beforeSend: function() {
            load_on("Cargando religiones...",contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i,v){
                var id_religion = data[i].id_religion;
                var nombre = data[i].nombre;

                jQuery(select)
                    .append(jQuery("<option></option>")
                        .attr("value",id_religion)
                        .text(nombre));
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);


        });
}

function get_grados_educacionales(select1, select2, contenedor){
    console.log("Invocando Grados Educacionales..");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/grado_educacional.controlador.php",
        data: {id_funcion: "1"},
        beforeSend: function() {
            load_on("Cargando grados educacionales...",contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i,v){
                var id_grado_educacional = data[i].id_grado_educacional;
                var nombre = data[i].nombre;

                jQuery(select1)
                    .append(jQuery("<option></option>")
                        .attr("value", id_grado_educacional)
                        .text(nombre));

                jQuery(select2)
                    .append(jQuery("<option></option>")
                        .attr("value", id_grado_educacional)
                        .text(nombre));
            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);


        });
}

function get_alumno(run_alumno, contenedor){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/alumno.controlador.php",
        data: {id_funcion: "1", run_alumno: run_alumno},
        beforeSend: function(){
            load_on("Cargando datos de alumno...", contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            //console.log(data.grados_repetidos);
            jQuery("#nombre1_alumno").val(data.nombre1);
            jQuery("#nombre2_alumno").val(data.nombre2);
            jQuery("#apellido1_alumno").val(data.apellido1);
            jQuery("#apellido2_alumno").val(data.apellido2);
            jQuery("#sexo_alumno").val(data.sexo);
            jQuery("#fecha_nacimiento_alumno").val(data.fecha_nacimiento);
            jQuery("#email_alumno").val(data.email);
            jQuery("#avatar_alumno_preview").attr("src", "/_avatars/"+data.avatar);
            jQuery("#id_direccion_alumno").val(data.id_direccion);
            jQuery("#calle_alumno").val(data.calle);
            jQuery("#numero_alumno").val(data.numero);
            jQuery("#depto_alumno").val(data.depto);
            jQuery("#id_region_alumno").val(data.id_region);
            jQuery("#id_provincia_alumno")
                .empty()
                .prop("disabled", false)
                .append(jQuery("<option></option>")
                    .val("0")
                    .text("Seleccione Provincia"))
                .append(jQuery("<option></option>")
                    .val(data.id_provincia)
                    .text(data.nombre_provincia)
                    .prop("selected", true)
                );
            jQuery("#id_comuna_alumno")
                .empty()
                .prop("disabled", false)
                .append(jQuery("<option></option>")
                    .val("0")
                    .text("Seleccione Comuna"))
                .append(jQuery("<option></option>")
                    .val(data.id_comuna)
                    .text(data.nombre_comuna)
                    .prop("selected", true)
                );
            jQuery("#sector_alumno").val(data.sector);
            jQuery("#pde").val(data.pde);
            jQuery("#id_religion_alumno").val(data.id_religion);
            jQuery("#grado_educacional_padre").val(data.grado_educacional_padre);
            jQuery("#grado_educacional_madre").val(data.grado_educacional_madre);
            jQuery("#persona_vive_alumno").val(data.persona_vive);
            jQuery.each(data.grados_repetidos, function(i,vlue){
                var id_grado = "[data-id_grado="+data.grados_repetidos[i].id_grado+"]";
                var id_tipo_ensenanza = "[data-id_tipo_ensenanza="+data.grados_repetidos[i].id_tipo_ensenanza+"]";
                var cantidad = data.grados_repetidos[i].cantidad;
                jQuery("#grados_repetidos")
                    .find(id_grado+id_tipo_ensenanza)
                    .prop("checked", true)
                ;
                jQuery("#grados_repetidos_cantidad")
                    .find(id_grado+id_tipo_ensenanza)
                    .prop("readonly", false)
                    .val(cantidad)
                ;

            });
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off()},500);
        })
    ;
}

function get_apoderado(run_apoderado, contenedor){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/apoderado.controlador.php",
        data: {id_funcion: "1", run_apoderado: run_apoderado},
        beforeSend: function(){
            load_on("Cargando datos de apoderado", contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery("#nombre1_apoderado").val(data.nombre1);
            jQuery("#nombre2_apoderado").val(data.nombre2);
            jQuery("#apellido1_apoderado").val(data.apellido1);
            jQuery("#apellido2_apoderado").val(data.apellido2);
            jQuery("#sexo_apoderado").val(data.sexo);
            jQuery("#email_apoderado").val(data.email);
            jQuery("#avatar_apoderado_preview").attr("src", "/_avatars/"+data.avatar);
            jQuery("#telefono_fijo_apoderado").val(data.telefono_fijo);
            jQuery("#telefono_celular_apoderado").val(data.telefono_celular);
            jQuery("#id_direccion_apoderado").val(data.id_direccion);
            jQuery("#calle_apoderado").val(data.calle);
            jQuery("#numero_apoderado").val(data.numero);
            jQuery("#depto_apoderado").val(data.depto);
            jQuery("#id_region_apoderado").val(data.id_region);
            jQuery("#id_provincia_apoderado")
                .empty()
                .prop("disabled", false)
                .append(jQuery("<option></option>")
                    .val("0")
                    .text("Seleccione Provincia"))
                .append(jQuery("<option></option>")
                    .val(data.id_provincia)
                    .text(data.nombre_provincia)
                    .prop("selected", true)
                );
            jQuery("#id_comuna_apoderado")
                .empty()
                .prop("disabled", false)
                .append(jQuery("<option></option>")
                    .val("0")
                    .text("Seleccione Comuna"))
                .append(jQuery("<option></option>")
                    .val(data.id_comuna)
                    .text(data.nombre_comuna)
                    .prop("selected", true)
                );
            jQuery("#sector_apoderado").val(data.sector);

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off()}, 500);
        })
    ;
}

function get_tipos_ensenanza(select, contenedor, rbd_establecimiento){
    console.log("Invocando tipos de enseñanza...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/tipo_ensenanza.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_on("Cargando tipos de enseñanza...", contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i, value){
                jQuery(select)
                    .append(jQuery("<option></option>")
                        .val(data[i].id_tipo_ensenanza)
                        .text(data[i].nombre))
                ;
            });

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();}, 500);
        })
    ;
}

function get_grados(select, contenedor, rbd_establecimiento, id_tipo_ensenanza){
    console.log("Invocando grados...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/grado.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento, id_tipo_ensenanza: id_tipo_ensenanza},
        beforeSend: function(){
            load_on("Cargando grados...", contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i, value){
                jQuery(select)
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
            setTimeout(function(){load_off();}, 500);
        })
    ;
}

function get_cursos(select, contenedor, rbd_establecimiento, id_tipo_ensenanza, id_grado, periodo){
    console.log("Invocando cursos...");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/curso.controlador.php",
        data: {id_funcion: "1", rbd_establecimiento: rbd_establecimiento, id_tipo_ensenanza: id_tipo_ensenanza, id_grado: id_grado, periodo: periodo},
        beforeSend: function(){
            load_on("Cargando cursos...", contenedor);
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            if(data.result == false){
                return null;
            }
            jQuery.each(data, function(i, value){
                jQuery(select)
                    .append(jQuery("<option></option>")
                        .val(data[i].id_curso)
                        .text("Grupo " + data[i].grupo));
            });

        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();}, 500);
        })
    ;
}

function ins_alumno(formData){
    console.log("Ingresando alumno...");
    formData.append("id_funcion", "2");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/alumno.controlador.php",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
            load_matricula_on("#load_ingreso_alumno", "#load_ingreso_alumno_label", "Validando datos del alumno...")
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            setTimeout(function(){
                load_matricula_off("#load_ingreso_alumno", "#msg_ingreso_alumno", data.msg, data.result);
            },500);
            if(data.result == "1"){return null}
            setTimeout(function(){ins_alumno_joomla(formData)},500);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();}, 500);
        })
    ;
}

function ins_alumno_joomla(formData){
    console.log("Ingresando alumno en joomla...");
    formData.append("id_funcion", "3");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/alumno.controlador.php",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
            load_matricula_on("#load_ingreso_sistema1", "#load_ingreso_sistema1_label", "Ingresando datos del alumno...")
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            setTimeout(function(){
                load_matricula_off("#load_ingreso_sistema1", "#msg_ingreso_sistema1", data.msg, data.result);
            },500);
            if(data.result == "1"){return null}
            setTimeout(function(){ins_apoderado(formData)},500);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();}, 500);
        })
    ;
}

function ins_apoderado(formData){
    console.log("Ingresando apoderado...");
    formData.append("id_funcion", "2");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/apoderado.controlador.php",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
            load_matricula_on("#load_ingreso_apoderado", "#load_ingreso_apoderado_label", "Validando datos del apoderado...")
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            setTimeout(function(){
                load_matricula_off("#load_ingreso_apoderado", "#msg_ingreso_apoderado", data.msg, data.result);
            },500);
            if(data.result == "1"){return null}
            setTimeout(function(){ins_apoderado_joomla(formData)},500);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();}, 500);
        })
    ;
}

function ins_apoderado_joomla(formData){
    console.log("Ingresando apoderado en joomla...");
    formData.append("id_funcion", "3");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/apoderado.controlador.php",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
            load_matricula_on("#load_ingreso_sistema2", "#load_ingreso_sistema2_label", "Ingresando datos del apoderado...")
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            setTimeout(function(){
                load_matricula_off("#load_ingreso_sistema2", "#msg_ingreso_sistema2", data.msg, data.result);
            },500);
            if(data.result == "1"){return null}
            setTimeout(function(){ins_matricula(formData)},500);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();}, 500);
        })
    ;
}

function ins_matricula(formData){
    console.log("Ingresando apoderado en joomla...");
    formData.append("id_funcion", "1");
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/matricula.controlador.php",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
            load_matricula_on("#load_ingreso_matricula", "#load_ingreso_matricula_label", "Ingresando matricula...")
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            setTimeout(function(){
                load_matricula_off("#load_ingreso_matricula", "#msg_ingreso_matricula", data.msg, data.result);
            },500);
            setTimeout(function(){mostrar_dialogo(data.result, data.msg)},500);
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();}, 500);
        })
    ;
}




function validar_grados_repetidos(){
    var result = true;
    jQuery("#grados_repetidos_cantidad input[type=text]").each(function(){
        if(!validar_numeroMinMax2(jQuery(this),0,2)){
            result = false;
        }
    });
    if(!result){
        jQuery("#error_cantidad").html("<p>Ingrese cantidades validas</p>");
        return result;
    }
    jQuery("#error_cantidad").html("&nbsp;");
    return result;
}


function validar_alumno(){
    var result = true;

    if(!validar_run(jQuery("#run_alumno"))){ console.log("run alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#nombre1_alumno"),3,45,"Ingrese un nombre válido")){ console.log("nombre1 alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#nombre2_alumno"),3,45,"Ingrese un nombre válido")){ console.log("nombre2 alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#apellido1_alumno"),3,45,"Ingrese un apellido válido")){ console.log("apellido1 alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#apellido2_alumno"),3,45,"Ingrese un apellido válido")){ console.log("apellido2 alumno inválido"); result = false; }
    if(!validar_select(jQuery("#sexo_alumno"),"Debe selecciona un sexo")){result = false}
    if(!validar_fecha(jQuery("#fecha_nacimiento_alumno"),"Ingrese una fecha valida")){result = false;}

    if(!validar_email(jQuery("#email_alumno"),"Ingrese un email válido")){result = false;}
    if(!validar_textoMinMax(jQuery("#calle_alumno"),3,60,"Ingrese un nombre de calle válido")){result = false}
    if(!validar_numeroMinMax(jQuery("#numero_alumno"),1,5,"Ingrese un número de calle válido")){result = false}
    if(!validar_numeroTextoMinMax(jQuery("#depto_alumno"),0,5,"Ingrese un número depto válido")){result = false}
    if(!validar_select(jQuery("#id_region_alumno"),"Debe seleccionar una región")){result = false}
    if(!validar_select(jQuery("#id_provincia_alumno"),"Debe seleccionar una provincia")){result = false}
    if(!validar_select(jQuery("#id_comuna_alumno"),"Debe seleccionar una comuna")){result = false}
    if(!validar_textoMinMax(jQuery("#sector_alumno"),3,60,"Debe ingresar un sector válido")){result = false}
    if(!validar_select(jQuery("#pde"),"Debe seleccionar una opción")) {result = false}
    if(!validar_select(jQuery("#grado_educacional_madre"),"Debe seleccionar una opción")){result = false}
    if(!validar_select(jQuery("#grado_educacional_padre"),"Debe seleccionar una opción")){result = false}
    if(!validar_textoMinMax(jQuery("#persona_vive_alumno"),3,100,"Debe ingresar a lo menos una persona")){result = false}
    if(!validar_textoMinMax(jQuery("#establecimiento_procedencia"),3,60,"Ingrese un establecimiento válido")){result = false}
    if(!validar_grados_repetidos()){result = false};
    if(!validar_imagen_extencion(jQuery("#avatar_alumno"),"Ingrese una imagen valida")){ result = false;}

    return result;
}
function validar_apoderado(){
    var result = true;
    if (!validar_run(jQuery("#run_apoderado"))){ console.log("run alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#nombre1_apoderado"),3,45,"Ingrese un nombre válido")){ console.log("nombre1 alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#nombre2_apoderado"),3,45,"Ingrese un nombre válido")){ console.log("nombre2 alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#apellido1_apoderado"),3,45,"Ingrese un apellido válido")){ console.log("apellido1 alumno inválido"); result = false; }
    if(!validar_textoMinMax(jQuery("#apellido2_apoderado"),3,45,"Ingrese un apellido válido")){ console.log("apellido2 alumno inválido"); result = false; }
    if(!validar_select(jQuery("#sexo_apoderado"),"Debe seleccionar un sexo")){result = false}
    if(!validar_email(jQuery("#email_apoderado"),"Ingrese un email válido")){result = false;}
    if(!validar_textoMinMax(jQuery("#calle_apoderado"),3,60,"Ingrese un nombre de calle válido")){result = false};
    if(!validar_numeroMinMax(jQuery("#numero_apoderado"),1,5,"Ingrese un número de calle válido")){result = false};
    if(!validar_numeroTextoMinMax(jQuery("#depto_apoderado"),0,5,"Ingrese un número depto válido")){result = false};
    if(!validar_select(jQuery("#id_region_apoderado"),"Debe seleccionar una región")){result = false}
    if(!validar_select(jQuery("#id_provincia_apoderado"),"Debe seleccionar una provincia")){result = false}
    if(!validar_select(jQuery("#id_comuna_apoderado"),"Debe seleccionar una comuna")){result = false}
    if(!validar_textoMinMax(jQuery("#sector_apoderado"),3,60,"Debe ingresar un sector válido")){result = false}
    if(!validar_numeroMinMax(jQuery("#telefono_fijo_apoderado"),0,9,"Ingrese un teléfono fijo válido")){result = false}
    if(!validar_numeroMinMax(jQuery("#telefono_celular_apoderado"),8,9,"Ingrese un teléfono fijo válido")){result = false}
    if(!validar_imagen_extencion(jQuery("#avatar_apoderado"),"Ingrese una imagen valida")){ result = false;}

    return result;
}

function validar_curso(){
    var result = true;
    if(!validar_select(jQuery("#rbd_establecimiento"),"Seleccione un establecimiento")){result = false}
    if(!validar_select(jQuery("#id_tipo_ensenanza"),"Seleccione un tipo de enseñanza")){result = false}
    if(!validar_select(jQuery("#id_grado"),"Seleccione un grado")){result = false}

    return result;
}

function readURL(input,preview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function load_matricula_on(load, label, msg){
    jQuery(load).html(
        jQuery("<img>")
            .attr("src","/_code/vistas/img/load4.gif")
            .css({"width":"220px","height":"24px"})
    );
    jQuery(label).text(msg);
}

function load_matricula_off(load, label, msg, result){
    switch (result){
        case '1':
            icon = '/_code/vistas/img/no-ok.png';
            clase = "error";
            break;
        case '2':
            icon = '/_code/vistas/img/warning.png';
            clase = "warning";
            resultado = true;
            break;
        case '3':
            icon = '/_code/vistas/img/ok.png';
            clase = "exito";
            resultado = true;
            break;
    }
    jQuery(load).find("img")
        .attr("src",icon)
        .css({"width":"25px","height":"25px"})
    ;
    jQuery(label)
        .removeClass()
        .addClass(clase)
        .text(msg);
}