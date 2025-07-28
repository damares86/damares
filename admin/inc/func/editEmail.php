<?php
$email_id = filter_input(INPUT_GET, 'idToMod');
$newsletter->table = "newsletter_messages";
$newsletter->id = $email_id;
$email_stmt = $newsletter->showAllWhere('id', ['id']);
$email_row = $email_stmt->fetch(PDO::FETCH_ASSOC);
extract($email_row);
?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit email</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav
                aria-label="breadcrumb"
                class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit email
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-md-10 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title d-inline">Edit email</h4>
                    <button id="sendBtn" data-message-id="<?= $row['id'] ?>" class="btn btn-info mx-5 me-1 mb-1 shadow">
                        <i class="bi bi-send"></i> Send
                    </button>
                    <!-- <a href="core/mngNewsletter.php?idToSend=<?= $email_id ?>" type="button" class="btn btn-info mx-5 me-1 mb-1 shadow">
                    </a> -->

                    <div id="progressBarContainer" class="my-3" style="display:none;">
                        <div class="progress">
                            <div id="progressBar" class="progress-bar" style="width: 0%">0%</div>
                        </div>
                    </div>

                    <!-- Modale per errori -->
                    <div class="modal fade" id="errorModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Invii Falliti</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <ul id="errorList" class="list-group"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngNewsletter.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Subject<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Email subject"
                                                        id="first-name"
                                                        name="subject"
                                                        value="<?= $email_row['subject'] ?>"
                                                        data-parsley-required="true" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 mt-3">
                                        <label>File Manager </label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <button type="button" class="btn btn-primary me-1 mb-1 shadow" data-bs-toggle="modal" data-bs-target="#fm_modal">
                                            Open
                                        </button>
                                    </div>

                                    <style>
                                        .modal-dialog {
                                            width: 79%;
                                            max-width: 80%;
                                            height: 70%;
                                        }
                                    </style>
                                    <div class="modal fade" id="fm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog" role="document" style="height: 100%;">
                                            <div class="modal-content h-75">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe src='core/tinyfilemanager.php' style="width: 100%; height:100%;">
                                                    </iframe>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 my-3">
                                        <label>Email body <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 my-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <textarea name="body" class="tiny" cols="30" rows="15"><?= $email_row['body'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="operation" value="edit">
                                    <input type="hidden" name="idToMod" value="<?= $email_id ?>">
                                    <input type="hidden" name="origin" value="editEmail">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button
                                            type="submit"
                                            class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                        <button
                                            type="reset"
                                            class="btn btn-light-secondary me-1 mb-1 shadow">
                                            <?= $common_reset ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-12">
            <div class="card shadow">
                <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                <div class="card-content px-5 pb-4">
                    <ul>
                        <li><a href="https://www.dmweblab.com/portal/manual.php?prod=5&page=2" target="_blank"><?= $common_see_guide ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $('#sendBtn').on('click', function() {
        const messageId = $(this).data('message-id');
        $('#progressBarContainer').show();
        $('#progressBar').css('width', '0%').text('0%');

        $.ajax({
            url: 'core/mngSendQueues.php',
            type: 'POST',
            data: {
                message_id: messageId
            },
            success: function(res) {
                let response = JSON.parse(res);
                $('#progressBar').css('width', '100%').text('100%');

                if (response.errors && response.errors.length > 0) {
                    $('#errorList').html('');
                    response.errors.forEach(function(err) {
                        $('#errorList').append('<li class="list-group-item text-danger">' + err.email + ': ' + err.error + '</li>');
                    });
                    $('#errorModal').modal('show');
                } else {
                    alert("Invio completato con successo!");
                }
            },
            error: function() {
                alert('Errore durante l\'invio.');
            }
        });
    });
</script>