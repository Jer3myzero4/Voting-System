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
  <title>Leading Candidates | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex min-h-screen">

 
  <aside class="w-64 bg-blue-700 text-white flex flex-col">
    <div class="p-6 border-b border-blue-600">
      <h2 class="text-2xl font-bold">Student Panel</h2>
      <p class="text-sm text-blue-200">Voting System</p>
    </div>

    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
      <a href="/students-dashboard" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Dashboard</a>
      <a href="/vote-now" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Vote Now</a>
      <a href="/my-votes" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">My Votes</a>
      <a href="/leadingcounts" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Leading Candidates</a>
    </nav>

    <div class="p-4 border-t border-blue-600">
      <a href="/logout" class="block text-center bg-red-500 py-2 rounded-lg font-semibold hover:bg-red-600 transition">Logout</a>
    </div>
  </aside>

  
  <main class="flex-1 p-8 overflow-y-auto">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Leading Candidates</h1>
    </div>

    <?php 
    
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
                  $is_leading = $row['total_votes'] == $max_votes;
                ?>
                <tr class="border-b hover:bg-gray-50 transition">
                  <td class="px-4 py-3"><?= $counter++ ?></td>
                  <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['candidate_name']) ?></td>
                  <td class="px-4 py-3"><?= (int)$row['total_votes'] ?></td>
                  <td class="px-4 py-3"><?= $percentage ?>%</td>
                  <td class="px-4 py-3 text-center">
                    <?php if ($is_leading): ?>
                      <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Lead</span>
                    <?php else: ?>
                      <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">—</span>
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
