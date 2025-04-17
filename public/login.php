<?php
require(__DIR__ . '/../config/db.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['full_name'];
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid email or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login – Translatify</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-br from-blue-100 via-purple-100 to-indigo-200 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-blue-700 mb-4">Welcome Back</h2>
    <?php if (isset($error)): ?>
      <p class="text-red-600 text-sm mb-4"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 mb-3 border rounded" />
      <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 mb-4 border rounded" />
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
    </form>
    <p class="text-sm mt-4 text-center">Don't have an account? <a href="register.php" class="text-blue-600 hover:underline">Register</a></p>
  </div>
</body>
</html>
