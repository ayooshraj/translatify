<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <link rel="icon" href="/assets/favicon.svg" type="image/svg+xml" />
<meta name="description" content="Translatify helps you break language barriers with smart regional phrase translation. Instant, accurate, native-feeling results.">
<meta property="og:title" content="Translatify – Smart Regional Translator">
<meta property="og:image" content="/assets/og-image.png">

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



<!-- AOS Scroll Animation -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<!-- Swiper Carousel -->
<link
  rel="stylesheet"
  href="https://unpkg.com/swiper/swiper-bundle.min.css"
/>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


</head>

<body onload="fetchLanguages()" class="bg-gradient-to-br from-blue-100 via-purple-100 to-indigo-200 min-h-screen text-gray-800">
  

<!-- HEADER -->
<header class="bg-gray-50 border-b border-gray-200 shadow-sm fixed top-0 left-0 w-full z-50 backdrop-blur-md">
  <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <a href="index.php" class="flex items-center gap-2 text-xl font-bold text-blue-700">
      🌍 <span>Translatify</span>
    </a>
    
    <nav class="hidden md:flex gap-6 text-sm font-medium text-gray-600">
      <a href="index.php" class="hover:text-blue-600 transition">Home</a>
      <a href="#features" class="hover:text-blue-600 transition">Features</a>
      <a href="#pricing" class="hover:text-blue-600 transition">Pricing</a>
      <a href="blog.html" class="hover:text-blue-600 transition">Blog</a>
      <a href="contact.html" class="hover:text-blue-600 transition">Contact</a>
      <a href="#testimonials" class="hover:text-blue-600 transition">Testimonials</a>
    </nav>

    <div class="hidden md:flex items-center gap-4">
      <a href="login.php" class="text-sm text-blue-600 hover:underline">
        Login
      </a>
      <a href="register.php" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm transition">
        Register
      </a>
    </div>
  </div>
</header>



<!-- Inside <body> tag, replace the current TRANSLATOR PANEL section with this updated version -->
<section class="flex flex-col lg:flex-row items-center justify-between w-full max-w-7xl mx-auto px-4 py-16 gap-8">
  
  <!-- LEFT INFO PANEL -->
  <div class="w-full lg:w-1/2 mb-12 lg:mb-0">
    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-6 leading-tight text-center lg:text-left">
      Break Language Barriers<br />
      <span class="text-blue-600">with Translatify</span>
    </h2>
    <p class="text-gray-700 text-lg mb-6 text-center lg:text-left">
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

  <!-- TRANSLATOR BOX PANEL -->
  <div class="w-full lg:w-1/2 px-4">
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
</section>


