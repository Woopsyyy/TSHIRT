<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . SITE_URL . "/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | <?= SITE_NAME ?> Admin</title>
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
        .admin-card {
            background: #0d0d0d;
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid #1a1a1a;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
            max-width: 600px;
            margin-top: 2rem;
        }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #666; }
        .form-input { width: 100%; padding: 1rem; background: #121212; border: 1px solid #222222; color: #ffffff; font-family: var(--font-main); border-radius: 8px; transition: all 0.3s; }
        .form-input:focus { outline: none; border-color: #ffffff; background: #161616; box-shadow: 0 0 0 4px rgba(255,255,255,0.02); }
    </style>
</head>
<body>

<div class="admin-layout">
    <?php require_once __DIR__ . '/components/sidebar.php'; ?>
    
    <main class="admin-main">
        <h1 style="margin-bottom: var(--spacing-md); font-weight: 300;">Settings</h1>
        
        <div class="admin-card">
            <h3 style="margin-bottom: var(--spacing-sm); font-weight: 400;">Store Information</h3>
            <form>
                <div class="form-group">
                    <label class="form-label">Store Name</label>
                    <input type="text" class="form-input" value="<?= SITE_NAME ?>" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Email</label>
                    <input type="email" class="form-input" value="contact@moycejae.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Currency</label>
                    <input type="text" class="form-input" value="PHP (&#8369;)" readonly>
                </div>
                <button type="button" class="btn btn-primary" onclick="alert('Settings saved (Mock)')">Save Changes</button>
            </form>
        </div>
    </main>
</div>

</body>
</html>
