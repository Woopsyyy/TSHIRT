<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . SITE_URL . "/login.php");
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_product') {
    $category_id = $_POST['category_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $slug = strtolower(str_replace(' ', '-', $name));
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    
    if ($category_id && $name && $price) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, description, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$category_id, $name, $slug, $description, $price]);
            $success = "Product added successfully.";
        } catch(PDOException $e) {
            $error = "Error adding product. Note: Slug must be unique.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}

// Fetch categories
$cat_stmt = $pdo->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll();

// Fetch products
$prod_stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");
$products = $prod_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | <?= SITE_NAME ?> Admin</title>
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .admin-card:hover {
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            border-color: #333;
        }
        .admin-table-wrapper {
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
            overflow: hidden;
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
        
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #666; }
        .form-input { width: 100%; padding: 1rem; background: #121212; border: 1px solid #222222; color: #ffffff; font-family: var(--font-main); border-radius: 8px; transition: all 0.3s; }
        .form-input:focus { outline: none; border-color: #ffffff; background: #161616; box-shadow: 0 0 0 4px rgba(255,255,255,0.02); }
        
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
        .badge-draft {
            background: #2b1320;
            color: #f06595;
        }
    </style>
</head>
<body>

<div class="admin-layout">
    <?php require_once __DIR__ . '/components/sidebar.php'; ?>
    
    <main class="admin-main">
        <h1 style="margin-bottom: var(--spacing-md); font-weight: 300;">Products</h1>
        
        <?php if($error): ?>
            <div style="background: rgba(255,0,0,0.1); color: #ff6b6b; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: var(--spacing-md);">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if($success): ?>
            <div style="background: rgba(0,255,0,0.1); color: #51cf66; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: var(--spacing-md);">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="grid-2" style="gap: var(--spacing-lg); align-items: start; margin-top: 2rem;">
            
            <!-- Products Table -->
            <div style="grid-column: span 1;">
                <h3 style="margin-bottom: var(--spacing-md); font-weight: 400; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="ph ph-list-bullets" style="font-size: 1.4rem;"></i> All Products
                </h3>
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $p): ?>
                            <tr>
                                <td style="font-weight: 500;"><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= htmlspecialchars($p['category_name'] ?? 'None') ?></td>
                                <td style="font-weight: 600;">&#8369;<?= number_format($p['price'], 2) ?></td>
                                <td>
                                    <span class="badge <?= $p['is_active'] ? '' : 'badge-draft' ?>">
                                        <?= $p['is_active'] ? 'Active' : 'Draft' ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($products)): ?>
                                <tr><td colspan="4" align="center" style="padding: 3rem; color: #888;">No products found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Product Form -->
            <div class="admin-card">
                <h3 style="margin-bottom: var(--spacing-md); font-weight: 400; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="ph ph-plus-circle" style="font-size: 1.4rem;"></i> Add New Product
                </h3>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="add_product">
                    
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-input" required>
                            <option value="">Select Category...</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Price (&#8369;) *</label>
                        <input type="number" step="0.01" name="price" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-input" rows="4"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Add Product</button>
                </form>
            </div>
            
        </div>
    </main>
</div>

</body>
</html>
