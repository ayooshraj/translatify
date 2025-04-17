<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once(__DIR__ . '/../config/db.php');

$user_id = $_SESSION['user_id'];

// Dummy Data (Replace with dynamic logic)
$totalTranslations = 14;
$totalCharsToday = 400;
$charLimit = 5000;
$translationHistory = []; // Replace with DB fetch

// Fetch user plan from DB
require_once(__DIR__ . '/../config/db.php');

$user_id = $_SESSION['user_id'] ?? null;
$user_plan = 'Free'; // default fallback

if ($user_id) {
    try {
        $stmt = $pdo->prepare("SELECT plan FROM users WHERE id = :id");
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && !empty($user['plan'])) {
            $user_plan = ucfirst($user['plan']); // capitalize: free → Free, pro → Pro
        }
    } catch (PDOException $e) {
        $user_plan = 'Unknown'; // fallback if DB fails
    }
} else {
    // redirect or show login prompt if not logged in
    header('Location: login.php');
    exit;
}


?>


<!DOCTYPE html>
<html lang="en" class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
<head>
    <meta charset="UTF-8">
    <title>Translatify Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script>
  // Fetch languages and populate dropdowns
  function fetchLanguages() {
    fetch("../src/translate.php?getLanguages=true")
      .then(response => response.json())
      .then(data => {
        const sourceSelect = document.getElementById("source");
        const targetSelect = document.getElementById("target");

        // Clear current options
        sourceSelect.innerHTML = `<option value="auto">Detect Language</option>`;
        targetSelect.innerHTML = "";

        data.data.languages.forEach(lang => {
          let option = document.createElement("option");
          option.value = lang.language;
          option.textContent = lang.name;
          // Append to both selects
          sourceSelect.appendChild(option.cloneNode(true));
          targetSelect.appendChild(option.cloneNode(true));
        });
      })
      .catch(error => console.error("Error fetching languages:", error));
  }

  // Handle translation
  function translateText() {
    const text = document.getElementById("text").value;
    const source = document.getElementById("source").value;
    const target = document.getElementById("target").value;
    const regional = document.getElementById("regionalToggle").checked ? "true" : "false";

    const params = `text=${encodeURIComponent(text)}&source=${encodeURIComponent(source)}&target=${encodeURIComponent(target)}&regional=${encodeURIComponent(regional)}`;

    fetch("../src/translate.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: params
    })
    .then(response => response.json())
    .then(data => {
      document.getElementById("result").innerText =
        data.translatedText || "Error: Unable to translate";
    })
    .catch(error => console.error("Error:", error));
  }

  // Run fetchLanguages on page load
  window.onload = function () {
    fetchLanguages();
  };
</script>
    <style>
  .dot {
    transform: translateX(0);
  }
  input:checked ~ .dot {
    transform: translateX(24px);
  }
</style>

</head>
<body class="flex">

<!-- Sidebar -->
<aside class="w-64 h-screen bg-white dark:bg-gray-800 border-r dark:border-gray-700 fixed">
    <div class="p-6">
        <h1 class="text-xl font-bold text-blue-600 dark:text-blue-400">Translatify</h1>
        <nav class="mt-6 space-y-3">
            <a href="#" class="block text-sm font-medium dark:text-white hover:text-blue-500">🏠 Dashboard</a>
            <a href="#translate" class="block text-sm font-medium dark:text-white hover:text-blue-500">📝 Translate</a>
            <a href="#history" class="block text-sm font-medium dark:text-white hover:text-blue-500">📜 History</a>
            <a href="#export" class="block text-sm font-medium dark:text-white hover:text-blue-500">🧾 Export</a>
            <a href="#premium" class="block text-sm font-medium dark:text-white hover:text-blue-500">💳 Premium</a>
            <a href="#api" class="block text-sm font-medium dark:text-white hover:text-blue-500">🛡️ API Access</a>
            <a href="#settings" class="block text-sm font-medium dark:text-white hover:text-blue-500">⚙️ Settings</a>
            <a href="logout.php" class="block text-sm font-medium dark:text-white text-red-500">🚪 Logout</a>
        </nav>
        <div class="mt-6">
  <label for="toggleTheme" class="flex items-center cursor-pointer">
    <div class="relative">
      <input type="checkbox" id="toggleTheme" class="sr-only">
      <div class="block bg-gray-300 dark:bg-gray-600 w-14 h-8 rounded-full transition-colors duration-300"></div>
      <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-300"></div>
    </div>
    <div class="ml-3 text-sm text-gray-600 dark:text-gray-300">Dark Mode</div>
  </label>
</div>

    </div>
</aside>

<!-- Main Content -->
<main class="ml-64 flex-1 p-10 bg-gray-50 dark:bg-gray-900 min-h-screen">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl dark:text-white font-bold">Welcome back 👋</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Ready to translate something amazing?</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700">
            <h3 class="text-sm text-gray-600 dark:text-gray-400">Total Translations</h3>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400"><?= $totalTranslations ?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700">
            <h3 class="text-sm text-gray-600 dark:text-gray-400">Characters Used Today</h3>
            <div class="flex items-center justify-between">
                <p class="text-2xl font-bold text-green-600"><?= $totalCharsToday ?>/<?= $charLimit ?></p>
                <div class="w-32 h-2 bg-gray-200 dark:bg-gray-600 rounded">
                    <div class="h-2 bg-green-500 rounded" style="width: <?= ($totalCharsToday / $charLimit) * 100 ?>%"></div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700">
            <h3 class="text-sm text-gray-600 dark:text-gray-400">Plan</h3>
            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Current Plan: <span class="text-green-600"><?php echo htmlspecialchars($user_plan); ?></span></h2>
            </div>

        </div>
    </div>
    

    <!-- Translate Section -->
    <h2 class="text-xl font-semibold dark:text-white mb-4 flex items-center gap-2">
  🌍 Translatify
  <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">Beta</span>
