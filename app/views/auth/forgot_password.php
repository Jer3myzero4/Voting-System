<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white flex flex-col h-screen">


  <header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
      <h1 class="text-xl font-bold text-blue-700">Voting System</h1>
      <nav class="space-x-6 text-gray-600 font-medium">
        <a href="/homepage" class="hover:text-blue-600">Home</a>
        <a href="/about" class="hover:text-blue-600">About</a>
        <a href="/contact" class="hover:text-blue-600">Contact</a>
      </nav>
      <div class="space-x-3">
        <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Login</a>
        <a href="/register" class="border border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">Register</a>
      </div>
    </div>
  </header>

  <!-- 🔒 Forgot Password Section -->
  <main class="flex-grow flex items-center justify-center px-6 mt-6">
    <div class="bg-white shadow-lg rounded-xl w-full max-w-5xl h-[400px] flex flex-row">

      <!-- Left: Form -->
      <div class="flex-1 flex flex-col justify-center px-10">
        <h2 class="text-3xl font-extrabold text-blue-700 mb-3 text-center md:text-left">Forgot Password?</h2>
        <p class="text-gray-600 text-center md:text-left mb-6">
          Enter your registered email address below, and we’ll send you a link to reset your password.
        </p>

        <?php if (!empty($notification)): ?>
<script>
const notif = <?= $notification ?>;
Swal.fire({
    icon: notif.icon,
    title: notif.title,
    text: notif.text,
    confirmButtonColor: '#3085d6',
});
</script>
<?php endif; ?>

        <form action="/forgot-password" method="POST" class="space-y-5">
          <input type="email" name="email" placeholder="Enter your email address" required
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

          <button type="submit"
            class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
            Send Reset Link
          </button>
        </form>

        <p class="mt-4 text-center text-gray-600 text-sm">
          Remembered your password?
          <a href="/login" class="text-blue-600 font-medium hover:underline">Go back to Login</a>
        </p>
      </div>

   
      <div class="hidden md:flex flex-1 items-center justify-center">
        <img src="https://img.freepik.com/free-vector/forgot-password-concept-illustration_114360-1123.jpg"
             alt="Forgot Password Illustration" class="rounded-xl shadow-md max-h-[360px] object-contain">
      </div>

    </div>
  </main>

</body>
</html>
