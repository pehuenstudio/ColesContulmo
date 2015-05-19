jQuery(document).ready(function() {


    get_escuelas_profesor(run_profesor);
    jQuery("#rbd_establecimiento").change(function(){
        var rbd_establecimiento = jQuery(this).val();
        if(rbd_establecimiento == "0"){
            jQuery("#id_curso")
                .prop("disabled",true)
                .empty()
                .append("<option value='0'>Seleccione Un Curso</option>");
            return null;
        }
        jQuery("#id_curso").prop("disabled",false);
        get_cursos_profesor(run_profesor);


    });

});

function get_escuelas_profesor(run_profesor){
    //console.log(run_profesor);
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/profesor.get.establecimientos.php",
        data: {run_profesor: run_profesor},
        beforeSend: function(){
            load_on("Cargando clases...", "#contenedor_calendario");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i,value){
                var rbd_establecimiento = data[i]["rbd_establecimiento"];
                var nombre = data[i]["nombre"];
                jQuery("#rbd_establecimiento").append(
                    "<option value = '"+rbd_establecimiento+"'>"+nombre+"</option>"
                );

            });
            setTimeout(function(){
               //get_cursos_profesor(run_profesor);
            },500);
            setTimeout(function(){
                load_off();
            },500);
        })
        .fail(function(){
            alert("ERROR");
            setTimeout(function(){
                load_off();
            },500);
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);
        })
    ;
}

function get_cursos_profesor(run_profesor, rbd_establecimiento){

    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/profesor.get.cursos.php",
        data: {run_profesor: run_profesor, rbd_establecimiento: rbd_establecimiento},
        beforeSend: function(){
            load_on("Cargando cursos...", "#contenedor_calendario");
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i,value){
                var id_curso = data[i]["id_curso"];
                var nombre_tipo_ensenanza = data[i]["nombre_tipo_ensenanza"];
                var nombre_grado = data[i]["nombre_grado"];
                var rbd_establecimiento = data[i]["rbd_establecimiento"];
                var grupo = data[i]["grupo"];


            });

            setTimeout(function(){
                //get_asignaturas(run_profesor);
            },500);
            setTimeout(function(){
                load_off();
            },500);
        })
        .fail(function(){
            alert("ERROR");
            setTimeout(function(){
                load_off();
            },500);
        })
        .always(function(){
            setTimeout(function(){
                load_off();
            },500);
        })
    ;
}