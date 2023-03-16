<?php

?>

<div class="card-header">
    <h4>Manuals</h4>
</div>
<div class="card-content p-4">
    <ul>

    <?php
        foreach (glob("manual/*") as $row) {
        $item=pathinfo($row);
        
        echo '<li><a href="manual/'.$item['basename'].'" target="_blank">'.$item['filename'].'</a></li>';
        
        }
    ?>

    </ul>
</div>