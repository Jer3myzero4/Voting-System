<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Set New Password | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white flex flex-col h-screen">

  
  <header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
      <h1 class="text-xl font-bold text-blue-700">Voting System</h1>
      <nav class="space-x-6 text-gray-600 font-medium">
        <a href="/homepage" class="hover:text-blue-600">Home</a>
        <a href="/about" class="hover:text-blue-600">About</a>
        <a href="/contact" class="hover:text-blue-600">Contact</a>
      </nav>
      <div class="space-x-3">
        <a href="/login" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm">Login</a>
        <a href="/register" class="border border-blue-600 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-600 hover:text-white transition text-sm">Register</a>
      </div>
    </div>
  </header>

 
  <main class="flex-grow flex items-center justify-center px-6 mt-6">
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-5xl w-full flex flex-col md:flex-row gap-8">

      
      <div class="flex-1 flex flex-col justify-center space-y-4">
        <h2 class="text-3xl font-extrabold text-blue-700 mb-2 text-center md:text-left">Set New Password</h2>
        <p class="text-gray-600 text-center md:text-left mb-4">
          Please enter your new password below and confirm to reset your account access.
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

        <form action="/set-new-password?token=<?= htmlspecialchars($token ?? '') ?>" method="POST" class="space-y-4">

          <!-- Password Field -->
          <div class="relative w-full">
            <input type="password" name="password" placeholder="New Password" required id="password"
              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
            <button type="button" onclick="togglePassword('password', this)" 
              class="absolute inset-y-0 right-3 flex items-center text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

        
          <div class="relative w-full">
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required id="confirm_password"
              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
            <button type="button" onclick="togglePassword('confirm_password', this)" 
              class="absolute inset-y-0 right-3 flex items-center text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
            Reset Password
          </button>
        </form>

        <p class="mt-3 text-center text-gray-600 text-sm">
          Remembered your password?
          <a href="/login" class="text-blue-600 font-medium hover:underline">Go back to Login</a>
        </p>
      </div>

    
      <div class="hidden md:flex flex-1 items-center justify-center">
        <img src="https://img.freepik.com/free-vector/password-reset-concept-illustration_114360-1124.jpg"
             alt="Reset Password Illustration" class="rounded-xl shadow-md max-h-[360px] object-contain">
      </div>
    </div>
  </main>

 
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
             d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.607m3.35-2.78A9.958 9.958 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.631 3.063M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
         </svg>`;
  }
  </script>

</body>
</html>
