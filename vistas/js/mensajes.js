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
                        jQuery("#dialog").dialog("close");
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
                        jQuery("#formulario")
                            .attr("action","/_code/controladores/matricula.controlador.php")
                            .append(
                                jQuery("<input>")
                                    .attr({
                                        "name": "id_funcion",
                                        "type": "hidden"
                                    })
                                    .val("2"))
                            .submit();
                    }
                }
            ]
        });
    }
    if(val == "21"){
        clase = "peligro-ui";
        titulo = "Operación Interrumpida";

        jQuery("#dialog").dialog({
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
                        jQuery("#formulario")
                            .attr("action","/_code/controladores/matricula.controlador.php")
                            .append(
                                jQuery("<input>")
                                    .attr({
                                            "name": "id_funcion",
                                            "type": "hidden"
                                        })
                                    .val("2"))
                            .submit();
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
                        jQuery("#formulario")
                            .attr("action","/_code/controladores/matricula.controlador.php")
                            .append(
                                jQuery("<input>")
                                    .attr({
                                        "name": "id_funcion",
                                        "type": "hidden"
                                    })
                                    .val("2"))
                            .submit();
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
