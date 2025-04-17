<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Translatify Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Navbar -->
<nav class="bg-white border-b border-gray-200 shadow-sm fixed top-0 w-full z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <!-- Logo -->
      <a href="/Translatify/public/dashboard.php" class="text-xl font-bold text-blue-600 tracking-wide">
        🌍 Translatify
      </a>

      <!-- Navigation Links -->
      <div class="flex space-x-6 items-center">
        <a href="/Translatify/public/dashboard.php" class="text-gray-700 hover:text-blue-600 transition">Dashboard</a>
        <a href="/Translatify/public/translate.php" class="text-gray-700 hover:text-blue-600 transition">Translate</a>
        <a href="/Translatify/public/history.php" class="text-gray-700 hover:text-blue-600 transition">History</a>
        <a href="/Translatify/public/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition">Logout</a>
      </div>
    </div>
  </div>
</nav>
