<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Candidates | Student Officer Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Manage Candidates</h1>
      <button onclick="toggleAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow">
        ➕ Add Candidate
      </button>
    </div>

<form method="GET" action="<?= site_url('/manage-candidates') ?>" class="mb-4 flex space-x-2">
    <input type="text" name="q" value="<?= htmlspecialchars($query ?? '') ?>" 
           placeholder="Search candidates..." 
           class="border rounded px-3 py-2 w-64">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        🔍 Search
    </button>
</form>



    <!-- 🧾 Candidate Table -->
    <section class="bg-white shadow rounded-xl p-6">
      <table class="min-w-full table-auto border-collapse">
        <thead>
          <tr class="bg-blue-100 text-left text-gray-700 text-sm">
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Position</th>
            <th class="px-4 py-3">Grade Level</th>
            <th class="px-4 py-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
          <?php if (!empty($candidates)): ?>
            <?php foreach ($candidates as $index => $candidate): ?>
              <tr class="border-b">
                <td class="px-4 py-3"><?= $index + 1 ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($candidate->fullname) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($candidate->position) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($candidate->grade_level) ?></td>
                <td class="px-4 py-3 text-center space-x-2">
                  <!-- Edit button with data attributes -->
                  <button 
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm edit-btn"
                    data-id="<?= $candidate->id ?>"
                    data-fullname="<?= htmlspecialchars($candidate->fullname) ?>"
                    data-position="<?= htmlspecialchars($candidate->position) ?>"
                    data-grade="<?= htmlspecialchars($candidate->grade_level) ?>"
                  >
                    ✏️ Edit
                  </button>

                  <!-- Delete button with confirmation -->
                  <button 
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm delete-btn"
                    data-id="<?= $candidate->id ?>"
                  >
                    🗑️ Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="px-4 py-3 text-center text-gray-500">No candidates found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- 🔹 Pagination Links -->
      <div class="mt-4 flex justify-center">
        <?= $pagination ?? '' ?>
      </div>
    </section>
  </main>

  <!-- 🧍 Add Candidate Modal -->
  <div id="addCandidateModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Add Candidate</h2>



   

<script>
<?php if (isset($_SESSION['success'])): ?>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '<?= $_SESSION['success'] ?>',
        confirmButtonColor: '#3085d6',
        timer: 2000
    });
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: '<?= $_SESSION['error'] ?>',
        confirmButtonColor: '#d33',
        timer: 2000
    });
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
</script>

      <form action="<?= site_url('/manage-candidates'); ?>" method="POST" class="space-y-4">
        <div>
          <label class="text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" name="fullname" required placeholder="Enter full name" 
                 class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
        </div>
        <div>
          <label class="text-sm font-medium text-gray-700">Position</label>
          <select name="position" required class="w-full border rounded-lg px-3 py-2">
            <option value="">Select Position</option>
            <option>President</option>
            <option>Vice President</option>
            <option>Secretary</option>
            <option>Treasurer</option>
            <option>Auditor</option>
            <option>PIO</option>
            <option>Business Manager</option>
            <option>Muse</option>
            <option>Escort</option>
          </select>
        </div>
        <div>
          <label class="text-sm font-medium text-gray-700">Grade Level</label>
          <select name="grade_level" required class="w-full border rounded-lg px-3 py-2">
            <option value="">Select Grade</option>
            <option>Grade 7</option>
            <option>Grade 8</option>
            <option>Grade 9</option>
            <option>Grade 10</option>
            <option>Grade 11</option>
            <option>Grade 12</option>
          </select>
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" onclick="toggleAddModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</button>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold">Add</button>
        </div>
      </form>
    </div>
  </div>

  <!-- 🧍 Edit Candidate Modal -->
  <div id="editCandidateModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Candidate</h2>
      <form id="editCandidateForm" method="POST" action="<?= site_url('/manage-candidates/update'); ?>" class="space-y-4">
        <input type="hidden" name="id" id="edit-id">

        <div>
          <label class="text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" name="fullname" id="edit-fullname" required
                 class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">Position</label>
          <select name="position" id="edit-position" required class="w-full border rounded-lg px-3 py-2">
            <option value="">Select Position</option>
            <option>President</option>
            <option>Vice President</option>
            <option>Secretary</option>
            <option>Treasurer</option>
            <option>Auditor</option>
            <option>PIO</option>
            <option>Business Manager</option>
            <option>Muuse</option>
            <option>Escort</option>
          </select>
        </div>

        <div>
          <label class="text-sm font-medium text-gray-700">Grade Level</label>
          <select name="grade_level" id="edit-grade" required class="w-full border rounded-lg px-3 py-2">
            <option value="">Select Grade</option>
            <option>Grade 7</option>
            <option>Grade 8</option>
            <option>Grade 9</option>
            <option>Grade 10</option>
            <option>Grade 11</option>
            <option>Grade 12</option>
          </select>
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" onclick="toggleEditModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</button>
          <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold">Update</button>
        </div>
      </form>
    </div>
  </div>

  <!-- 🔹 JavaScript for modals and delete -->
  <script>
    // Add Candidate modal
    const addModal = document.getElementById('addCandidateModal');
    function toggleAddModal() { addModal.classList.toggle('hidden'); }
    window.addEventListener('click', function(e) { if (e.target === addModal) toggleAddModal(); });

    // Edit Candidate modal
    const editModal = document.getElementById('editCandidateModal');
    const editForm = document.getElementById('editCandidateForm');
    function toggleEditModal() { editModal.classList.toggle('hidden'); }

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit-id').value = button.dataset.id;
            document.getElementById('edit-fullname').value = button.dataset.fullname;
            document.getElementById('edit-position').value = button.dataset.position;
            document.getElementById('edit-grade').value = button.dataset.grade;
            toggleEditModal();
        });
    });

    window.addEventListener('click', function(e) { if (e.target === editModal) toggleEditModal(); });

    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            const candidateId = button.dataset.id;
            const confirmed = confirm("Are you sure you want to delete this candidate?");
            if (confirmed) {
                window.location.href = "<?= site_url('/manage-candidates/delete/'); ?>" + candidateId;
            }
        });
    });
  </script>

</body>
</html>
