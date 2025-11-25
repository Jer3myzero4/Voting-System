<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Official Election Results | Student Officer Voting System</title>
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
       <a href="/leading" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Leading Candidates</a>
      <a href="/results" class="block py-2.5 px-4 rounded-lg hover:bg-blue-600 font-medium transition">Results</a>
    </nav>
    <div class="p-4 border-t border-blue-600">
      <a href="/logout" class="block text-center bg-red-500 py-2 rounded-lg font-semibold hover:bg-red-600 transition">Logout</a>
    </div>
  </aside>

 
  <main class="flex-1 flex flex-col items-center p-8">
    <div class="w-full max-w-5xl">
      <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Official Election Results</h1>
      <p class="text-gray-600 text-center mb-8">Check the official winners for each student officer position.</p>

      <?php if (!empty($winners)): ?>
        <?php
       
        $position_order = [
          'President', 'Vice President', 'Secretary', 'Treasurer',
          'Auditor', 'PIO', 'Business Manager', 'Muse', 'Escort'
        ];

       
        $grouped_winners = [];
        foreach ($position_order as $pos) {
          foreach ($winners as $w) {
            if ($w['position'] === $pos) {
              $grouped_winners[$pos][] = $w;
            }
          }
        }
        ?>

        <?php foreach ($position_order as $position): ?>
          <?php if (!empty($grouped_winners[$position])): ?>
            <div class="bg-white shadow-md rounded-xl p-6 mb-6">
              <h2 class="text-xl font-semibold text-blue-700 mb-4"><?= htmlspecialchars($position) ?></h2>
              <ul class="list-disc ml-6">
                <?php foreach ($grouped_winners[$position] as $row): ?>
                  <li class="mb-1 text-gray-700">
                    <span class="font-semibold"><?= htmlspecialchars($row['candidate_name']) ?></span> 
                    <?php if ($row['status'] === 'Leading'): ?>
                      <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-bold ml-2">Winner</span>
                    <?php elseif ($row['status'] === 'Tied'): ?>
                      <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold ml-2">Tied</span>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>

      <?php else: ?>
        <p class="text-gray-500 text-center">Results have not been released yet. Please check back later.</p>
      <?php endif; ?>
    </div>
  </main>

</body>
</html>
