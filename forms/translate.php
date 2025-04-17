<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once(__DIR__ . '/../config/db.php');

$user_id = $_SESSION['user_id'];
$text = trim($_POST['text'] ?? '');
$language = trim($_POST['language'] ?? '');

if (empty($text) || empty($language)) {
    header("Location: dashboard.php?error=missing_input");
    exit();
}

// === DUMMY TRANSLATION FUNCTION ===
// You can later replace this with real API call
function dummyTranslate($text, $language) {
    return strtoupper($text) . " [$language]";
}

$translatedText = dummyTranslate($text, $language);

try {
    $stmt = $conn->prepare("INSERT INTO translations (user_id, original_text, translated_text, language, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $text, $translatedText, $language]);

    header("Location: dashboard.php?success=true");
    exit();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
