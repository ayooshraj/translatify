<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $originalText = $_POST['text'] ?? '';
    $targetLanguage = $_POST['language'] ?? '';

    if (empty($originalText) || empty($targetLanguage)) {
        header("Location: dashboard.php?error=" . urlencode("Missing input or language"));
        exit;
    }

    // Translation using Google Translate API
    $apiKey = 'AIzaSyDe_lWzivEo6E7d_7X7v4iTrwlHH_2ln4c'; // Replace with your actual API key
    $url = "https://translation.googleapis.com/language/translate/v2";

    $postData = [
        'q' => $originalText,
        'target' => $targetLanguage,
        'format' => 'text',
        'key' => $apiKey,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        header("Location: dashboard.php?error=" . urlencode($error));
        exit;
    }

    curl_close($ch);
    $responseData = json_decode($response, true);

    if (!empty($responseData['data']['translations'][0]['translatedText'])) {
        $translatedText = $responseData['data']['translations'][0]['translatedText'];
        header("Location: dashboard.php?translated=" . urlencode($translatedText) . "&original=" . urlencode($originalText));
        exit;
    } else {
        header("Location: dashboard.php?error=" . urlencode("Translation failed"));
        exit;
    }
}

// Optional: handle getLanguages (unchanged from your code)
if (isset($_GET['getLanguages'])) {
    echo json_encode([
        "data" => [
            "languages" => [
                ["language" => "en", "name" => "English"],
                ["language" => "es", "name" => "Spanish"],
                ["language" => "hi", "name" => "Hindi"],
                ["language" => "fr", "name" => "French"],
                ["language" => "de", "name" => "German"],
                ["language" => "zh", "name" => "Chinese"],
            ]
        ]
    ]);
    exit;
}
