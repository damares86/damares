<?php
$newsletter->table = 'newsletter_settings';
$stmt = $newsletter->showAll('id');

$newsletter_settings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    extract($row);
    $newsletter_settings[$row['name']] = $row['value'];
}

?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?=$newsset_header?></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?=$newsset_header?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?=$newsset_general?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngNewsletterSettings.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label><?=$newsset_confirm?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <?php
                                                    $checked = $newsletter_settings['confirmation'] == 1 ? ' checked' : '';
                                                    ?>
                                                    <input type="checkbox" class="form-check-input" name="confirmation" <?= $checked ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="operation" value="settings">
                                    <input type="hidden" name="origin" value="allNewletterSettings">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow">
                                            <?= $common_reset ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?=$newsset_mail?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngNewsletterSettings.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-3">
                                        <label><?=$common_email?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        placeholder="Email subject"
                                                        id="first-name"
                                                        name="email"
                                                        data-parsley-required="true"
                                                        value="<?= $newsletter_settings['email'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?= $common_password ?></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group has-icon-left">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="password"
                                                        placeholder="Write only if it's changed"
                                                        name="password" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                    <div class="toggle-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                                        <i class="bi bi-eye" id="togglePassword"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$newsset_name?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Email name"
                                                        id="first-name"
                                                        name="name"
                                                        data-parsley-required="true"
                                                        value="<?= $newsletter_settings['name'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>SMTP host <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Host"
                                                        id="first-name"
                                                        name="host"
                                                        data-parsley-required="true"
                                                        value="<?= $newsletter_settings['host'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>SMTP secure <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="ex. SSL"
                                                        id="first-name"
                                                        name="secure"
                                                        data-parsley-required="true"
                                                        value="<?= $newsletter_settings['secure'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>SMTP port <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Port number"
                                                        id="first-name"
                                                        name="port"
                                                        data-parsley-required="true"
                                                        value="<?= $newsletter_settings['port'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="operation" value="mail">
                                    <input type="hidden" name="origin" value="allNewletterSettings">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow">
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

        <div class="col-md-4 col-12">
            <div class="card shadow">
                <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                <div class="card-content px-5 pb-4">
                    <ul>
                        <li><a href="https://www.dmweblab.com/portal/manual.php?prod=4&page=8" target="_blank"><?= $common_see_guide ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = this;

        // Controlla il tipo di input e cambia tra password e text
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('bi-eye');
            passwordIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('bi-eye-slash');
            passwordIcon.classList.add('bi-eye');
        }

        const passwordConfirmInput = document.getElementById('password_confirm');
        const passwordConfirmIcon = this;

        // Controlla il tipo di input e cambia tra password e text
        if (passwordConfirmInput.type === 'password') {
            passwordConfirmInput.type = 'text';
            passwordConfirmInput.classList.remove('bi-eye');
            passwordConfirmInput.classList.add('bi-eye-slash');
        } else {
            passwordConfirmIcon.type = 'password';
            passwordConfirmIcon.classList.remove('bi-eye-slash');
            passwordConfirmIcon.classList.add('bi-eye');
        }
    });
</script>