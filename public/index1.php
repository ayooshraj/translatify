<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Translatify – Smart Regional Translator</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <!-- Translator Functionality Script -->
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

</head>
<body onload="fetchLanguages()" class="bg-gradient-to-br from-blue-100 via-purple-100 to-indigo-200 min-h-screen text-gray-800">

  <!-- HEADER (optional if you have one) -->
  <header class="w-full py-6 px-8 bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold text-blue-600">🌍 Translatify</h1>
      <nav class="space-x-4 text-sm">
        <a href="#features" class="text-gray-600 hover:text-blue-600">Features</a>
        <a href="#pricing" class="text-gray-600 hover:text-blue-600">Pricing</a>
        <a href="#testimonials" class="text-gray-600 hover:text-blue-600">Testimonials</a>
        <a href="#contact" class="text-gray-600 hover:text-blue-600">Contact</a>
      </nav>
    </div>
  </header>

  <!-- TRANSLATOR PANEL SECTION -->
  <section class="flex flex-col lg:flex-row items-center justify-between w-full max-w-7xl mx-auto px-4 py-16">
    <!-- LEFT INFO -->
    <div class="lg:w-1/2 w-full mb-12 lg:mb-0">
      <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-6 leading-tight">
        Break Language Barriers<br />
        <span class="text-blue-600">with Translatify</span>
      </h2>
      <p class="text-gray-700 text-lg mb-6">
        Translate any text in real-time with intelligent <span class="font-semibold text-blue-600">Regional Phrase Support</span> — powered by Google APIs and tuned to feel native across languages and dialects.
      </p>

      <div class="space-y-4">
        <div class="flex items-start gap-3">
          <div class="bg-blue-100 text-blue-700 p-2 rounded-full">🌍</div>
          <div>
            <h3 class="font-semibold text-gray-800">Smart Language Detection</h3>
            <p class="text-sm text-gray-600">Automatically detects source language and adjusts tone regionally.</p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="bg-purple-100 text-purple-700 p-2 rounded-full">✨</div>
          <div>
            <h3 class="font-semibold text-gray-800">Regional Slang Awareness</h3>
            <p class="text-sm text-gray-600">More than direct translation — understand and speak like locals do.</p>
          </div>
        </div>
        <div class="flex items-start gap-3">
          <div class="bg-indigo-100 text-indigo-700 p-2 rounded-full">⚡</div>
          <div>
            <h3 class="font-semibold text-gray-800">Instant Results</h3>
            <p class="text-sm text-gray-600">Fast and accurate translations powered by robust APIs.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- TRANSLATOR BOX (Design Preserved) -->
<div class="lg:w-1/2 w-full px-4">
  <div class="bg-white shadow-2xl rounded-3xl p-8 w-full max-w-xl mx-auto transform transition duration-300 hover:scale-[1.01] backdrop-blur-md">
    <h2 class="text-3xl font-extrabold text-center mb-6 text-blue-700 flex items-center justify-center gap-2">
      🌍 Translatify
      <span class="text-sm bg-blue-100 text-blue-600 px-2 py-1 rounded-full">Beta</span>
    </h2>

    <label for="text" class="block text-gray-700 font-semibold mb-2">Enter Text</label>
    <textarea id="text" class="w-full p-4 border border-gray-200 rounded-xl mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none h-32 text-gray-800 placeholder-gray-400 text-base transition" placeholder="Type something to translate..."></textarea>

    <div class="flex flex-col sm:flex-row gap-3 mb-4">
      <div class="w-full">
        <label for="source" class="block text-sm font-medium text-gray-600 mb-1">From</label>
        <select id="source" class="w-full border p-3 rounded-xl bg-gray-50 shadow-sm focus:ring-blue-400 focus:border-blue-400 text-gray-700"></select>
      </div>
      <div class="w-full">
        <label for="target" class="block text-sm font-medium text-gray-600 mb-1">To</label>
        <select id="target" class="w-full border p-3 rounded-xl bg-gray-50 shadow-sm focus:ring-blue-400 focus:border-blue-400 text-gray-700"></select>
      </div>
    </div>

    <div class="flex items-center mb-6">
      <input type="checkbox" id="regionalToggle" class="mr-3 h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-400 transition"/>
      <label for="regionalToggle" class="text-gray-700 text-sm font-medium">Enable Regional Phrases</label>
    </div>

    <button onclick="translateText()" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300">
      🔁 Translate
    </button>

    <div id="result" class="mt-6 text-lg text-gray-800 font-semibold min-h-[3rem]">
      <!-- Translated text appears here -->
    </div>

    <div class="mt-8 text-center text-sm text-gray-500">
      Need help? <a href="mailto:support@translatify.app" class="text-blue-600 hover:underline">Contact Support</a>
    </div>
  </div>
</div>

  <!-- FEATURES SECTION -->
  <section id="features" class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold mb-4 text-blue-700">Key Features</h2>
      <p class="text-gray-600 mb-10">Translatify goes beyond word-to-word translations. It truly speaks your audience’s language.</p>
      <!-- You can add 3-4 features here in grid layout -->
    </div>
  </section>

  <!-- PRICING SECTION -->
  <section id="pricing" class="bg-blue-50 py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold mb-4 text-blue-700">Pricing Plans</h2>
      <p class="text-gray-600 mb-10">Flexible pricing for individuals, creators, and enterprises.</p>
      <!-- Add pricing cards -->
    </div>
  </section>

  <!-- TESTIMONIALS SECTION -->
  <section id="testimonials" class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold mb-4 text-blue-700">What Users Say</h2>
      <p class="text-gray-600 mb-10">Loved by professionals, educators, and creators worldwide.</p>
      <!-- Add 2-3 testimonial cards -->
    </div>
  </section>

  <!-- FOOTER -->
  <footer id="contact" class="bg-gray-900 text-white py-8">
    <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center">
      <p>&copy; 2025 Translatify. All rights reserved.</p>
      <a href="mailto:support@translatify.app" class="hover:underline text-blue-400">support@translatify.app</a>
    </div>
  </footer>
</body>
</html>
