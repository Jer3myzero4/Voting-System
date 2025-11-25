<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vote Now | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

  
  <aside class="w-64 bg-blue-700 text-white flex flex-col">
    <div class="p-5 border-b border-blue-600">
      <h2 class="text-2xl font-bold">Student Panel</h2>
      <p class="text-sm text-blue-200">Voting System</p>
    </div>
    <nav class="flex-1 p-4 space-y-1 text-sm">
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
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Vote Now</h1>

   
    <?php if (!empty($notification)): ?>
    <script>
      const notif = <?= $notification ?>;
      Swal.fire({
          icon: notif.icon,
          title: notif.title,
          html: notif.text,
          timer: 5000,
          showConfirmButton: false
      });
    </script>
    <?php endif; ?>

    <?php if ($already_voted): ?>
      <div class="text-center bg-green-100 text-green-800 p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-2">✅ You have already voted!</h2>
        <p>You cannot vote again. Thank you for participating.</p>
      </div>
    <?php else: ?>
    
  
    <form id="voteForm" action="/vote-now" method="POST" class="space-y-8">
      <?php
     
      $order = [
        'President', 'Vice President', 'Secretary', 'Treasurer',
        'Auditor', 'PIO', 'Business Manager', 'Muse', 'Escort'
      ];

      foreach ($order as $position):
        if (!isset($grouped_candidates[$position])) continue;
        $candidates = $grouped_candidates[$position];
      ?>
      <section>
        <h2 class="text-lg font-semibold text-gray-800 mb-3 border-l-4 border-blue-600 pl-3"><?= htmlspecialchars($position); ?></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach ($candidates as $candidate): ?>
            <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition p-4 flex flex-col justify-between">
              <div>
                <h3 class="text-base font-semibold text-gray-800 mb-1">
                  <?= htmlspecialchars($candidate['fullname']); ?>
                </h3>
                <p class="text-xs text-gray-500">Candidate #<?= $candidate['id']; ?></p>
              </div>
              <button 
                type="button"
                class="select-btn mt-3 bg-green-600 hover:bg-green-700 text-white text-sm py-1.5 rounded-md font-medium"
                data-position="<?= htmlspecialchars($position); ?>"
                data-candidate-id="<?= $candidate['id']; ?>"
              >
                Select
              </button>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endforeach; ?>

      <div class="flex justify-center mt-10">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg font-semibold shadow">
          Submit Vote
        </button>
      </div>
    </form>

    <script>
      const selectedVotes = {};

      document.querySelectorAll('.select-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const position = btn.dataset.position;
          const candidateId = btn.dataset.candidateId;

          selectedVotes[position] = candidateId;

          document.querySelectorAll(`[data-position="${position}"]`).forEach(b => {
            b.classList.remove('bg-green-800');
            b.textContent = 'Select';
          });

          btn.classList.add('bg-green-800');
          btn.textContent = 'Selected ✅';
        });
      });

      document.getElementById('voteForm').addEventListener('submit', e => {
        if (Object.keys(selectedVotes).length === 0) {
          e.preventDefault();
          Swal.fire({
            icon: 'error',
            title: 'No Candidate Selected',
            text: 'Please select at least one candidate before submitting.'
          });
          return;
        }

        for (const [position, candidateId] of Object.entries(selectedVotes)) {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = `votes[${position}]`;
          input.value = candidateId;
          e.target.appendChild(input);
        }
      });
    </script>
    <?php endif; ?>
  </main>
</body>
</html>
