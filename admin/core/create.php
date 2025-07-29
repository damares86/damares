<?php
require __DIR__ . "/coreConfig.php";

for ($i = 1; $i <= 500; $i++) {
    $email = "testuser{$i}@example.com";
    $name = "Test User {$i}";

    $stmt = $db->prepare("INSERT IGNORE INTO newsletter_subscribers (email, name, confirmed) VALUES (?, ?, 1)");
    $stmt->execute([$email, $name]);
}