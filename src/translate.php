<?php
header("Content-Type: application/json");

// Load API key from config
$config = require __DIR__ . "/config.php";
$apiKey = $config["api_key"];

// Handle language list request (GET)
if (isset($_GET['getLanguages'])) {
    $url = "https://translation.googleapis.com/language/translate/v2/languages?key=" . urlencode($apiKey) . "&target=en";
    echo file_get_contents($url);
    exit;
}

// Only accept POST requests for translation.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method."]);
    exit;
}

// Get input data from POST
$text     = $_POST["text"] ?? "";
$source   = $_POST["source"] ?? "auto";  // "auto" means auto-detect
$target   = $_POST["target"] ?? "en";      // Default target language is English
$regional = $_POST["regional"] ?? "false"; // "true" or "false"

if (!$text) {
    echo json_encode(["error" => "Please enter text to translate."]);
    exit;
}

// Prepare data for API request.
// Omit the source parameter if auto-detect is desired.
$data = [
    "q"      => $text,
    "target" => $target,
    "format" => "text"
];
if ($source !== "auto") {
    $data["source"] = $source;
}

// Build the Google Translate API URL
$url = "https://translation.googleapis.com/language/translate/v2?key=" . urlencode($apiKey);

// Initialize cURL for a POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode(["error" => "Translation API request failed."]);
    exit;
}

$result = json_decode($response, true);

if (isset($result["data"]["translations"][0]["translatedText"])) {
    $translatedText = $result["data"]["translations"][0]["translatedText"];
    
    // If regional phrases are enabled, apply the dictionary.
    if ($regional === "true") {
        $regionalDictionary = [
            "How are you?" => "How's it going, mate?",
            "Goodbye"      => "Cheerio"
            // Add more phrase mappings as needed.
        ];
        foreach ($regionalDictionary as $standard => $regionalReplacement) {
            $translatedText = str_replace($standard, $regionalReplacement, $translatedText);
        }
    }
    
    echo json_encode(["translatedText" => $translatedText]);
} else {
    echo json_encode(["error" => "Translation failed."]);
}
?>
