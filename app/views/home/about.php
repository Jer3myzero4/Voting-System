<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white flex flex-col h-screen">

  
  <header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
      <h1 class="text-xl font-bold text-blue-700">Voting System</h1>
      <nav class="space-x-6 text-gray-600 font-medium">
        <a href="/homepage" class="hover:text-blue-600">Home</a>
        <a href="/about" class="text-blue-600 font-semibold">About</a>
        <a href="/contact" class="hover:text-blue-600">Contact</a>
      </nav>
      <div class="space-x-3">
        <a href="/login" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm">Login</a>
        <a href="/register" class="border border-blue-600 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-600 hover:text-white transition text-sm">Register</a>
      </div>
    </div>
  </header>

  <!-- About Content -->
  <main class="flex-grow flex flex-col justify-between px-6 py-4">

    <!-- Mission & Vision -->
    <section class="max-w-3xl mx-auto text-center flex-1 flex flex-col justify-center">
      <h3 class="text-3xl font-bold text-gray-800 mb-3">Our Mission</h3>
      <p class="text-gray-600 mb-6">
        To provide students with a trustworthy platform that makes voting accessible, fair, and efficient. We aim to encourage student participation and strengthen school governance.
      </p>
      <h3 class="text-3xl font-bold text-gray-800 mb-3">Our Vision</h3>
      <p class="text-gray-600">
        A future where every student has the power to make their voice heard, contributing to a transparent and democratic school environment.
      </p>
    </section>

    <!-- Core Values -->
    <section class="max-w-4xl mx-auto text-center flex-1 flex flex-col justify-center">
      <h3 class="text-3xl font-bold text-gray-800 mb-6">Our Core Values</h3>
      <div class="grid md:grid-cols-3 gap-4 flex-1">
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
          <div class="text-blue-600 text-3xl mb-2">🤝</div>
          <h4 class="text-lg font-semibold mb-1">Integrity</h4>
          <p class="text-gray-600 text-sm">We uphold honesty and transparency in every process of the election system.</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
          <div class="text-blue-600 text-3xl mb-2">💡</div>
          <h4 class="text-lg font-semibold mb-1">Innovation</h4>
          <p class="text-gray-600 text-sm">We embrace technology to make voting easier and more efficient for everyone.</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
          <div class="text-blue-600 text-3xl mb-2">🗣️</div>
          <h4 class="text-lg font-semibold mb-1">Participation</h4>
          <p class="text-gray-600 text-sm">We encourage every student to actively participate in shaping their school governance.</p>
        </div>
      </div>
    </section>

  </main>
</body>
</html>
