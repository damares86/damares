<?php
$newsletter->table = "newsletter_messages";
$subscribers = $newsletter->showAll('created_at');

?>


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>All emails</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        All emails
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
    <div class="card shadow">
        <div class="card-header">Emails &nbsp; &nbsp; &nbsp;
            <a href="index.php?p=addEmail" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add an email</a>
        </div>
        <div class="card-body">

            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Created at</th>
                        <th><?= $common_actions ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    while ($row = $subscribers->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                    ?>
                        <tr>
                            <td><?= $row['subject'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <?php
                                $newsletter->table = "newsletter_queue";
                                $newsletter->id = $row['id'];
                                $stmt1 = $newsletter->showAllWhere('id', ['id']);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

                                if ($row1['status'] != 'sent') {
                                ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#send<?= $row['id'] ?>" class="btn icon btn-primary shadow edit-link">
                                        <i class="bi bi-send"></i>
                                    </a>

                                    &nbsp; &nbsp;

                                    <!--Send theme Modal -->
                                    <div class="modal fade text-left" id="send<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel120">
                                                        <?= $common_modal_title_sure ?>
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Vuoi inviare questa mail? Non potrai chiudere la pagina fino a invio completato.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                                    </button>
                                                    <span class="d-none d-sm-block"><a href="core/mngSendQueues.php?idToSend=<?= $row['id'] ?>" class="btn btn-primary ml-1">
                                                            <?= $common_modal_confirm ?>
                                                        </a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="index.php?p=editEmail&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning shadow edit-link" data-base-url="index.php?p=editEmail&idToMod=<?= $row['id'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    &nbsp; &nbsp;
                                <?php
                                }
                                ?>
                                <a href="#" class="btn icon btn-info shadow" data-bs-toggle="modal" data-bs-target="#clone<?= $row['id'] ?>"><i class="bi bi-files"></i></a>
                                &nbsp; &nbsp;
                                <!--Clone theme Modal -->
                                <div class="modal fade text-left" id="clone<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <h5 class="modal-title white" id="myModalLabel120">
                                                    Clone
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form form-horizontal" action="core/mngNewsletter.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label>New subject <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <div class="form-check mandatory">
                                                                        <div class="position-relative">
                                                                            <input type="text" class="form-control" placeholder="" id="name" name="subject" data-parsley-required="true" value="<?= $row['subject'] ?>" />
                                                                            <!-- <input type="text"
                                                                                class="form-control"
                                                                                placeholder=""
                                                                                id="subject<?= $row['id'] ?>"
                                                                                name="subject"
                                                                                data-parsley-required="true"
                                                                                data-parsley-notequalto="#original<?= $row['id'] ?>"
                                                                                value="<?= htmlspecialchars($row['subject']) ?>" /> -->

                                                                            <input type="hidden" id="original<?= $row['id'] ?>" value="<?= htmlspecialchars($row['subject']) ?>" />

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="operation" value="clone">
                                                            <input type="hidden" name="origin" value="allEmails">
                                                            <input type="hidden" name="idToClone" value="<?= $row['id'] ?>">

                                                            <div class="col-12 d-flex justify-content-end">
                                                                <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow" data-bs-dismiss="modal">
                                                                    <?= $common_modal_cancel ?>
                                                                </button>
                                                                <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                                                    <?= $common_submit ?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><i class="bi bi-trash"></i>
                                </a>


                                <!--Danger theme Modal -->
                                <div class="modal fade text-left" id="danger<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title white" id="myModalLabel120">
                                                    <?= $common_modal_title_sure ?>
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Se confermi questa email verrà eliminata definitivamente
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                                </button>
                                                <span class="d-none d-sm-block"><a href="core/mngNewsletter.php?idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1">
                                                        <?= $common_modal_confirm ?>
                                                    </a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>




                    <?php
                    }

                    ?>



                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('form[data-parsley-validate]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const input = form.querySelector('input[name="subject"]');
            const original = form.querySelector('input[type="hidden"][id^="original"]');
            if (input.value.trim() === original.value.trim()) {
                alert("Il subject deve essere diverso da quello originale.");
                e.preventDefault();
            }
        });
    });
</script>