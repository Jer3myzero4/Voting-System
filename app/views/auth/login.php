<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex flex-col">

 
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

  <!-- Login Form -->
  <main class="flex-grow flex items-center justify-center px-6 py-20">
    <div class="bg-white shadow-lg rounded-xl p-10 max-w-md w-full">
      <h2 class="text-3xl font-extrabold text-center text-blue-700 mb-6">Welcome Back!</h2>
      <p class="text-gray-600 text-center mb-8">Log in to access your student voting account</p>

      <!-- SweetAlert Notification -->
      <?php if (!empty($notification)): ?>
        <script>
          const notif = <?= $notification ?>;
          Swal.fire({
              icon: notif.icon,
              title: notif.title,
              text: notif.text,
              timer: 2500,
              showConfirmButton: false
          });
        </script>
      <?php endif; ?>

      

      <form method="POST" action="<?= site_url('/login'); ?>" class="space-y-5">
        <input type="email" name="email" placeholder="Email address" required
          class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <!-- Password with toggle icon -->
        <div class="relative w-full">
          <input type="password" name="password" placeholder="Password" required id="password"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
          <button type="button" onclick="togglePassword('password', this)" 
            class="absolute inset-y-0 right-2 flex items-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

         <select name="role" required
            class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none md:col-span-2">
            <option value="" disabled selected>Select Role</option>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
          </select>


        <div class="flex justify-between items-center text-sm">
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-2 focus:ring-blue-500 rounded">
            <span>Remember Me</span>
          </label>
          <a href="/forgot-password" class="text-blue-600 hover:underline">Forgot Password?</a>
        </div>

        <button type="submit"
          class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
          Login
        </button>
      </form>

      <p class="mt-6 text-center text-gray-600 text-sm">
        Don’t have an account?
        <a href="/register" class="text-blue-600 font-medium hover:underline">Register here</a>
      </p>
    </div>
  </main>

  <!-- Toggle password script -->
  <script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;

    btn.innerHTML = type === 'password' 
      ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
             d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
             d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
         </svg>`
      : `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
             d="M3 3l18 18" />
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
             d="M10.584 10.584a3 3 0 104.832 4.832" />
         </svg>`;
  }
  </script>

</body>
</html>
