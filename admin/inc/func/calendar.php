<?php

require "inc/funcHeader.php" ;
require "inc/func/calendarSettings.php" ;

?>

<script src='script/index.global.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      initialDate: '2023-01-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events:{
            url: "inc/calendar.json"
            }
      // events: [
      //   {
      //     title: 'All Day Event',
      //     start: '2023-01-01'
      //   },
      //   {
      //     title: 'Long Event',
      //     start: '2023-01-07',
      //     end: '2023-01-10'
      //   },
      //   {
      //     groupId: 999,
      //     title: 'Repeating Event',
      //     start: '2023-01-09T16:00:00'
      //   },
      //   {
      //     groupId: 999,
      //     title: 'Repeating Event',
      //     start: '2023-01-16T16:00:00'
      //   },
      //   {
      //     title: 'Conference',
      //     start: '2023-01-11',
      //     end: '2023-01-13'
      //   },
      //   {
      //     title: 'Meeting',
      //     start: '2023-01-12T10:30:00',
      //     end: '2023-01-12T12:30:00'
      //   },
      //   {
      //     title: 'Lunch',
      //     start: '2023-01-12T12:00:00'
      //   },
      //   {
      //     title: 'Meeting',
      //     start: '2023-01-12T14:30:00'
      //   },
      //   {
      //     title: 'Happy Hour',
      //     url: 'http://www.dmweblab.com/',
      //     start: '2023-01-12T17:30:00'
      //   },
      //   {
      //     title: 'Dinner',
      //     start: '2023-01-12T20:00:00'
      //   },
      //   {
      //     title: 'Birthday Party',
      //     start: '2023-01-13T07:00:00'
      //   },
      //   {
      //     title: 'Click for Google',
      //     url: 'http://google.com/',
      //     start: '2023-01-28'
      //   }
      // ]
    });

    calendar.render();
  });

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>

<section class="section">
    <div class="row">
      <div class="col">
        <div class="card">
            <div class="card-header">
              <!-- <h4 class="card-title"><?=$settings_all_title?></h4> -->
              <a href="index.php?p=<?=$calendar_setting['add_page']?>" class="btn icon icon-left btn-success"
                        ><i data-feather="plus-circle"></i> Add new event</a
                      >
            </div>
            <div class="card-content">
              <div class="card-body">
                <div id='calendar'></div>
              </div>
            </div>
        </div>
      </div>
    </div>
</section>

