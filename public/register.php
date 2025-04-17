<?php
require(__DIR__ . '/../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['full_name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
  try {
    $stmt->execute([$name, $email, $password]);
    header("Location: login.php?registered=1");
  } catch (PDOException $e) {
    $error = "Email already registered.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register – Translatify</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-br from-blue-100 via-purple-100 to-indigo-200 min-h-screen flex items-center justify-center">
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
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-blue-700 mb-4">Create an Account</h2>
    <?php if (isset($error)): ?>
      <p class="text-red-600 text-sm mb-4"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="full_name" placeholder="Full Name" required class="w-full px-4 py-2 mb-3 border rounded" />
      <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 mb-3 border rounded" />
      <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 mb-4 border rounded" />
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Register</button>
    </form>
    <p class="text-sm mt-4 text-center">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login</a></p>
  </div>
</body>
</html>
