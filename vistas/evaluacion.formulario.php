<?php //echo __FILE__."<br/>";?>
<link href="/_code/vistas/css/fullcalendar.css" rel='stylesheet' />
<link href="/_code/vistas/css/fullcalendar.print.css" rel='stylesheet' media='print' />
<script src="/_code/vistas/js/moment.min.js"></script>
<script src="/_code/vistas/js/_jquery.min.js"></script>
<script src="/_code/vistas/js/fullcalendar.es.js"></script>
<script src="/_code/vistas/js/fullcalendar.js"></script>
<script>

jQuery(document).ready(function() {
    var currentLangCode = 'en';


    function renderCalendar() {
       jQuery('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '<?php echo date("Y-m-d");?>',
            lang: "es",
            buttonIcons: false, // show the prev/next text
            weekNumbers: true,
            editable: true,
            eventLimit: true // allow "more" link when too many events

        });
    }

    renderCalendar();
});

</script>

<div id="calendar"></div>