</h2>

<form onsubmit="translateText(); return false;">
  <label for="text" class="block text-gray-700 dark:text-white font-medium mb-2">Enter Text</label>
  <textarea id="text" maxlength="500" placeholder="Type something to translate..." class="w-full p-4 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 mb-4" rows="5"></textarea>

  <div class="flex flex-col sm:flex-row gap-4 mb-4">
    <div class="w-full">
      <label for="source" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">From</label>
      <select id="source" class="w-full p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <!-- Options will be populated dynamically -->
      </select>
    </div>
    <div class="w-full">
      <label for="target" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">To</label>
      <select id="target" class="w-full p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <!-- Options will be populated dynamically -->
      </select>
    </div>
  </div>

  <div class="flex items-center mb-4">
    <input type="checkbox" id="regionalToggle" class="mr-2 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-400"/>
    <label for="regionalToggle" class="text-sm text-gray-700 dark:text-gray-300">Enable Regional Phrases</label>
  </div>

  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 w-full sm:w-auto">
    🔁 Translate
  </button>
</form>

<div id="result" class="mt-6 text-base font-medium text-gray-800 dark:text-white min-h-[3rem]">
  <!-- Translated text appears here -->
</div>

<div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
  Need help? <a href="mailto:support@translatify.app" class="text-blue-600 hover:underline">Contact Support</a>
</div>



    <!-- History -->
    <section id="history" class="mb-16">
        <h2 class="text-xl font-semibold mb-4">Translation History</h2>
        <div class="overflow-auto bg-white dark:bg-gray-800 rounded shadow border dark:border-gray-700">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-300">
                        <th class="p-3">Original</th>
                        <th class="p-3">Language</th>
                        <th class="p-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($translationHistory)): ?>
                    <tr><td colspan="3" class="p-4 text-gray-500 dark:text-gray-400 text-center">No translations yet.</td></tr>

                <?php else: foreach ($translationHistory as $row): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="p-3"><?= htmlspecialchars($row['original_text']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['language']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Export -->
    <section id="export" class="mb-16 bg-white dark:bg-gray-800 p-6 rounded shadow border dark:border-gray-700">
        <h2 class="text-xl dark:text-white font-semibold mb-4">Export Translations</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Download recent translations as CSV or PDF (Free plan has limits).</p>
        <div class="flex gap-4">
            <a href="export_csv.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Export CSV</a>
            <a href="export_pdf.php" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Export PDF</a>
        </div>
    </section>

    <!-- Premium Promo -->
    <section id="premium" class="mb-16 p-6 bg-gradient-to-r from-yellow-400 to-pink-500 text-white rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-2">Unlock Premium 🚀</h2>
        <p class="mb-4">Translate large docs, access API, use tones, and more powerful features. Starting at just ₹99/month!</p>
        <!-- Upgrade Button -->
<!-- Add this inside your HTML file (e.g., dashboard.php) -->

<!-- Razorpay Button -->
<button id="payBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
  Upgrade to Pro
</button>

<!-- Inject user_id from PHP -->
<script>
const USER_ID = <?php echo json_encode($_SESSION['user_id']); ?>;
</script>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<!-- Your Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const payBtn = document.getElementById('payBtn');
    if (!payBtn) {
        console.error("❌ payBtn not found in DOM");
        return;
    }

    payBtn.onclick = function (e) {
        const options = {
            key: "rzp_test_me27YCOcUrrKF9",
            amount: 1290 * 100,
            currency: "INR",
            name: "Translatify Pro Plan",
            description: "5,000 translations/month",
            handler: function (response) {
                fetch('razorpay-success.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        payment_id: payment_id,
                        user_id: loggedInUserId,
                    }),
                })
                .then(res => res.json())
                .then(console.log)
                .catch(err => console.error("Fetch error:", err));

            },
            theme: { color: "#3399cc" }
        };
        const rzp = new Razorpay(options);
        rzp.open();
        e.preventDefault();
    };
});
</script>





    </section>

    <!-- Profile Settings -->
    <section id="settings" class="mb-16 bg-white dark:bg-gray-800 p-6 rounded shadow border dark:border-gray-700">
        <h2 class="text-xl dark:text-white font-semibold mb-4">Profile Settings</h2>
        <form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="Name" class="p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500">
                <input type="email" name="email" placeholder="Email" class="p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500">
                <input type="password" name="password" placeholder="New Password" class="p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500">
                <select name="language" class="p-3 rounded border dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    <option value="">Preferred Language</option>
                    <option value="en">English</option>
                    <option value="hi">Hindi</option>
                    <option value="es">Spanish</option>
                </select>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Save Changes</button>
        </form>
    </section>

</main>

<script>
    // Dark Mode Toggle
    document.getElementById('toggleTheme').onclick = () => {
        document.documentElement.classList.toggle('dark');
    };
</script>
<script>
    const toggleSwitch = document.getElementById('toggleTheme');

    // Check for dark mode on page load
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
        toggleSwitch.checked = true;
    }

    toggleSwitch.addEventListener('change', function () {
        if (this.checked) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    });
</script>


</body>
</html>
