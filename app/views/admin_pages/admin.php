<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans flex min-h-screen">

  <!-- 🧭 Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-blue-700 to-blue-900 text-white flex flex-col shadow-lg">
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

    <div class="p-4 border-t border-blue-700">
      <a href="/logout" class="block text-center bg-red-500 py-2 rounded-lg font-semibold hover:bg-red-600 transition">Logout</a>
    </div>
  </aside>

  <!-- 📋 Main Content -->
  <main class="flex-1 p-10 overflow-y-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-10">
      <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
      <div class="bg-blue-100 text-blue-700 px-5 py-2 rounded-lg font-medium shadow-sm">
        Welcome, Admin!
      </div>
    </div>

    <!-- 🧩 Stats Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
      <!-- Total Voters -->
      <div class="bg-white hover:shadow-lg shadow rounded-xl p-6 border-t-4 border-blue-500 transition-all duration-200">
        <h3 class="text-gray-500 text-sm">Total Voters</h3>
        <p class="text-4xl font-bold text-gray-800 mt-2"><?= htmlspecialchars($total_voters ?? 0); ?></p>
      </div>

      <!-- Total Candidates -->
      <div class="bg-white hover:shadow-lg shadow rounded-xl p-6 border-t-4 border-green-500 transition-all duration-200">
        <h3 class="text-gray-500 text-sm">Total Candidates</h3>
        <p class="text-4xl font-bold text-gray-800 mt-2"><?= htmlspecialchars($total_candidates ?? 0); ?></p>
      </div>

      <!-- Pending Votes -->
      <div class="bg-white hover:shadow-lg shadow rounded-xl p-6 border-t-4 border-red-500 transition-all duration-200">
        <h3 class="text-gray-500 text-sm">Pending Votes</h3>
        <p class="text-4xl font-bold text-gray-800 mt-2"><?= htmlspecialchars($total_pending_votes ?? 0); ?></p>

      </div>
    </section>

    <!-- 🧩 All Positions in One Card -->
    <section class="bg-white shadow rounded-xl p-6 border-t-4 border-yellow-400 mb-10">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">🗳️ Total Candidates Per Position</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php 
          $positions = [
            'President' => $total_president_candidates ?? 0,
            'Vice President' => $total_vicepresident_candidates ?? 0,
            'Secretary' => $total_secretary_candidates ?? 0,
            'Treasurer' => $total_treasurer_candidates ?? 0,
            'Auditor' => $total_auditor_candidates ?? 0,
            'P.I.O.' => $total_pio_candidates ?? 0,
            'Business Manager' => $total_businessmanager_candidates ?? 0,
            'Muse' => $total_muse_candidates ?? 0,
            'Escort' => $total_escort_candidates ?? 0,
          ];
        ?>

        <?php foreach ($positions as $position => $count): ?>
        <div class="bg-yellow-50 hover:bg-yellow-100 transition rounded-lg p-4 border border-yellow-200 shadow-sm">
          <h3 class="text-sm font-medium text-gray-600"><?= $position; ?></h3>
          <p class="text-2xl font-bold text-gray-800 mt-1"><?= htmlspecialchars($count); ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

   <section class="bg-white shadow-md hover:shadow-lg transition rounded-xl p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Leading Candidates</h2>
  </div>

  <table class="min-w-full table-auto border-collapse">
    <thead>
      <tr class="bg-blue-100 text-left text-gray-700 text-sm uppercase">
        <th class="px-4 py-3">#</th>
        <th class="px-4 py-3">Position</th>
        <th class="px-4 py-3">Candidate Name</th>
        <th class="px-4 py-3">Total Votes</th>
        <th class="px-4 py-3">Status</th>
      </tr>
    </thead>
    <tbody class="text-gray-600 text-sm divide-y divide-gray-200">
      <?php
        // ✅ Order of positions
        $ordered_positions = [
          'President',
          'Vice President',
          'Secretary',
          'Treasurer',
          'Auditor',
          'PIO',
          'Business Manager',
          'Muse',
          'Escort'
        ];

        // ✅ Group all leaders by position (supporting multiple entries)
        $leaders_by_position = [];
        if (!empty($leaders)) {
          foreach ($leaders as $leader) {
            $leaders_by_position[$leader['position']][] = $leader;
          }
        }

        $count = 1;
        foreach ($ordered_positions as $pos):
          if (!empty($leaders_by_position[$pos])):
            foreach ($leaders_by_position[$pos] as $leader):
      ?>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-4 py-3"><?= $count++; ?></td>
          <td class="px-4 py-3 font-semibold text-gray-800"><?= htmlspecialchars($pos); ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($leader['candidate_name']); ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($leader['total_votes']); ?></td>
          <td class="px-4 py-3">
            <?php if ($leader['status'] === 'Tied'): ?>
              <span class="text-red-600 font-medium">Tied</span>
            <?php else: ?>
              <span class="text-green-600 font-medium">Leading</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php
            endforeach;
          else:
      ?>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-4 py-3"><?= $count++; ?></td>
          <td class="px-4 py-3 font-semibold text-gray-800"><?= htmlspecialchars($pos); ?></td>
          <td class="px-4 py-3 text-gray-400 italic" colspan="3">No data available</td>
        </tr>
      <?php
          endif;
        endforeach;
      ?>
    </tbody>
  </table>
</section>

  </main>
</body>
</html>
