jQuery(document).ready(function(){
    var salida = "0"// INDICA SI SE PUEDE ABANDONAR EL FORMULARIO
    var visto_regiones = 0;
    var visto_establecimientos = 0;
    var ingresoResult = true;



    $(window).bind("beforeunload", function(eEvent) {
        $(window).bind("beforeunload",function(event) {
            if(salida == "0") return "You have unsaved changes";
        });
    });


    get_regiones("#id_region_alumno","#contenedor_alumno");

        get_religiones("#id_religion_alumno","#contenedor_alumno");

        get_grados_educacionales("#grado_educacional_padre","#contenedor_alumno")

        get_grados_educacionales("#grado_educacional_madre","#contenedor_alumno")


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
            //formData.append("foo","hola mundo");
            jQuery.ajax({
                url: "/_code/controladores/matricula.ingreso.php",
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    jQuery("#resumen").append(load("Ingresando matricula"));

                }

            })
                .done(function(data){
                    alert(data);/*
                    var result = jQuery.parseJSON(data);
                    var val = result.val;
                    var msg = result.msg;
                    ingresoResult = val;
                    //alert(val);
                    //alert(msg);
                    jQuery("#panel_loading").remove();
                    mostrar_dialogo(val,msg);*/
                })
                .fail(function(jqXHR, textStatus){
                    alert("error "+textStatus);
                    jQuery("#panel_loading").remove();
                })
                .always(function(){
                    jQuery("#panel_loading").remove();

                })
            ;

        }

    });
    jQuery("#grados_repetidos :checkbox").click(function(){
            var hijo = "#grv"+jQuery("#grados_repetidos td :checkbox").index(this);
            if(jQuery(this).is(':checked')) {
                jQuery(hijo).prop("readonly",false);
            } else {
                jQuery(hijo).prop("readonly",true);
                jQuery(hijo).val("");
            }

        });

    jQuery("#run_alumno").focusout(function(){
        if (!validar_run(jQuery("#run_alumno"))){ return false; }
        var run_alumno = jQuery(this).val();
        run_alumno = run_alumno.replace(/\./g,"");
        run_alumno = run_alumno.replace(/\-/g,"");
        //alert(run_alumno);
        //alert("foo");
         jQuery.ajax({
            url: "/_code/controladores/alumno.get.datos.php",
            data: {run_alumno : run_alumno, funcion : 1},
            beforeSend: function(){
                jQuery("#panel_loading").remove();
                jQuery("#contenedor_alumno").append(load("Cargando datos de alumno..."));
            }
        })
            .done(function(data){
                var result = jQuery.parseJSON(data);
                 //console.log(data);

                 if(!result.result){
                     return null;
                 }
                var alumno = result.identidad;
                var direccion = result.direccion;
                var direccion_id = result.direccion_id;
                var direccion_nombre = result.direccion_nombre;
                var grados_repetidos = result.grados_repetidos;
                //console.log(grados_repetidos[0].id_grado);
                jQuery("#nombre1_alumno").val(alumno.nombre1);
                jQuery("#nombre2_alumno").val(alumno.nombre2);
                jQuery("#apellido1_alumno").val(alumno.apellido1);
                jQuery("#apellido2_alumno").val(alumno.apellido2);
                jQuery("#sexo_alumno").val(alumno.sexo);
                jQuery("#fecha_nacimiento_alumno").val(alumno.fecha_nacimiento);
                jQuery("#email_alumno").val(alumno.email);

                jQuery("#avatar_alumno_preview").attr("src","/_avatars/"+alumno.avatar);

                jQuery("#calle_alumno").val(direccion.calle);
                jQuery("#numero_alumno").val(direccion.numero);

                jQuery("#id_region_alumno").val(direccion_id.id_region);
                jQuery("#id_provincia_alumno").append("<option value='"+direccion_id.id_provincia+"' selected='selected'>"+direccion_nombre.nombre_provincia+"</option>");
                jQuery("#id_provincia_alumno").prop("disabled",false);

                jQuery("#id_comuna_alumno").append("<option value='"+direccion_id.id_comuna+"' selected='selected'>"+direccion_nombre.nombre_comuna+"</option>");
                jQuery("#id_comuna_alumno").prop("disabled",false);

                jQuery("#sector_alumno").val(direccion.sector);
                jQuery("#pde").val(alumno.pde);
                jQuery("#id_religion_alumno").val(alumno.id_religion);
                jQuery("#grado_educacional_padre").val(alumno.grado_educacional_padre);
                jQuery("#grado_educacional_madre").val(alumno.grado_educacional_madre);
                jQuery("#persona_vive_alumno").val(alumno.persona_vive);


                var grados_repetidos_input = jQuery("#grados_repetidos input");
                var i = 0;

                grados_repetidos.each(function(){
                    var id_grado = grados_repetidos[i].id_grado;
                    var id_tipo_ensenanza = grados_repetidos[i].id_tipo_ensenanza;
                    var cantidad = grados_repetidos[i].cantidad;
                    //console.log(id_grado);
                    //console.log(id_tipo_ensenanza);
                    //console.log(cantidad);
                    jQuery("#grados_repetidos input[type=checkbox][data-id_grado='"+id_grado+"'][data-id_tipo_ensenanza='"+id_tipo_ensenanza+"']").prop("checked", true);
                    jQuery("#grados_repetidos_veces input[type=text][data-id_grado='"+id_grado+"'][data-id_tipo_ensenanza='"+id_tipo_ensenanza+"']")
                        .prop("readonly",false)
                        .val(cantidad)
                    ;
                    i++;
                });



            })
            .fail(function(){
                alert("error");
            })
            .always(function(){
                jQuery("#panel_loading").remove();
            });
        //jQuery("#id_provincia_alumno").prop("disabled");
    });



    jQuery("#run_apoderado").focusout(function(){
        if (!validar_run(jQuery("#run_apoderado"))){ return false; }
        var run_apoderado = jQuery(this).val();
        run_apoderado = run_apoderado.replace(/\./g,"");
        run_apoderado = run_apoderado.replace(/\-/g,"");
        jQuery.ajax({
            url: "/_code/controladores/apoderado.get.datos.php",
            data: {run_apoderado : run_apoderado, funcion : 1},
            beforeSend: function(){
                jQuery("#panel_loading").remove();
                jQuery("#contenedor_apoderado").append(load("Cargando datos de apoderado..."));
            }
        })
            .done(function(data){
                var result = jQuery.parseJSON(data);
                if(!result.result){
                    return null;
                }
                var apoderado = result.identidad;
                var direccion = result.direccion;
                var direccion_id = result.direccion_id;
                var direccion_nombre = result.direccion_nombre;
                jQuery("#nombre1_apoderado").val(apoderado.nombre1);
                jQuery("#nombre2_apoderado").val(apoderado.nombre2);
                jQuery("#apellido1_apoderado").val(apoderado.apellido1);
                jQuery("#apellido2_apoderado").val(apoderado.apellido2);
                jQuery("#sexo_apoderado").val(apoderado.sexo);
                jQuery("#avatar_apoderado_preview").attr("src","/_avatars/"+apoderado.avatar);

                jQuery("#email_apoderado").val(apoderado.email);
                jQuery("#calle_apoderado").val(direccion.calle);
                jQuery("#numero_apoderado").val(direccion.numero);

                jQuery("#id_region_apoderado").val(direccion_id.id_region);
                jQuery("#id_provincia_apoderado")
                    .append("<option value='"+direccion_id.id_provincia+"' selected='selected'>"+direccion_nombre.nombre_provincia+"</option>")
                    .prop("disabled",false);


                jQuery("#id_comuna_apoderado")
                    .append("<option value='"+direccion_id.id_comuna+"' selected='selected'>"+direccion_nombre.nombre_comuna+"</option>")
                    .prop("disabled",false);


                jQuery("#sector_apoderado").val(direccion.sector);

                jQuery("#telefono_fijo_apoderado").val(apoderado.telefono_fijo);
                jQuery("#telefono_celular_apoderado").val(apoderado.telefono_celular);



            })
            .fail(function(){
                alert("error");
            })
            .always(function(){
                jQuery("#panel_loading").remove();
            });
        //jQuery("#id_provincia_apoderado").prop("disabled");
    });



    jQuery("#fecha_nacimiento_alumno").change(function(){
        var fecha_nacimiento = jQuery("#fecha_nacimiento_alumno").val();
        fecha_nacimiento = fecha_nacimiento.replace(/\-/g,"");

        var ano = fecha_nacimiento.substring(0,4);
        var mes = fecha_nacimiento.substring(4,6);
        var dia = fecha_nacimiento.substring(6,8);

        fecha_hoy = new Date();
        ahora_ano = fecha_hoy.getYear();
        ahora_mes = 03;
        ahora_dia = 31;
        edad = (ahora_ano + 1900) - ano;

        if ( ahora_mes < (mes - 1)){
            edad--;
        }
        if (((mes - 1) == ahora_mes) && (ahora_dia < dia)){
            edad--;
        }
        if (edad > 1900){
            edad -= 1900;
        }
        jQuery("#edad").val(edad);


    });
    jQuery("#avatar_alumno").change(function () {
        readURL(this,$('#avatar_alumno_preview'));
    });
    jQuery("#avatar_apoderado").change(function () {
        readURL(this,$('#avatar_apoderado_preview'));
    });
    jQuery("#id_region_alumno").change(function(){
        if(jQuery("#id_region_alumno").val() != '0'){
            get_provincias("#id_region_alumno","#id_provincia_alumno","#contenedor_alumno");
        }
        jQuery("#id_provincia_alumno").prop("disabled",true);
        jQuery("#id_provincia_alumno").find("option").remove();
        jQuery("#id_provincia_alumno").append("<option value='0'>Seleccione Provincia</option>");
        jQuery("#id_comuna_alumno").prop("disabled",true);
        jQuery("#id_comuna_alumno").find("option").remove();
        jQuery("#id_comuna_alumno").append("<option value='0'>Seleccione Comuna</option>");

    });
    jQuery("#id_provincia_alumno").change(function(){
        if(jQuery("#id_provincia_alumno").val() != '0'){
            get_comunas("#id_provincia_alumno","#id_comuna_alumno","#contenedor_alumno");
        }
        jQuery("#id_comuna_alumno").prop("disabled",true);
        jQuery("#id_comuna_alumno").find("option").remove();
        jQuery("#id_comuna_alumno").append("<option value='0'>Seleccione Comuna</option>");

    });
    jQuery("#id_region_apoderado").change(function(){
        if(jQuery("#id_region_apoderado").val() != '0'){
            get_provincias("#id_region_apoderado","#id_provincia_apoderado","#contenedor_apoderado");
        }
        jQuery("#id_provincia_apoderado").prop("disabled",true);
        jQuery("#id_provincia_apoderado").find("option").remove();
        jQuery("#id_provincia_apoderado").append("<option value='0'>Seleccione Provincia</option>");
        jQuery("#id_comuna_apoderado").prop("disabled",true);
        jQuery("#id_comuna_apoderado").find("option").remove();
        jQuery("#id_comuna_apoderado").append("<option value='0'>Seleccione Comuna</option>");

    });
    jQuery("#id_provincia_apoderado").change(function(){
        if(jQuery("#id_provincia_apoderado").val() != '0'){
            get_comunas("#id_provincia_apoderado","#id_comuna_apoderado","#contenedor_apoderado");
        }
        jQuery("#id_comuna_apoderado").prop("disabled",true);
        jQuery("#id_comuna_apoderado").find("option").remove();
        jQuery("#id_comuna_apoderado").append("<option value='0'>Seleccione Comuna</option>");

    });
    jQuery("#rbd_establecimiento").change(function(){
        if(jQuery("#rbd_establecimiento").val() != "0"){
            get_establecimientos_tipos_ensenanza("#rbd_establecimiento","#id_tipo_ensenanza","#contenedor_curso");
        }
        jQuery("#id_tipo_ensenanza").prop("disabled",true);
        jQuery("#id_tipo_ensenanza").find("option").remove();
        jQuery("#id_tipo_ensenanza").append("<option value='0'>Seleccione Tipo De Enseñanza</option>");
        jQuery("#id_grado").prop("disabled",true);
        jQuery("#id_grado").find("option").remove();
        jQuery("#id_grado").append("<option value='0'>Seleccione Grado</option>");
        jQuery("#grupo").prop("disabled",true);
        jQuery("#grupo").find("option").remove();
        jQuery("#grupo").append("<option value='0'>Seleccione Grupo</option>");
    });
    jQuery("#id_tipo_ensenanza").change(function(){
        if(jQuery("#id_tipo_ensenanza").val() != "0"){
            get_establecimientos_grados("#id_tipo_ensenanza","#rbd_establecimiento","#id_grado","#contenedor_curso");
        }
        jQuery("#id_grado").prop("disabled",true);
        jQuery("#id_grado").find("option").remove();
        jQuery("#id_grado").append("<option value='0'>Seleccione Grado</option>");
        jQuery("#grupo").prop("disabled",true);
        jQuery("#grupo").find("option").remove();
        jQuery("#grupo").append("<option value='0'>Seleccione Grupo</option>");
    });
    jQuery("#id_grado").change(function(){
        if(jQuery("#id_grado").val() != '0'){
            get_establecimientos_cursos("#rbd_establecimiento","#id_grado","#id_tipo_ensenanza","#grupo","#contenedor_curso")
        }
        jQuery("#grupo").prop("disabled",true);
        jQuery("#grupo").find("option").remove();
        jQuery("#grupo").append("<option value='0'>Seleccione Grupo</option>");
    });


});
function readURL(input,preview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


function validar_alumno(){
    var result = true;
   /*  if (!validar_run(jQuery("#run_alumno"))){ console.log("run alumno inválido"); result = false; }
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
    if(!validar_numeroMinMax2(jQuery("#grados_repetidos_veces input"),0,2,"Ingrese cantidades validas","#error_cantidad")){result = false}
    if(!validar_imagen_extencion(jQuery("#avatar_alumno"),"Ingrese una imagen valida")){ result = false;}
    */return result;
}

function validar_apoderado(){
    var result = true;
   /* if (!validar_run(jQuery("#run_apoderado"))){ console.log("run alumno inválido"); result = false; }
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
*/
    return result;
}

function validar_curso(){
    var result = true;
    /* if(!validar_select(jQuery("#rbd_establecimiento"),"Seleccione un establecimiento")){result = false}
     if(!validar_select(jQuery("#id_tipo_ensenanza"),"Seleccione un tipo de enseñanza")){result = false}

    */return result;
}

function mostrar_dialogo(val,msg){
    jQuery("#dialog").html("<p>"+msg+"</p>");
    var clase = "";
    var titulo = "Mensaje";
    if(val == "0"){
        clase = "error-ui";
        titulo = "Error Fatal";
        jQuery("#dialog").dialog({
            autoOpen: false,
            buttons:[
                {
                    text: "Intentar Nuevamente",
                    click: function(){
                        jQuery($this).dialog("close");
                    }
                }
            ]
        });

    }
    if(val == "1"){
        clase = "error-ui";
        titulo = "Error De Validación";

        jQuery("#dialog").dialog({
            autoOpen: false,
            buttons:[
                {
                    text: "Intentar Nuevamente",
                    click: function(){
                        jQuery($this).dialog("close");
                    }
                }
            ]
        });
    }

    if(val == "2"){
        clase = "peligro-ui";
        titulo = "Operación Interrumpida";

        jQuery("#dialog").dialog({
            autoOpen: false,
            buttons:[
                {
                    text: "Nueva Matricula",
                    click: function(){
                        location.reload();
                    }
                },
                {
                    text: "Imprimir Matricula",
                    click: function(){
                        jQuery("#formulario").attr("action","/_code/controladores/matricula.pdf.php");
                        jQuery("#formulario").submit();
                    }
                }
            ]
        });
    }

    if(val == "3"){
        clase = "exito-ui"
        titulo = "Operación exitosa";

        jQuery("#dialog").dialog({
            autoOpen: false,
            buttons:[
                {
                    text: "Nueva Matricula",
                    click: function(){
                        location.reload();
                    }
                },
                {
                    text: "Imprimir Matricula",
                    click: function(){
                        jQuery("#formulario").attr("action","/_code/controladores/matricula.pdf.php");
                        jQuery("#formulario").submit();
                    }
                }
            ]
        });
    }

    jQuery("#dialog").dialog({
        modal:true,
        autoOpen: false,
        dialogClass: clase,
        title: titulo,
        width: "auto"
    });
    jQuery("#dialog").dialog("open");
}





