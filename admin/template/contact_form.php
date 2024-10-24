<?php

    $json_file = 'admin/inc/pages/2.json';
    $data = file_get_contents($json_file);
    $json_arr = json_decode($data, true);

    ?>
    <div id="content" class="container">
    <?php
    $counter=$page_counter;

    if (isset($_SESSION['loggedin'])) {
    ?>
        <div class="text-right">

            <a href="admin/index.php?p=editDefaultPage&idToMod=<?= $page_id ?>&count=<?= $counter ?>" class="btn btn-primary btn-sm"><b>Modifica</b></a>
        </div>
    <?php
    }
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

                        <h3 class="mb-3">Contattaci</h3>

                        <form method="POST" class="my-login-validation" novalidate="" action="admin/core/<?= $send ?>.php">
                            <div class="form-group">
                                <label for="name">Il tuo nome</label>
                                <input id="name" class="form-control" name="name" value="" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="email">La tua email</label>
                                <input id="email" class="form-control" name="email" value="" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="contact">Scrivi a (scegli un'opzione):</label>
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
                                <label for="subject">Oggetto</label>
                                <input id="subject" class="form-control" name="subject" value="" required autofocus>

                            </div>
                            <div class="form-group">
                                <label for="message">Il tuo messaggio:</label>
                                <textarea id="message" name="message" placeholder="Scrivi qui il tuo messaggio"></textarea>
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
    </div>
</div>