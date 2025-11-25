<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white flex flex-col h-screen">

 
  <header class="bg-white shadow-md z-10 relative">
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

  <!-- Registration Form -->
  <main class="flex-grow flex items-center justify-center px-6 mt-6">
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-5xl w-full flex flex-col md:flex-row gap-8">

      <!-- Left: Form -->
      <div class="flex-1 flex flex-col justify-center space-y-4">
        <h2 class="text-3xl font-extrabold text-blue-700 mb-2 text-center md:text-left">Create Your Account</h2>
        <p class="text-gray-600 text-center md:text-left mb-4">Register now to join your school's online voting system</p>

      

        <!-- Registration Form -->
        <form method="POST" action="<?= site_url('/register'); ?>" class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <input type="text" name="fullname" placeholder="Full Name" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

          <input type="email" name="email" placeholder="Email Address" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

          <!-- Password with toggle -->
          <div class="relative w-full">
            <input type="password" name="password" placeholder="Password" required id="password"
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
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

          <!-- Confirm Password with toggle -->
          <div class="relative w-full">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required id="confirm_password"
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
            <button type="button" onclick="togglePassword('confirm_password', this)" 
              class="absolute inset-y-0 right-2 flex items-center text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

          <input type="text" name="grade" placeholder="Grade (Ex. 10)" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

          <input type="text" name="section" placeholder="Section (Ex. Rizal)" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

          <select name="role" required
            class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none md:col-span-2">
            <option value="" disabled selected>Select Role</option>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
          </select>

          <button type="submit" 
            class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition md:col-span-2">
            Register
          </button>
        </form>

        <p class="mt-2 text-center text-gray-600 text-sm md:col-span-2">
          Already have an account?
          <a href="/login" class="text-blue-600 font-medium hover:underline">Login here</a>
        </p>
      </div>

      <!-- Right: Illustration -->
      <div class="hidden md:flex flex-1 items-center justify-center">
        <img src="https://img.freepik.com/free-vector/web-development-concept-illustration_114360-3580.jpg" 
             alt="System Illustration" class="rounded-xl shadow-md max-w-xs">
      </div>

    </div>
  </main>

  <!-- Toggle password script -->
  <script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;

    // Swap icon: eye open vs eye closed
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
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
             d="M3 3l18 18" />
         </svg>`;
  }
  </script>

</body>
</html>
