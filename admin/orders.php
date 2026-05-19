<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . SITE_URL . "/login.php");
    exit;
}

$stmt = $pdo->query("SELECT o.*, u.first_name, u.last_name FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | <?= SITE_NAME ?> Admin</title>
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
        .badge {
            background: #062f22;
            color: #12b886;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-pending {
            background: #2b2212;
            color: #fab005;
        }
        .badge-cancelled {
            background: #2b1313;
            color: #fa5252;
        }
    </style>
</head>
<body>

<div class="admin-layout">
    <?php require_once __DIR__ . '/components/sidebar.php'; ?>
    
    <main class="admin-main">
        <h1 style="margin-bottom: var(--spacing-md); font-weight: 300;">Orders</h1>
        
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $o): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= htmlspecialchars($o['order_number']) ?></td>
                        <td><?= date('M j, Y', strtotime($o['created_at'])) ?></td>
                        <td><?= htmlspecialchars($o['first_name'] . ' ' . $o['last_name']) ?></td>
                        <td>
                            <?php
                            $badge_class = '';
                            if (strtolower($o['status']) === 'pending') { $badge_class = 'badge-pending'; }
                            elseif (strtolower($o['status']) === 'cancelled') { $badge_class = 'badge-cancelled'; }
                            ?>
                            <span class="badge <?= $badge_class ?>">
                                <?= htmlspecialchars($o['status']) ?>
                            </span>
                        </td>
                        <td style="font-weight: 600;">&#8369;<?= number_format($o['total_amount'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($orders)): ?>
                        <tr><td colspan="5" align="center" style="padding: 3rem; color: #888;">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
