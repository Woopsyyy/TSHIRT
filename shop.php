<?php
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/includes/db.php';

$category_slug = $_GET['category'] ?? '';

// Fetch products based on category
if ($category_slug) {
    $stmt = $pdo->prepare("SELECT p.* FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = ? AND p.is_active = 1");
    $stmt->execute([$category_slug]);
} else {
    $stmt = $pdo->query("SELECT * FROM products WHERE is_active = 1");
}
$products = $stmt->fetchAll();

// Fetch all categories for filter
$cat_stmt = $pdo->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll();
?>

<!-- Shop Header -->
<section class="section-padding" style="padding-top: calc(var(--spacing-xl) + 60px); background: var(--color-bg-alt);">
    <div class="container text-center">
        <h1 class="text-display reveal"><?= $category_slug ? strtoupper(str_replace('-', ' ', $category_slug)) : 'ALL PRODUCTS' ?></h1>
        <p class="text-lead reveal" style="transition-delay: 0.2s; margin-top: var(--spacing-sm);">The complete collection.</p>
    </div>
</section>

<!-- Shop Grid & Filters -->
<section class="section-padding">
    <div class="container">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); border-bottom: 1px solid var(--color-border); padding-bottom: var(--spacing-sm);">
            <div class="filters" style="display: flex; gap: var(--spacing-sm);">
                <a href="<?= SITE_URL ?>/shop.php" class="btn <?= !$category_slug ? 'btn-primary' : '' ?>" style="padding: 0.5rem 1rem; border-radius: 20px;">All</a>
                <?php foreach($categories as $cat): ?>
                    <a href="<?= SITE_URL ?>/shop.php?category=<?= $cat['slug'] ?>" class="btn <?= ($category_slug === $cat['slug']) ? 'btn-primary' : '' ?>" style="padding: 0.5rem 1rem; border-radius: 20px;"><?= htmlspecialchars($cat['name']) ?></a>
                <?php endforeach; ?>
            </div>
            <div class="sort-dropdown">
                <select style="background: transparent; color: var(--color-text); border: 1px solid var(--color-border); padding: 0.5rem 1rem; font-family: var(--font-main); outline: none; border-radius: 20px;">
                    <option value="newest" style="background: var(--color-bg);">Newest</option>
                    <option value="price_low" style="background: var(--color-bg);">Price: Low to High</option>
                    <option value="price_high" style="background: var(--color-bg);">Price: High to Low</option>
                </select>
            </div>
        </div>

        <div class="grid-4">
            <?php foreach($products as $index => $product): ?>
                <?php
                // Image logic
                if ($product['slug'] === 'charcoal-washed-tee') { $primary_img = 'tee.png'; $hover_img = 'hoodie.png'; }
                elseif ($product['slug'] === 'graphite-heavyweight-hoodie') { $primary_img = 'hoodie.png'; $hover_img = 'tee.png'; }
                elseif ($product['slug'] === 'ivory-essential-tee') { $primary_img = 'ivory_tee.png'; $hover_img = 'tee.png'; }
                elseif ($product['slug'] === 'midnight-black-hoodie') { $primary_img = 'black_hoodie.png'; $hover_img = 'hoodie.png'; }
                elseif ($product['slug'] === 'signature-nylon-tote') { $primary_img = 'tote_bag.png'; $hover_img = 'hoodie.png'; }
                else { $primary_img = (strpos($product['slug'], 'hoodie') !== false) ? 'hoodie.png' : 'tee.png'; $hover_img = 'hoodie.png'; }
                ?>
                <a href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>" class="product-card reveal" style="transition-delay: <?= ($index % 4) * 0.1 ?>s">
                    <div class="product-image-wrapper">
                        <img src="assets/images/<?= $primary_img ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image product-image-main">
                        <img src="assets/images/<?= $hover_img ?>" alt="<?= htmlspecialchars($product['name']) ?> Hover" class="product-image product-image-hover">
                    </div>
                    <div class="product-info">
                        <div>
                            <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                        </div>
                        <div class="product-price">&#8369;<?= number_format($product['price'], 2) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        
        <?php if(empty($products)): ?>
            <div style="text-align: center; padding: var(--spacing-xl) 0; color: var(--color-text-muted);">
                <h3>No products found in this category.</h3>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
