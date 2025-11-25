<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Election Visualization | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 font-sans flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-blue-700 text-white flex flex-col fixed h-full">
    <div class="p-6 border-b border-blue-600">
      <h2 class="text-2xl font-bold">Admin Panel</h2>
      <p class="text-sm text-blue-200">Student Voting System</p>
    </div>
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
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
  <main class="flex-1 ml-64 p-8 overflow-y-auto">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Election Visualization</h1>
    </div>

    <?php if (!empty($chart_data)): ?>
      <?php foreach ($chart_data as $position => $candidates): ?>
        <section class="bg-white rounded-2xl shadow p-6 mb-8">
          <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
            <?= htmlspecialchars($position) ?> Results
          </h2>

          <div class="relative h-96">
            <canvas id="<?= str_replace(' ', '_', strtolower($position)) ?>_chart"></canvas>
          </div>
        </section>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="bg-white p-10 text-center rounded-xl shadow text-gray-500">
        No votes recorded yet.
      </div>
    <?php endif; ?>
  </main>

  <script>
    const chartData = <?= json_encode($chart_data) ?>;

    Object.entries(chartData).forEach(([position, candidates]) => {
      const ctx = document.getElementById(position.toLowerCase().replace(/\s+/g, '_') + '_chart');
      if (!ctx) return;

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: candidates.map(c => c.candidate_name),
          datasets: [{
            label: 'Total Votes',
            data: candidates.map(c => c.total_votes),
            backgroundColor: [
              '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
              '#ec4899', '#14b8a6', '#f97316', '#22c55e'
            ],
            borderRadius: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            title: {
              display: true,
              text: position + ' Vote Distribution',
              color: '#1f2937',
              font: { size: 18, weight: 'bold' }
            }
          },
          scales: {
            x: { ticks: { color: '#374151' } },
            y: {
              beginAtZero: true,
              ticks: { color: '#374151', precision: 0 }
            }
          }
        }
      });
    });
  </script>
</body>
</html>
