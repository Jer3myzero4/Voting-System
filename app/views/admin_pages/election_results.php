<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// ✅ Fixed order of positions
$position_order = [
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Election Results | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex min-h-screen">

  <!-- Sidebar -->
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

  <!-- Main Content -->
  <main class="flex-1 p-8 overflow-y-auto">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Election Results</h1>
      <div class="space-x-2">
       <a href="/election-results/export_winners_pdf" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg font-semibold shadow">📝 Export PDF</a>
      </div>
    </div>

    <?php 
    // Ensure $positions is always an array
    $positions = $positions ?? []; 
    ?>

    <?php foreach ($position_order as $position): ?>
      <?php $candidates = $positions[$position] ?? []; ?>
      <section class="bg-white shadow rounded-xl p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2"><?= htmlspecialchars($position) ?> Results</h2>

        <?php if (!empty($candidates)): ?>
          <?php 
            $max_votes = max(array_column($candidates, 'total_votes'));
            $total_votes = array_sum(array_column($candidates, 'total_votes'));
          ?>
          <table class="min-w-full table-auto border-collapse text-sm">
            <thead class="bg-blue-100 text-gray-700">
              <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Candidate Name</th>
                <th class="px-4 py-3 text-left">Total Votes</th>
                <th class="px-4 py-3 text-left">Percentage</th>
                <th class="px-4 py-3 text-center">Status</th>
              </tr>
            </thead>
            <tbody class="text-gray-600">
              <?php $counter = 1; ?>
              <?php foreach ($candidates as $row): ?>
                <?php 
                  $percentage = $total_votes > 0 ? round(($row['total_votes'] / $total_votes) * 100, 2) : 0;
                  $is_winner = $row['total_votes'] == $max_votes;
                ?>
                <tr class="border-b hover:bg-gray-50 transition">
                  <td class="px-4 py-3"><?= $counter++ ?></td>
                  <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['candidate_name']) ?></td>
                  <td class="px-4 py-3"><?= (int)$row['total_votes'] ?></td>
                  <td class="px-4 py-3"><?= $percentage ?>%</td>
                  <td class="px-4 py-3 text-center">
                    <?php if ($is_winner): ?>
                      <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Winner</span>
                    <?php else: ?>
                      <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Lost</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-gray-500 italic">No candidates or votes recorded for <?= htmlspecialchars($position) ?>.</p>
        <?php endif; ?>
      </section>
    <?php endforeach; ?>
  </main>
</body>
</html>
