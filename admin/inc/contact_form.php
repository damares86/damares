<?php

$json_file = 'admin/inc/pages/contact.json';
$data = file_get_contents($json_file);
$json_arr = json_decode($data, true);

?>
<div id="contact">
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="row address">
                <div class="col-12">
                    <?php
                    echo $json_arr[1]['block1'];
                    ?>
                </div>
                <div class="col-12 maps">
                    <?php
                    echo $json_arr[2]['block2'];
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="card-body">
                <?php
                require "admin/template/inc/alert.php";

                $send = "mngMail";
                if ($recap) {
                    $send = "mngMailRecap";
                }


                ?>

                <h3 class="mb-3"><?=$contact_title?></h3>

                <form method="POST" class="my-login-validation" novalidate="" action="admin/core/<?= $send ?>.php">
                    <div class="form-group">
                        <label for="name"><?=$contact_name?></label>
                        <input id="name" class="form-control" name="name" value="" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="email"><?=$contact_email?></label>
                        <input id="email" class="form-control" name="email" value="" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="contact"><?=$contact_choose?>:</label>
                        <select name="contact">
                            <?php
                            $mc->table = "mc_contacts";

                            $stmt1 = $mc->showAll('id');
                            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                extract($row1);

                                echo "<option value='" . $row1['email'] . "'>" . $row1['label'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject"><?=$contact_subject?></label>
                        <input id="subject" class="form-control" name="subject" value="" required autofocus>

                    </div>
                    <div class="form-group">
                        <label for="message"><?=$contact_message?>:</label>
                        <textarea id="message" name="message" placeholder="<?=$contact_message?>"></textarea>
                    </div>

                    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                    <br>

                    <div class="form-group m-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            <?= $common_submit ?>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>