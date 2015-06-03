jQuery(document).ready(function(){
    var run_profesor = jQuery("#run_profesor").val();
    var dias_clases = [];

    jQuery("#contenedor_formulario").sticky({topSpacing:0});

    get_establecimientos(run_profesor);
    renderCalendar0(fecha_hoy);

    jQuery("#rbd_establecimiento").change(function(){
        var rbd_establecimiento = jQuery(this).val();
        jQuery("#id_curso").prop("disabled", false);
        get_cursos(run_profesor, rbd_establecimiento);
    });

    jQuery("#id_curso").change(function(){
        var id_curso = jQuery(this).val();
        jQuery("#id_asignatura").prop("disabled", false);
        get_asignaturas(run_profesor, id_curso);
    });

    jQuery("#id_asignatura").change(function(){
        var id_curso = jQuery("#id_curso").val();
        var id_asignatura = jQuery(this).val();
        $('#calendar').fullCalendar('destroy');
        get_dias(run_profesor, id_curso, id_asignatura, dias_clases, fecha_hoy);

    });

    jQuery("#contenedor_calendario").on("click",".fc-day",function(){
        var asignatura = jQuery("#id_asignatura").find(":selected");
        var fecha = jQuery(this).attr("data-date");
        console.log(fecha);
        jQuery('#calendar').fullCalendar('renderEvent',
            {
                title: "Prueba de "+asignatura.text(),
                start: fecha,
                color: asignatura.attr("data-color1")

            },
            true // make the event "stick"
        );
    });
});

function get_establecimientos(run_profesor){
    console.log("cargando establecimientos")
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
    console.log("cargando cursos")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/asignatura.controlador.php",
        data: {id_funcion: "2", run_profesor: run_profesor, id_curso: id_curso},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
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

function get_dias(run_profesor, id_curso, id_asignatura, dias_clases, fecha_hoy){
    console.log("cargando cursos")
    jQuery.ajax({
        method: "POST",
        url: "/_code/controladores/dia.controlador.php",
        data: {id_funcion: "1", run_profesor: run_profesor, id_curso: id_curso, id_asignatura: id_asignatura},
        beforeSend: function(){
            //load_on("Cargando establecimientos...", "#contenedor_fechas");
        }
    })
        .done(function(data){
            console.log(data);
            var data = jQuery.parseJSON(data);
            jQuery.each(data, function(i, value){
                dias_clases[i]=data[i].id_dia;
            });
            renderCalendar(fecha_hoy, dias_clases)
        })
        .fail(function(){
            alert("ERROR");
        })
        .always(function(){
            setTimeout(function(){load_off();},500);
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

            if(jQuery.inArray(dia_semana.toString(),dias_clases) == -1){
                if(!cell.hasClass("fc-other-month")){
                    cell.text("Sin clases");
                    cell.addClass("sin-clases");
                }
            }
        },// allow "more" link when too many events
        columnFormat: {
            month: 'dddd',    // Monday, Wednesday, etc
            week: 'dddd, MMM dS', // Monday 9/7
            day: 'dddd, MMM dS'  // Monday 9/7
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
        hiddenDays: [6,0 ],// allow "more" link when too many events
        columnFormat: {
            month: 'dddd',    // Monday, Wednesday, etc
            week: 'dddd, MMM dS', // Monday 9/7
            day: 'dddd, MMM dS'  // Monday 9/7
        }

    });
}