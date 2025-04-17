<?php
require 'db.php'; // Your DB connection

$today = date('Y-m-d');

$sql = "SELECT id, last_translation_reset FROM users";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $lastReset = $row['last_translation_reset'];
    $userId = $row['id'];

    if (!$lastReset || date('m', strtotime($lastReset)) != date('m')) {
        $conn->query("UPDATE users SET monthly_translation_count = 0, last_translation_reset = '$today' WHERE id = $userId");
    }
}

echo "Monthly counters reset successfully.";
?>
