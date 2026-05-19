<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . SITE_URL . "/login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC");
$customers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers | <?= SITE_NAME ?> Admin</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
            background: #000000;
        }
        .admin-main {
            flex: 1;
            padding: 3rem;
            background: #050505;
            color: #ffffff;
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .admin-table-wrapper {
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            margin-top: 2rem;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .admin-table th {
            background: #121212;
            padding: 1.2rem;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            border-bottom: 1px solid #1a1a1a;
        }
        .admin-table td {
            padding: 1.2rem;
            border-bottom: 1px solid #1a1a1a;
            color: #cccccc;
            transition: background 0.2s;
        }
        .admin-table tr:hover td {
            background: #121212;
        }
    </style>
</head>
<body>

<div class="admin-layout">
    <?php require_once __DIR__ . '/components/sidebar.php'; ?>
    
    <main class="admin-main">
        <h1 style="margin-bottom: var(--spacing-md); font-weight: 300;">Customers</h1>
        
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($customers as $c): ?>
                    <tr>
                        <td style="font-weight: 500;"><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        <td><?= htmlspecialchars($c['phone'] ?? 'N/A') ?></td>
                        <td><?= date('M j, Y', strtotime($c['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($customers)): ?>
                        <tr><td colspan="4" align="center" style="padding: 3rem; color: #888;">No customers found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
