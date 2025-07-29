<?php if(filter_input(INPUT_GET, "msg")): ?>
  <?php
    $msg = filter_input(INPUT_GET, "msg");
    $alert_label = "msg_$msg";
  ?>
  <div class="alert alert-success d-flex align-items-center alert-dismissible fade show shadow-sm" role="alert">
    <!-- <i class=" bi-check-circle-fill me-2 fs-5"></i> -->
    <div class="flex-grow-1">
      <?= $$alert_label ?>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if(filter_input(INPUT_GET, "err")): ?>
  <?php
    $err = filter_input(INPUT_GET, "err");
    $alert_label = "err_$err";
  ?>
  <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show shadow-sm" role="alert">
    <!-- <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> -->
    <div class="flex-grow-1">
      <?= $$alert_label ?>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
