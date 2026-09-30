<?php

declare(strict_types=1);

?>
<div class="card-header">
    <h4><?= htmlspecialchars((string) ($welcome_title ?? 'Welcome'), ENT_QUOTES, 'UTF-8') ?></h4>
</div>
<div class="card-content p-4">
    <?= $welcome_desc1 ?>    
    <a href="https://www.dmweblab.com" target="_blank">
        <?=$welcome_desc2 ?></a>.
</div>