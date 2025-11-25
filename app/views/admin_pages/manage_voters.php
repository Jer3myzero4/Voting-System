<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Voters | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex min-h-screen">

  <!-- 🧭 Sidebar -->
  <aside class="w-64 bg-blue-700 text-white flex flex-col">
    <div class="p-6 border-b border-blue-600">
      <h2 class="text-2xl font-bold">Admin Panel</h2>
      <p class="text-sm text-blue-200">Student Voting System</p>
    </div>
    <nav class="flex-1 p-4 space-y-2">
      <a href="/admin" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Dashboard</a>
      <a href="/manage-voters" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Manage Voters</a>
      <a href="/manage-candidates" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Manage Candidates</a>
      <a href="/election-results" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Election Results</a>
       <a href="/election-visualization" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Visualization</a>
    </nav>
    <div class="p-4 border-t border-blue-600">
      <a href="/logout" class="block text-center bg-red-500 py-2 rounded-lg font-semibold hover:bg-red-600 transition">Logout</a>
    </div>
  </aside>

  <!-- 📋 Main Content -->
  <main class="flex-1 p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Manage Voters</h1>
    </div>

    <!-- Search Bar -->
   <!-- Search Bar -->
<div class="mb-6">
  <form action="/manage-voters" method="GET" class="bg-white shadow p-4 rounded-lg flex justify-between items-center">
    <input 
      type="text" 
      name="search" 
      placeholder="Search voter..." 
      value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
      class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button type="submit" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Search</button>
  </form>
</div>


    <!-- Table -->
    <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
      <table class="w-full border-collapse">
        <thead class="bg-blue-100 text-blue-800">
          <tr>
            <th class="py-3 px-4 text-left">#</th>
            <th class="py-3 px-4 text-left">Student ID</th>
            <th class="py-3 px-4 text-left">Full Name</th>
            <th class="py-3 px-4 text-left">Grade & Section</th>
            <th class="py-3 px-4 text-left">Email</th>
            <th class="py-3 px-4 text-left">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
  <?php if (!empty($voters)): ?>
    <?php $count = 1; foreach ($voters as $voter): ?>
      <tr class="border-b hover:bg-gray-100">
        <td class="py-3 px-4"><?= $count++; ?></td>
        <td class="py-3 px-4"><?= htmlspecialchars($voter['id']); ?></td>
        <td class="py-3 px-4"><?= htmlspecialchars($voter['fullname']); ?></td>
        <td class="py-3 px-4"><?= htmlspecialchars($voter['grade']); ?> - <?= htmlspecialchars($voter['section']); ?></td>
        <td class="py-3 px-4"><?= htmlspecialchars($voter['email']); ?></td>
        <td class="py-3 px-4">
          <?php if ($voter['is_active'] == 1): ?>
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Active</span>
          <?php else: ?>
            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Inactive</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="7" class="py-4 text-center text-gray-500">No voters found.</td>
    </tr>
  <?php endif; ?>
</tbody>
      </table>
    </div>
  </main>

</body>
</html>
