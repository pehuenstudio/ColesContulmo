jQuery(document).ready(function(){
    var contenedor_alumno = "#contenedor_alumno";
    var contenedor_apoderado = "#contenedor_apoderado";


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

});
function crear_furmulario(){
    var visto_regiones = 0;
    var visto_establecimientos = 0;
    jQuery("#modulo_matriculas").steps({
        headerTag: "h2",
        bodyTag: "section",

        labels:{
            finish: "Ingresar",
            next: "Siguiente",
            previous: "Atras",
            loading: "Procesando ..."
        },
        transitionEffect: $.fn.steps.transitionEffect.slide,
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
                        jQuery("#matricula_formulario input").keyup(function(){
                            validar_curso();
                        });

                        jQuery("#matricula_formulario select").change(function(){
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
                            jQuery("#id_comuna_alumno option:selected").text()
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
                            jQuery("#id_comuna_apoderado option:selected").text()
                    );
                    jQuery("#resumen_email_apoderado").text(jQuery("#email_apoderado").val());

                    jQuery("#resumen_tel1_apoderado").text(jQuery("#telefono_fijo_apoderado").val());
                    jQuery("#resumen_tel2_apoderado").text(jQuery("#telefono_celular_apoderado").val());

                    jQuery("#resumen_periodo").text(jQuery("#periodo option:selected").text());
                    jQuery("#resumen_establecimiento").text(jQuery("#rbd_establecimiento option:selected").text());
                    jQuery("#resumen_tipo_ensenanza").text(jQuery("#id_tipo_ensenanza option:selected").text());
                    jQuery("#resumen_grado_grupo").text(jQuery("#id_grado option:selected").text()+" "+jQuery("#grupo option:selected").text());



                    break;
                default :
                    break;
            }
            return true;
        },
        onStepChanged: function (event, currentIndex, priorIndex) {

            switch  (currentIndex){
                case 1:
                    if(visto_regiones == 0){//si no se an cargado aun las regiones que se cargen
                        get_regiones("#id_region_apoderado","#contenedor_apoderado");
                        visto_regiones = 1;
                    }
                    break;
                case 2:
                    if(visto_establecimientos == 0){//si no an cargado las establecimientos que s ecargen
                        get_establecimientos("#rbd_establecimiento","#contenedor_curso");
                        visto_establecimientos = 1;
                    }
                    break;
            }
        },
        onFinished: function (event, currentIndex) {
            var form = document.getElementById("formulario");
            var formData = new FormData(form);
            var result = true;

            if(!ingresar_alumno(formData)){result = false}
            if(!ingresar_alumno_sistema(formData)){result = false};
            if(!ingresar_apoderado(formData)){result = false}
            if(!ingresar_apoderado_sistema(formData)){result = false};
            if(result){
                if(!ingresar_matricula(formData)){result = false};
            }

            if(!result){
                mostrar_dialogo(0,"El proceso de matricula ha fallado.");
            }
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

function get_establecimientos(select, contenedor){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/establecimiento.controlador.php",
        data: {id_funcion: "1"},
        beforeSend: function(){
            load_on("Cargando_establecimientos...", contenedor);
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, value){
                jQuery(select)
                    .append(jQuery("<option></option>")
                        .val(data[i].rbd_establecimiento)
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

function readURL(input,preview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}