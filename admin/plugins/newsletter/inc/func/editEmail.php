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
            <h3><?=$editemail_header?></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?=$editemail_header?>
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
                    <h4 class="card-title d-inline"><?=$editemail_title?></h4>

                    <?php if ($status == 0): ?>
                        <button id="sendBtn" data-message-id="<?= $email_row['id'] ?>" class="btn btn-info mx-5 me-1 mb-1 shadow">
                            <i class="bi bi-send"></i> <?=$editemail_send?>
                        </button>
                        <button id="retryBtn" data-message-id="<?= $email_row['id'] ?>" class="btn btn-warning mx-5 me-1 mb-1 shadow" style="display:none;">
                            <i class="bi bi-arrow-clockwise"></i> <?=$editemail_retry?>
                        </button>
                    <?php elseif ($status == 1): ?>
                        <?php
                        // Controlla se ci sono fallimenti per questo messaggio
                        $fail_check = $db->prepare("SELECT COUNT(*) FROM newsletter_queue WHERE message_id = ? AND status = 'failed'");
                        $fail_check->execute([$email_id]);
                        $fail_count = $fail_check->fetchColumn();
                        ?>

                        <?php if ($fail_count > 0): ?>
                            <button id="retryBtn" data-message-id="<?= $email_row['id'] ?>" class="btn btn-warning mx-5 me-1 mb-1 shadow">
                                <i class="bi bi-arrow-clockwise"></i> <?=$editemail_retry?>
                            </button>
                            <button id="showErrorsBtn" data-message-id="<?= $email_row['id'] ?>" class="btn btn-danger mx-2 mb-1 shadow" data-bs-toggle="modal" data-bs-target="#errorModal">
                                <?=$editemail_show_error?>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>



                    <style>
                        #progressBarContainer {
                            display: none;
                            margin-top: 1rem;
                            background-color: #e9ecef;
                            border-radius: 0.25rem;
                            overflow: hidden;
                            height: 25px;
                            position: relative;
                        }

                        #progressBar {
                            height: 100%;
                            width: 0%;
                            background-color: #0d6efd;
                            transition: width 0.4s ease;
                        }

                        #progressText {
                            position: absolute;
                            width: 100%;
                            text-align: center;
                            top: 0;
                            left: 0;
                            color: white;
                            font-weight: bold;
                            line-height: 25px;
                            user-select: none;
                        }
                    </style>

                    <div id="progressBarContainer">
                        <div id="progressBar"></div>
                        <div id="progressText">0%</div>
                    </div>

                    <button id="showErrorsBtn" data-message-id="<?= $email_row['id'] ?>" class="btn btn-danger mt-2" style="display:none;" data-bs-toggle="modal" data-bs-target="#errorModal">
                        <?=$editemail_show_error?>
                    </button>

                    <div class="modal fade" id="errorModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?=$editemail_failed?></h5>
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
                                        <label><?=$editemail_subject?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="subject" value="<?= $email_row['subject'] ?>" required />
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label><?=$file_fm?></label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <button type="button" class="btn btn-primary me-1 mb-1 shadow" data-bs-toggle="modal" data-bs-target="#fm_modal"><?=$file_fm_open?></button>
                                    </div>

                                    <div class="modal fade" id="fm_modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" style="width: 80%; max-width: 80%; height: 70%;">
                                            <div class="modal-content h-75">
                                                <div class="modal-body">
                                                    <iframe src='core/tinyfilemanager.php' style="width: 100%; height:100%;"></iframe>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$common_close?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 my-3">
                                        <label><?=$editemail_body?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 my-3">
                                        <textarea name="body" class="tiny" cols="30" rows="15" data-parsley-required="true"><?= $email_row['body'] ?></textarea>
                                    </div>

                                    <input type="hidden" name="operation" value="edit">
                                    <input type="hidden" name="idToMod" value="<?= $email_id ?>">
                                    <input type="hidden" name="origin" value="editEmail">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow"><?= $common_submit ?></button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow"><?= $common_reset ?></button>
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
                        <li><a href="https://www.dmweblab.com/portal/manual.php?prod=4&page=7" target="_blank"><?= $common_see_guide ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function sendNewsletter(messageId, isRetry = false) {
        const batchSize = 10;
        let total = 0;
        let processed = 0;

        $('#progressBarContainer').show();
        $('#progressBar').css('width', '0%');
        $('#progressText').text('0%');

        const startSend = () => {
            function sendBatch() {
                $.post('core/sendBatch.php', {
                    message_id: messageId,
                    batch_size: batchSize
                }, function(res) {
                    processed += res.sent + res.failed;
                    const perc = Math.min(Math.round((processed / total) * 100), 100);
                    $('#progressBar').css('width', perc + '%');
                    $('#progressText').text(`${perc}% (${processed} / ${total})`);

                    if (res.failed > 0) {
                        $('#showErrorsBtn').show();
                    }

                    if (res.remaining > 0) {
                        setTimeout(sendBatch, 300);
                    } else {
                        $('#progressBar').css('width', '100%');
                        $('#progressText').text(`100% (${total} / ${total})`);

                        // Elimina i sent
                        $.post('core/deleteSent.php', {
                            message_id: messageId
                        });

                        // Aggiorna lo status della newsletter a "inviata"
                        $.post('core/updateNewsletterStatus.php', {
                            message_id: messageId
                        });

                        $('#sendBtn').hide();

                        if (res.failed > 0) {
                            $('#retryBtn').show();
                            $('#showErrorsBtn').show();
                        }

                        setTimeout(() => {
                            if (res.failed > 0) {
                                alert('<?=$editemail_sent_errors?>');
                            } else {
                                alert('<?=$editemail_sent_ok?>');
                            }
                        }, 300);
                    }
                }, 'json').fail(() => {
                    alert('<?=$editemail_errbatch?>');
                });
            }

            sendBatch();
        };

        if (!isRetry) {
            $.post('core/prepareQueue.php', {
                message_id: messageId
            }, function(res) {
                total = parseInt(res.total, 10);
                if (!total || total === 0) {
                    alert('<?=$editemail_nosub?>');
                    $('#progressBarContainer').hide();
                    return;
                }
                $('#progressText').text(`0% (0 / ${total})`);
                startSend();
            }, 'json');
        } else {
            $.post('core/retryFailed.php', {
                message_id: messageId
            }, function(res) {
                total = parseInt(res.total, 10);
                if (!total || total === 0) {
                    alert('<?=$editemail_nosub_retry?>');
                    $('#progressBarContainer').hide();
                    return;
                }
                $('#progressText').text(`0% (0 / ${total})`);
                startSend();
            }, 'json');
        }
    }

    $('#sendBtn').on('click', function() {
        const messageId = $(this).data('message-id');
        if (!messageId) return alert("<?=$editemail_no_id?>");
        sendNewsletter(messageId);
    });

    $('#retryBtn').on('click', function() {
        const messageId = $(this).data('message-id');
        if (!messageId) return alert("<?=$editemail_no_id?>");
        $(this).hide();
        sendNewsletter(messageId, true);
    });

    $('#showErrorsBtn').on('click', function() {
        const messageId = $(this).data('message-id');
        if (!messageId) return alert("<?=$editemail_no_id?>");
        $.post('core/getFailedEmails.php', {
            message_id: messageId
        }, function(res) {
            $('#errorList').html('');
            if (res.failed?.length) {
                res.failed.forEach(email => {
                    $('#errorList').append(`<li class="list-group-item text-danger">${email}</li>`);
                });
            } else {
                $('#errorList').append(`<li class="list-group-item">Nessun errore trovato.</li>`);
            }
        }, 'json');
    });
</script>