<!-- FEATURES SECTION -->
<section id="features" class="py-20 bg-gradient-to-br from-white via-blue-50 to-purple-100">
  <div class="max-w-7xl mx-auto px-6">

    <!-- Section Heading -->
    <div class="text-center mb-12">
      <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4">
        Why <span class="text-blue-600">Translatify</span> Stands Out
      </h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">
        A revolutionary tool that makes translation simpler, smarter, and lightning fast.
      </p>
    </div>

    <!-- DESKTOP GRID (Hidden on Mobile) -->
    <div class="hidden md:grid grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up">
        <div class="text-3xl mb-4">🌐</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Auto Language Detection</h3>
        <p class="text-gray-600">Just type or paste your text — we auto-detect the language to save you time and effort.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
        <div class="text-3xl mb-4">⚡</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Real-Time Translation</h3>
        <p class="text-gray-600">Instant results as you type. No lag, no waiting, just seamless communication.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
        <div class="text-3xl mb-4">🌍</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Regional Accuracy</h3>
        <p class="text-gray-600">Translations tuned to dialects and regions for better context and clarity.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
        <div class="text-3xl mb-4">🔤</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Transliteration Option</h3>
        <p class="text-gray-600">Prefer phonetic typing? Toggle transliteration mode for Hindi, Tamil, and more.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
        <div class="text-3xl mb-4">🔁</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Swap Languages Instantly</h3>
        <p class="text-gray-600">Reverse the input/output languages with one tap. Super handy during conversations.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
        <div class="text-3xl mb-4">📋</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">One-Tap Copy</h3>
        <p class="text-gray-600">Copy translated text instantly to share or use across apps without switching windows.</p>
      </div>
    </div>

    <!-- MOBILE CAROUSEL (Swiper) -->
    <div class="md:hidden swiper-container mt-8">
      <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow-md p-6 mx-2">
            <div class="text-3xl mb-4">🌐</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Auto Language Detection</h3>
            <p class="text-gray-600">Just type or paste your text — we auto-detect the language to save you time and effort.</p>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow-md p-6 mx-2">
            <div class="text-3xl mb-4">⚡</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Real-Time Translation</h3>
            <p class="text-gray-600">Instant results as you type. No lag, no waiting, just seamless communication.</p>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow-md p-6 mx-2">
            <div class="text-3xl mb-4">🌍</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Regional Accuracy</h3>
            <p class="text-gray-600">Translations tuned to dialects and regions for better context and clarity.</p>
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow-md p-6 mx-2">
            <div class="text-3xl mb-4">🔤</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Transliteration Option</h3>
            <p class="text-gray-600">Prefer phonetic typing? Toggle transliteration mode for Hindi, Tamil, and more.</p>
          </div>
        </div>

        <!-- Slide 5 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow-md p-6 mx-2">
            <div class="text-3xl mb-4">🔁</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Swap Languages Instantly</h3>
            <p class="text-gray-600">Reverse the input/output languages with one tap. Super handy during conversations.</p>
          </div>
        </div>

        <!-- Slide 6 -->
        <div class="swiper-slide">
          <div class="bg-white rounded-2xl shadow-md p-6 mx-2">
            <div class="text-3xl mb-4">📋</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">One-Tap Copy</h3>
            <p class="text-gray-600">Copy translated text instantly to share or use across apps without switching windows.</p>
          </div>
        </div>
      </div>

      <!-- Pagination Dots -->
      <div class="swiper-pagination mt-4"></div>
    </div>

  </div>
</section>


  <!-- PRICING SECTION -->
<section id="pricing" class="bg-blue-50 py-16">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-4 text-blue-700">Pricing Plans</h2>
    <p class="text-gray-600 mb-10">Flexible pricing for individuals, creators, and enterprises.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Starter Plan -->
      <div class="bg-white p-6 rounded-2xl shadow-md border hover:shadow-lg transition">
        <h3 class="text-xl font-semibold mb-2">Starter</h3>
        <p class="text-gray-500 mb-4">For personal use</p>
        <p class="text-3xl font-bold text-blue-600">$0<span class="text-base font-medium text-gray-500">/mo</span></p>
        <ul class="text-sm text-gray-600 mt-4 space-y-2 text-left">
          <li>✔ 100 translations/month</li>
          <li>✔ Access to all languages</li>
          <li>✔ Email support</li>
        </ul>
        <button class="mt-6 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Get Started</button>
      </div>

      <!-- Pro Plan -->
      <div class="bg-white p-6 rounded-2xl shadow-lg border-2 border-blue-500 hover:shadow-xl transform transition scale-[1.03]">
        <h3 class="text-xl font-semibold mb-2 text-blue-700">Pro</h3>
        <p class="text-gray-500 mb-4">For content creators and professionals</p>
        <p class="text-3xl font-bold text-blue-700">$15<span class="text-base font-medium text-gray-500">/mo</span></p>
        <ul class="text-sm text-gray-600 mt-4 space-y-2 text-left">
          <li>✔ 5,000 translations/month</li>
          <li>✔ Regional phrase support</li>
          <li>✔ Priority email support</li>
          <li>✔ Translation history access</li>
        </ul>
        <button class="mt-6 w-full bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-800 transition">Upgrade</button>
      </div>

      <!-- Enterprise Plan -->
      <div class="bg-white p-6 rounded-2xl shadow-md border hover:shadow-lg transition">
        <h3 class="text-xl font-semibold mb-2">Enterprise</h3>
        <p class="text-gray-500 mb-4">For teams and global businesses</p>
        <p class="text-3xl font-bold text-blue-600">$49<span class="text-base font-medium text-gray-500">/mo</span></p>
        <ul class="text-sm text-gray-600 mt-4 space-y-2 text-left">
          <li>✔ Unlimited translations</li>
          <li>✔ Regional + industry-specific tuning</li>
          <li>✔ Dedicated account manager</li>
          <li>✔ API access + Integration support</li>
        </ul>
        <button class="mt-6 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Contact Sales</button>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section id="testimonials" class="bg-white py-16">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-4 text-blue-700">What Users Say</h2>
    <p class="text-gray-600 mb-10">Loved by professionals, educators, and creators worldwide.</p>

    <div class="grid md:grid-cols-3 gap-6">
      <!-- Testimonial 1 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow-sm">
        <p class="text-gray-600 italic mb-4">“Translatify made our content accessible in 4 new markets within days.”</p>
        <h4 class="font-semibold text-gray-800">— Priya Sharma, Marketing Head</h4>
      </div>

      <!-- Testimonial 2 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow-sm">
        <p class="text-gray-600 italic mb-4">“Finally a translator that understands regional expressions. It saved my team hours of rework.”</p>
        <h4 class="font-semibold text-gray-800">— Carlos Mendes, Localization Lead</h4>
      </div>

      <!-- Testimonial 3 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow-sm">
        <p class="text-gray-600 italic mb-4">“As a creator, tone matters. Translatify keeps my message authentic across languages.”</p>
        <h4 class="font-semibold text-gray-800">— Aisha Khan, YouTube Educator</h4>
      </div>
    </div>
  </div>
