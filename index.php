<?php
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/includes/db.php';

// Fetch featured products
$stmt = $pdo->query("SELECT * FROM products WHERE is_featured = 1 AND is_active = 1 LIMIT 4");
$featured_products = $stmt->fetchAll();
?>

<!-- Hero Section -->
<section class="hero">
    <img src="<?= SITE_URL ?>/assets/images/hero.png" alt="Moyce Jae Campaign" class="hero-bg">
    <div class="hero-content">
        <h1 class="text-display">ESSENTIAL<br>ELEVATION</h1>
        <p class="text-lead">The new standard in luxury streetwear. Redefining silhouettes.</p>
        <a href="<?= SITE_URL ?>/shop.php" class="btn btn-primary">Explore Collection</a>
    </div>
</section>

<!-- Featured Collection -->
<section class="section-padding">
    <div class="container">
        <div class="section-header reveal">
            <h2 class="section-title">Latest Drops</h2>
            <p class="text-lead">Curated essentials for the modern wardrobe.</p>
        </div>
        
        <div class="grid-4">
            <?php foreach($featured_products as $index => $product): ?>
                <?php
                // Get primary image
                $img_stmt = $pdo->prepare("SELECT image_url FROM product_images WHERE product_id = ? ORDER BY is_primary DESC LIMIT 2");
                $img_stmt->execute([$product['id']]);
                $images = $img_stmt->fetchAll();
                
                // Image logic
                if ($product['slug'] === 'charcoal-washed-tee') { $primary_img = 'tee.png'; $hover_img = 'hoodie.png'; }
                elseif ($product['slug'] === 'graphite-heavyweight-hoodie') { $primary_img = 'hoodie.png'; $hover_img = 'tee.png'; }
                elseif ($product['slug'] === 'ivory-essential-tee') { $primary_img = 'ivory_tee.png'; $hover_img = 'tee.png'; }
                elseif ($product['slug'] === 'midnight-black-hoodie') { $primary_img = 'black_hoodie.png'; $hover_img = 'hoodie.png'; }
                elseif ($product['slug'] === 'signature-nylon-tote') { $primary_img = 'tote_bag.png'; $hover_img = 'hoodie.png'; }
                else { $primary_img = (strpos($product['slug'], 'hoodie') !== false) ? 'hoodie.png' : 'tee.png'; $hover_img = 'hoodie.png'; }
                ?>
                <a href="<?= SITE_URL ?>/product.php?slug=<?= $product['slug'] ?>" class="product-card reveal" style="transition-delay: <?= $index * 0.1 ?>s">
                    <div class="product-image-wrapper">
                        <img src="assets/images/<?= $primary_img ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image product-image-main">
                        <img src="assets/images/<?= $hover_img ?>" alt="<?= htmlspecialchars($product['name']) ?> Hover" class="product-image product-image-hover">
                    </div>
                    <div class="product-info">
                        <div>
                            <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                            <p style="color: var(--color-text-muted); font-size: 0.8rem;">Sizes: S, M, L, XL</p>
                        </div>
                        <div class="product-price">&#8369;<?= number_format($product['price'], 2) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Brand Story / Lookbook -->
<section class="section-padding" style="background: var(--color-bg-alt);">
    <div class="container">
        <div class="grid-2" style="align-items: center;">
            <div class="reveal">
                <img src="<?= SITE_URL ?>/assets/images/hero.png" alt="Editorial" style="border-radius: var(--radius-sm); filter: grayscale(20%);">
            </div>
            <div class="reveal" style="padding: var(--spacing-md);">
                <h2 class="section-title" style="text-align: left;">The Process</h2>
                <p class="text-lead" style="margin-bottom: var(--spacing-md);">Every piece in the Moyce Jae collection is meticulously crafted to balance relaxed silhouettes with premium heavy-weight fabrics. It's more than clothing; it's a structural approach to modern streetwear.</p>
                <a href="<?= SITE_URL ?>/about.php" class="btn">Read Our Story</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
