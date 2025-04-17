<?php
require('vendor/autoload.php');
use Razorpay\Api\Api;

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$plan = $input['plan'] ?? '';

// Define pricing
$pricing = [
  'pro' => 1500,        // ₹15.00 in paise
  'enterprise' => 4900  // ₹49.00 in paise
];

if (!isset($pricing[$plan])) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid plan selected']);
  exit;
}

$amount = $pricing[$plan];

// 🔐 Your Razorpay keys
$api = new API('API key 1', 'API key 2');

$order = $api->order->create([
  'receipt' => uniqid("order_"),
  'amount' => $amount,
  'currency' => 'INR',
  'payment_capture' => 1
]);

echo json_encode([
  'order_id' => $order['id'],
  'amount' => $amount
]);