</section>


  <!-- FOOTER -->
<footer class="bg-white border-t mt-24 text-gray-600">
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
    <div>
      <h3 class="font-bold text-blue-700 text-lg mb-2">🌍 Translatify</h3>
      <p class="text-sm leading-relaxed">Smart regional translations that feel native. Break language barriers and sound local.</p>
    </div>

    <div>
      <h4 class="font-semibold mb-2">Product</h4>
      <ul class="space-y-1 text-sm">
        <li><a href="#features" class="hover:text-blue-600 transition">Features</a></li>
        <li><a href="#pricing" class="hover:text-blue-600 transition">Pricing</a></li>
        <li><a href="#testimonials" class="hover:text-blue-600 transition">Testimonials</a></li>
        <li><a href="blog.html" class="hover:text-blue-600 transition">Our Blog</a></li>
      </ul>
    </div>

    <div>
      <h4 class="font-semibold mb-2">Company</h4>
      <ul class="space-y-1 text-sm">
        <li><a href="#about" class="hover:text-blue-600 transition">About Us</a></li>
        <li><a href="#contact" class="hover:text-blue-600 transition">Contact</a></li>
        <li><a href="mailto:support@translatify.app" class="hover:text-blue-600 transition">Support</a></li>
      </ul>
    </div>

    <div>
      <h4 class="font-semibold mb-2">Follow</h4>
      <ul class="space-y-1 text-sm">
        <li><a href="#" class="hover:text-blue-600 transition">Twitter</a></li>
        <li><a href="#" class="hover:text-blue-600 transition">Instagram</a></li>
        <li><a href="#" class="hover:text-blue-600 transition">LinkedIn</a></li>
      </ul>
    </div>
  </div>

  <div class="border-t text-xs text-center py-4 text-gray-400">
    © 2025 Translatify. All rights reserved.
  </div>
</footer>
<script>
  AOS.init({
    duration: 800,
    once: true,
  });

  // Swiper init for mobile
  const isMobile = window.innerWidth < 768;
  if (isMobile) {
    new Swiper('.swiper-container', {
      slidesPerView: 1.1,
      spaceBetween: 16,
      grabCursor: true,
      centeredSlides: true,
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  }
</script>

</body>
</html>
