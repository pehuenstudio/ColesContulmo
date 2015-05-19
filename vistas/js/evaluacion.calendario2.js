jQuery(document).ready(function() {


   renderCalendar0(fecha_hoy);

    get_escuelas_profesor(run_profesor);

    jQuery("#contenedor_cursos").on( "click", ".enlace_asignatura", function() {
        event.preventDefault();
        var id_curso = jQuery(this).attr("data-id_curso");
        var id_asignatura = jQuery(this).attr("data-id_asignatura");
        get_horario(run_profesor, id_curso, id_asignatura);
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
                jQuery("#contenedor_cursos").append("<ul></ul>")
                jQuery("#contenedor_cursos ul").append(
                    "<li id ='"+rbd_establecimiento+"'>"+nombre+"</li>");

            });
            jQuery("#contenedor_cursos ul li").append("<ul></ul>");
            setTimeout(function(){
                get_cursos_profesor(run_profesor);
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

function get_cursos_profesor(run_profesor){

    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/profesor.get.cursos.php",
        data: {run_profesor: run_profesor},
        beforeSend: function(){
            load_on("Cargando cursos...", "#contenedor_calendario");
        }
    })
        .done(function(data){
            // console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i,value){
                var id_curso = data[i]["id_curso"];
                var nombre_tipo_ensenanza = data[i]["nombre_tipo_ensenanza"];
                var nombre_grado = data[i]["nombre_grado"];
                var rbd_establecimiento = data[i]["rbd_establecimiento"];
                var grupo = data[i]["grupo"];

                //jQuery("#"+rbd_establecimiento).append("<ul></ul>");
                jQuery("#"+rbd_establecimiento+" ul").append(
                    "<li id='"+id_curso+"'>"+nombre_grado+" "+nombre_tipo_ensenanza+" "+grupo+"</li>");

            });
            jQuery("#"+rbd_establecimiento+" ul li").append("<ul></ul>");
            setTimeout(function(){
                get_asignaturas(run_profesor);
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

function get_asignaturas(run_profesor){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/profesor.get.cursos.asignaturas.php",
        data: {run_profesor: run_profesor},
        beforeSend: function(){
            load_on("Cargando asignaturas...", "#contenedor_calendario");
        }
    })
        .done(function(data){
            //console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data,function(i,value){
                var id_asignatura = data[i].id_asignatura;
                var nombre_asignatura = data[i].nombre_asignatura;
                var id_curso = data[i].id_curso;
                jQuery("li#"+id_curso+" ul").append(
                    "<li>" +
                        "<a class='enlace_asignatura' data-id_curso='"+id_curso+"' data-id_asignatura='"+id_asignatura+"'>"+nombre_asignatura+"</a>" +
                    "</li>");

            });
        })
    ;
}

function get_horario(run_profesor, id_curso, id_asignatura){
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/profesor.get.dias_clases.php",
        data: {run_profesor: run_profesor, id_curso: id_curso, id_asignatura: id_asignatura},
        beforeSend: function(){
            load_on("Cargando dias de clases...", "#contenedor_calendario");
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            var dias_clases = Array();
            jQuery.each(data,function(i,value){
                dias_clases[i]=data[i].id_dia;
            });
            //console.log(dias_clases);
            $('#calendar').fullCalendar('destroy');
            renderCalendar(fecha_hoy, dias_clases);
            setTimeout(function(){
                load_off();
            },500);
        })
        .fail(function(){
            alert("ERROR");
            load_off();
        })
    ;
}

function renderCalendar(fecha_hoy, dias_clases) {
   jQuery('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: fecha_hoy,
        lang: "es",
        buttonIcons: false, // show the prev/next text
        weekNumbers: false,
        editable: false,
        eventLimit: true,
        hiddenDays: [6,0 ],// allow "more" link when too many events
        dayRender: function(date, cell){
            var date1 = new Date(date);
            var dia_semana = (date1.getDay()+1);
           /* if (date1.getDay() == "1"){
                cell.css("background","#EFEFEF");
            }*/
            if(jQuery.inArray(dia_semana.toString(),dias_clases) == -1){
                cell.text("Sin clases este dia");
                cell.addClass("sin-clases");
            }

       }
    });
}

function renderCalendar0(fecha_hoy) {
    jQuery('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: fecha_hoy,
        lang: "es",
        buttonIcons: false, // show the prev/next text
        weekNumbers: false,
        editable: false,
        eventLimit: true,
        hiddenDays: [6,0 ]// allow "more" link when too many events

    });
}