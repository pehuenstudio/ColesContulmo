jQuery(document).ready(function(){
    var contenedor_alumno = "#contenedor_alumno";

    crear_furmulario();
    get_regiones("#id_region_alumno", contenedor_alumno);
    setTimeout(function(){get_religiones("#id_religion_alumno", contenedor_alumno);},500);
    setTimeout(function(){get_grados_educacionales("#grado_educacional_padre", "#grado_educacional_madre", contenedor_alumno)},500);

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
            .attr("disabled", disabled)
            .append(jQuery("<option></option>")
                .val("0")
                .text("Seleccione Comuna"));
        if(id_region == "0"){return null}

        get_provincias("#id_provincia_alumno", contenedor_alumno, id_region);
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
    });

});
function crear_furmulario(){
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
                        jQuery("#matricula_formulario input").keyup(function(){
                            validar_alumno();
                        });

                        jQuery("#matricula_formulario select").change(function(){
                            validar_alumno();

                        });

                        return false;
                    }
                    break;
                case 2:
                    if(!validar_apoderado()){
                        jQuery("#matricula_formulario input").keyup(function(){
                            validar_apoderado();
                        });

                        jQuery("#matricula_formulario select").change(function(){
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
            console.log(data);
            var data = jQuery.parseJSON(data);
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