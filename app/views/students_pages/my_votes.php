<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Votes | Student Officer Voting System</title>
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

 
  <main class="flex-1 p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">My Votes</h1>

    <section class="bg-white shadow rounded-xl p-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Submitted Votes</h2>
      <table class="min-w-full table-auto border-collapse">
        <thead>
          <tr class="bg-blue-100 text-left text-gray-700 text-sm">
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">Candidate Name</th>
            <th class="px-4 py-3">Position</th>
            <th class="px-4 py-3">Status</th>
          </tr>
        </thead>
       <tbody class="text-gray-600 text-sm">
  <?php if (!empty($my_votes)): ?>
    <?php $count = 1; ?>
    <?php foreach ($my_votes as $vote): ?>
      <tr class="border-b">
        <td class="px-4 py-3"><?= $count++; ?></td>
        <td class="px-4 py-3"><?= htmlspecialchars($vote['candidate_name']); ?></td>
        <td class="px-4 py-3"><?= htmlspecialchars($vote['position']); ?></td>
        <td class="px-4 py-3">
          <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
            Voted
          </span>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="4" class="text-center text-gray-500 py-4">
        You haven't voted yet.
      </td>
    </tr>
  <?php endif; ?>
</tbody>

      </table>
    </section>
  </main>

</body>
</html>
