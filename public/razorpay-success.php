<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require 'config/db.php'; // ✅ fixed path

$data = json_decode(file_get_contents("php://input"), true);
file_put_contents('razorpay-log.txt', json_encode($data, JSON_PRETTY_PRINT), FILE_APPEND);

if (isset($data['payment_id']) && isset($data['user_id'])) {
    $payment_id = $data['payment_id'];
    $user_id = intval($data['user_id']);

    try {
        // Log the values you're about to insert
        file_put_contents('razorpay-log.txt', "Trying to update user $user_id with payment $payment_id\n", FILE_APPEND);

        $stmt = $pdo->prepare("UPDATE users SET plan = 'pro', payment_id = :payment_id WHERE id = :user_id");
        $stmt->execute([
            ':payment_id' => $payment_id,
            ':user_id' => $user_id
        ]);

        if ($stmt->rowCount() > 0) {
            file_put_contents('razorpay-log.txt', "✅ Update success\n", FILE_APPEND);
            echo json_encode(['status' => 'success', 'message' => 'Plan upgraded to Pro']);
        } else {
            file_put_contents('razorpay-log.txt', "❌ No rows updated\n", FILE_APPEND);
            echo json_encode(['status' => 'fail', 'message' => 'No user found or already updated']);
        }
    } catch (PDOException $e) {
        file_put_contents('razorpay-log.txt', "❌ DB error: " . $e->getMessage() . "\n", FILE_APPEND);
        echo json_encode(['status' => 'fail', 'message' => 'DB error: ' . $e->getMessage()]);
    }
} else {
    file_put_contents('razorpay-log.txt', "❌ Missing data\n", FILE_APPEND);
    echo json_encode(['status' => 'fail', 'message' => 'Missing payment_id or user_id']);
}
?>
