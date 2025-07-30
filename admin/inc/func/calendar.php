<!-- <!DOCTYPE html>
<html>

<head> -->
<meta charset='utf-8' />
<script src='script/index.global.js'></script>
<script src='script/locales-all.global.js'></script>
<!-- </head>

<body> -->

<style>
  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
    background: #f5f5f5;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

  /* Fix per altezza visibile del calendario */
  .fc {
    min-height: 700px;
    /* oppure 600px, regola a piacere */
  }

  .fc .fc-daygrid-day-frame {
    min-height: 100px;
    /* rende ogni giorno visibile */
  }
</style>

<!-- Modale dettaglio evento -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventDetailLabel">Dettagli Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body">
        <p><strong>Titolo:</strong> <span id="detailTitle"></span></p>
        <p><strong>Inizio:</strong> <span id="detailStart"></span></p>
        <p><strong>Fine:</strong> <span id="detailEnd"></span></p>
        <p><strong>Link:</strong> <a href="#" target="_blank" id="detailUrl"></a></p>
      </div>
      <div class="modal-footer">
        <button id="deleteEventBtn" type="button" class="btn btn-danger">Elimina</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!-- Modale conferma eliminazione -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        Sei sicuro di voler eliminare questo evento?
      </div>
      <div class="modal-footer">
        <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Elimina</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
      </div>
    </div>
  </div>
</div>

<!-- Modale inserimento evento -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addEventForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEventLabel">Aggiungi Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="eventTitle" class="form-label">Titolo</label>
          <input type="text" class="form-control" id="eventTitle" name="title" required>
        </div>
        <div class="mb-3">
          <label for="eventStart" class="form-label">Inizio</label>
          <input type="datetime-local" class="form-control" id="eventStart" name="start" required>
        </div>
        <div class="mb-3">
          <label for="eventEnd" class="form-label">Fine</label>
          <input type="datetime-local" class="form-control" id="eventEnd" name="end" required>
        </div>
        <div class="mb-3">
          <label for="eventUrl" class="form-label">Link (opzionale)</label>
          <input type="url" class="form-control" id="eventUrl" name="url">
        </div>
        <div class="mb-3">
          <label class="form-label">Calendario</label><br>
          <div class="row">

            <?php
            $calendar->table = "calendar_cat";
            $stmt = $calendar->showAll('id');
            $calArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $isDefault = $row['id'] == 1 ? 'checked' : '';
            ?>
              <div class="col-2 text-center">
                <input type="radio" class="btn-check" name="calendar_color" value="<?= $row['id'] ?>" id="cal_<?= $row['id'] ?>" <?= $isDefault ?> autocomplete="off" hidden>
                <label class="color-label shadow my-1" for="cal_<?= $row['id'] ?>" style="background-color: <?= $row['cat_color'] ?>;">
                  <span class="checkmark">✔</span>
                </label>
                <span style="color:<?=$row['cat_color']?>; font-weight:bold"><?= $row['cat_name'] ?></span>
              </div>
            <?php
            }
            ?>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salva Evento</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: '<?= $lang ?>',
      headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      initialView: 'dayGridMonth',
      selectable: true,
      events: 'core/get_events.php',

      eventClick: function(info) {
        info.jsEvent.preventDefault(); // previene apertura link

        // riempi modale con dettagli
        var event = info.event;
        document.getElementById('detailTitle').textContent = event.title;
        document.getElementById('detailStart').textContent = event.start.toLocaleString();
        document.getElementById('detailEnd').textContent = event.end ? event.end.toLocaleString() : '';
        var urlEl = document.getElementById('detailUrl');
        if (event.url) {
          urlEl.href = event.url;
          urlEl.textContent = event.url;
          urlEl.style.display = 'inline';
        } else {
          urlEl.style.display = 'none';
        }

        // memorizzo id evento per eliminazione
        window.currentEventId = event.id;

        var eventModal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
        eventModal.show();
      },

      dateClick: function(info) {
        // imposto il form per inserire nuovo evento
        var startInput = document.getElementById('eventStart');
        var endInput = document.getElementById('eventEnd');

        // default ora di inizio = mezzogiorno
        startInput.value = info.dateStr + 'T12:00';
        endInput.value = info.dateStr + 'T13:00';

        var addModal = new bootstrap.Modal(document.getElementById('addEventModal'));
        addModal.show();
      }
    });

    calendar.render();

    // Gestione submit inserimento evento
    document.getElementById('addEventForm').addEventListener('submit', function(e) {
      e.preventDefault();

      var formData = new FormData(this);

      fetch('core/add_event.php', {
          method: 'POST',
          body: formData
        }).then(response => response.json())
        .then(data => {
          if (data.success) {
            calendar.refetchEvents();
            bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
          } else {
            alert('Errore inserimento evento: ' + (data.error || ''));
          }
        });
    });

    // Gestione eliminazione evento
    document.getElementById('deleteEventBtn').addEventListener('click', function() {
      var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
      confirmModal.show();
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
      fetch('core/delete_event.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'id=' + encodeURIComponent(window.currentEventId)
        }).then(response => response.json())
        .then(data => {
          if (data.success) {
            calendar.refetchEvents();
            bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal')).hide();
            bootstrap.Modal.getInstance(document.getElementById('eventDetailModal')).hide();
          } else {
            alert('Errore eliminazione evento: ' + (data.error || ''));
          }
        });
    });

  });
</script>


<div class="card">

  <div class="card-header text-center">
    <div id='calendar'></div>
  </div>
</div>


<!-- </body>

</html> -->