<?php
$host = 'localhost';
$db   = 'translatify';
$user = 'root';
$pass = ''; // default password is empty unless you've set it

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}
?>
