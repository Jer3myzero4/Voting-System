<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white flex flex-col h-screen">

  
  <header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center px-6 py-3">
      <h1 class="text-xl font-bold text-blue-700">Voting System</h1>
      <nav class="space-x-6 text-gray-600 font-medium">
        <a href="/homepage" class="hover:text-blue-600">Home</a>
        <a href="/about" class="hover:text-blue-600">About</a>
        <a href="/contact" class="text-blue-600 font-semibold">Contact</a>
      </nav>
      <div class="space-x-3">
        <a href="/login" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm">Login</a>
        <a href="/register" class="border border-blue-600 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-600 hover:text-white transition text-sm">Register</a>
      </div>
    </div>
  </header>

  
  <main class="flex-grow flex flex-col justify-between px-6 py-4">

    
    <section class="flex-1 flex flex-col justify-center items-center text-center">
      <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-3">
        Get in Touch With <span class="text-blue-600">Us</span>
      </h2>
      <p class="text-gray-600 text-base md:text-lg">
        Have questions or need help? Send us a message and we’ll get back to you as soon as possible.
      </p>
    </section>

   >
    <section class="flex-1 flex flex-col justify-center max-w-4xl mx-auto space-y-6">
      
    
      <div class="bg-white shadow-md rounded-xl p-6 flex-1">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Contact Form</h3>
        <form class="space-y-4">
          <input type="text" placeholder="Full Name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
          <input type="email" placeholder="Email Address" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
          <textarea placeholder="Your Message" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
          <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow-lg transition">Send Message</button>
          </div>
        </form>
      </div>

     
      <div class="grid md:grid-cols-3 gap-4 text-center flex-1">
        <div class="bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition">
          <div class="text-blue-600 text-2xl mb-1">📍</div>
          <h4 class="font-semibold">Address</h4>
          <p class="text-gray-600 text-sm">123 High School Street, Your City, Your Country</p>
        </div>
        <div class="bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition">
          <div class="text-blue-600 text-2xl mb-1">📧</div>
          <h4 class="font-semibold">Email</h4>
          <p class="text-gray-600 text-sm">support@votingsystem.com</p>
        </div>
        <div class="bg-white shadow-md rounded-xl p-4 hover:shadow-lg transition">
          <div class="text-blue-600 text-2xl mb-1">📞</div>
          <h4 class="font-semibold">Phone</h4>
          <p class="text-gray-600 text-sm">+63 912 345 6789</p>
        </div>
      </div>

    </section>
    
  </main>
</body>
</html>
