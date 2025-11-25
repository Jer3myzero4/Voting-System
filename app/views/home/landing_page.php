<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white flex flex-col min-h-screen">

  
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

  
  <main class="flex-grow flex flex-col justify-center">

    
    <section id="home" class="flex items-center justify-center text-center px-6 py-8">
      <div class="max-w-3xl">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 leading-tight">
          Empowering Students Through <span class="text-blue-600">Secure Digital Voting</span>
        </h2>
        <p class="mt-3 text-gray-600 text-base md:text-lg">
          A modern web-based platform for fair, transparent, and efficient student officer elections.
        </p>
        <div class="mt-5 space-x-3">
          <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition text-sm">Get Started</a>
          <a href="/homepage" class="border border-blue-600 text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition text-sm">Learn More</a>
        </div>
      </div>
    </section>

    
    <section id="features" class="bg-blue-50 flex-grow flex items-center">
      <div class="max-w-6xl mx-auto px-4 text-center w-full">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Why Choose Our Voting System?</h3>

        <div class="grid md:grid-cols-3 gap-4">
          <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
            <div class="text-blue-600 text-3xl mb-2">🗳️</div>
            <h4 class="text-lg font-semibold mb-1">Secure Voting</h4>
            <p class="text-gray-600 text-sm">Every vote is confidential and safely recorded to ensure fair elections.</p>
          </div>

          <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
            <div class="text-blue-600 text-3xl mb-2">⚡</div>
            <h4 class="text-lg font-semibold mb-1">Fast and Easy</h4>
            <p class="text-gray-600 text-sm">Students can log in, vote, and view results quickly with just a few clicks.</p>
          </div>

          <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
            <div class="text-blue-600 text-3xl mb-2">📊</div>
            <h4 class="text-lg font-semibold mb-1">Transparent Results</h4>
            <p class="text-gray-600 text-sm">Real-time and accurate election results displayed after voting closes.</p>
          </div>
        </div>
      </div>
    </section>

  </main>

</body>
</html>
