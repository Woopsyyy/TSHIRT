<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . SITE_URL . "/login.php");
    exit;
}

// Fetch basic stats
$stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
$total_orders = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT SUM(total_amount) as revenue FROM orders WHERE status != 'Cancelled'");
$total_revenue = $stmt->fetch()['revenue'] ?? 0;

$stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$total_products = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | <?= SITE_NAME ?></title>
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
        .stat-card {
            background: #0d0d0d;
            padding: 2.2rem;
            border-radius: 16px;
            border: 1px solid #1a1a1a;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #fff, #555);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            border-color: #333;
        }
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        .stat-value {
            font-size: 2.5rem;
            margin-top: 0.8rem;
            font-weight: 300;
            letter-spacing: -0.05em;
            color: #ffffff;
        }
        .admin-table-wrapper {
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: fadeIn 0.6s ease-out 0.2s both;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
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
        <h1 style="margin-bottom: var(--spacing-md); font-weight: 300;">Overview</h1>
        
        <div class="grid-4" style="margin-bottom: var(--spacing-lg);">
            <div class="stat-card">
                <div style="color: var(--color-text-muted); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">Total Revenue</div>
                <div class="stat-value">&#8369;<?= number_format($total_revenue, 2) ?></div>
            </div>
            <div class="stat-card">
                <div style="color: var(--color-text-muted); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">Orders</div>
                <div class="stat-value"><?= $total_orders ?></div>
            </div>
            <div class="stat-card">
                <div style="color: var(--color-text-muted); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">Products</div>
                <div class="stat-value"><?= $total_products ?></div>
            </div>
        </div>

        <h3 style="margin-bottom: var(--spacing-sm); font-weight: 400;">Recent Orders</h3>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" align="center" style="padding: 3rem; color: #888;">No recent orders found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
