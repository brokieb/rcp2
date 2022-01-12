    <section class='w-100'>
    <div id="evoCalendar" data-ids='0' data-times='<?=json_encode($answer)?>'></div>
    <div class='column'>
            <h3 class='count-hours'>Suma godzin w tym miesiącu wynosi <strong><?=AddTime($times)?></strong></h3>
        </div>
 
    <script>
    $('#evoCalendar').evoCalendar({
        calendarEvents: $("#evoCalendar").data("times"),


    });
    </script>
    </section>
