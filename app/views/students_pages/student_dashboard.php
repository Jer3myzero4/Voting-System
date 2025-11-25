<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex min-h-screen">

  
  <aside class="w-64 bg-blue-700 text-white flex flex-col">
    <div class="p-6 border-b border-blue-600">
      <h2 class="text-2xl font-bold">Student Panel</h2>
      <p class="text-sm text-blue-200">Voting System</p>
    </div>
    <nav class="flex-1 p-4 space-y-2">
      <a href="/students-dashboard" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Dashboard</a>
      <a href="/vote-now" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Vote Now</a>
      <a href="/my-votes" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">My Votes</a>
      <a href="/leadingcounts" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Leading Candidates</a>

    </nav>
    <div class="p-4 border-t border-blue-600">
      <a href="/logout" class="block text-center bg-red-500 py-2 rounded-lg font-semibold hover:bg-red-600 transition">Logout</a>
    </div>
  </aside>

 
  <main class="flex-1 flex flex-col items-center justify-start p-8">
    <div class="w-full max-w-6xl">
      <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Welcome, <?= htmlspecialchars($fullname) ?>!</h1>
      <p class="text-gray-600 text-center mb-8">Here you can vote for your student officer candidates, view your results, and update your profile.</p>

      
      <div class="flex flex-wrap justify-center gap-6">
       
        <div class="bg-white shadow-xl rounded-xl p-6 text-center hover:scale-105 transition w-72">
          <h2 class="text-xl font-semibold mb-2">Vote Now</h2>
          <p class="text-gray-600 mb-4">Cast your vote for your favorite candidates.</p>
          <a href="/vote-now" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold">Go</a>
        </div>

   
        <div class="bg-white shadow-xl rounded-xl p-6 text-center hover:scale-105 transition w-72">
          <h2 class="text-xl font-semibold mb-2">My Votes</h2>
          <p class="text-gray-600 mb-4">Check your submitted votes</p>
          <a href="/my-votes" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold">Go</a>
        </div>

  
      </div>
    </div>
  </main>

</body>
</html>
