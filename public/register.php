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
