<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

// Fixed position order
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
    <title>Official Winners Report | Student Officer Voting System</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        header {
            text-align: center;
            margin-bottom: 40px;
        }
        header img {
            max-height: 80px;
            margin-bottom: 10px;
        }
        header h1 {
            font-size: 28px;
            margin: 0;
        }
        header p {
            font-size: 14px;
            color: #555;
            margin: 2px 0;
        }
        .report-date {
            text-align: right;
            font-size: 12px;
            margin-bottom: 20px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            page-break-inside: auto;
        }
        thead {
            background-color: #004aad;
            color: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 13px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
        }
        .winner {
            background-color: #28a745;
        }
        .tied {
            background-color: #ffc107;
        }
        h2 {
            margin-top: 40px;
            margin-bottom: 10px;
            font-size: 18px;
            color: #004aad;
            border-bottom: 2px solid #004aad;
            padding-bottom: 3px;
        }
    </style>
</head>
<body>

<header>
    <img src="school_logo.png" alt="School Logo">
    <h1>High School Student Official Winners</h1>
    <p>Student Officer Voting System Report</p>
</header>

<div class="report-date">
    <strong>Date:</strong> <?= date('F j, Y') ?>
</div>

<?php
// Group winners by position according to $position_order
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
        <h2><?= htmlspecialchars($position) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Total Votes</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grouped_winners[$position] as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['candidate_name']) ?></td>
                        <td><?= (int)$row['total_votes'] ?></td>
                        <td>
                            <?php if ($row['status'] === 'Leading'): ?>
                                <span class="badge winner">Winner</span>
                            <?php elseif ($row['status'] === 'Tied'): ?>
                                <span class="badge tied">Tied</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endforeach; ?>

</body>
</html>
