<?php
require_once __DIR__ . '/includes/db.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) {
    header("Location: " . SITE_URL . "/shop.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE slug = ?");
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) {
    require_once __DIR__ . '/components/header.php';
    echo "<h1 style='text-align:center; margin-top: 100px;'>Product Not Found</h1>";
    exit;
}

require_once __DIR__ . '/components/header.php';

// Fetch variants
$var_stmt = $pdo->prepare("SELECT DISTINCT size, color FROM product_variants WHERE product_id = ?");
$var_stmt->execute([$product['id']]);
$variants = $var_stmt->fetchAll();
$sizes = array_unique(array_column($variants, 'size'));
$colors = array_unique(array_column($variants, 'color'));

// Image logic
if ($product['slug'] === 'charcoal-washed-tee') { $primary_img = 'tee.png'; }
elseif ($product['slug'] === 'graphite-heavyweight-hoodie') { $primary_img = 'hoodie.png'; }
elseif ($product['slug'] === 'ivory-essential-tee') { $primary_img = 'ivory_tee.png'; }
elseif ($product['slug'] === 'midnight-black-hoodie') { $primary_img = 'black_hoodie.png'; }
elseif ($product['slug'] === 'signature-nylon-tote') { $primary_img = 'tote_bag.png'; }
else { $primary_img = (strpos($product['slug'], 'hoodie') !== false) ? 'hoodie.png' : 'tee.png'; }
?>

<style>
.product-detail-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: var(--spacing-xl);
    align-items: start;
    padding-top: calc(var(--spacing-lg) + 60px);
}

.product-gallery {
    display: flex;
    gap: var(--spacing-sm);
    position: sticky;
    top: 100px;
}

.gallery-thumbnails {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-sm);
    width: 80px;
}

.thumbnail {
    width: 100%;
    aspect-ratio: 4/5;
    object-fit: cover;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all var(--transition-fast);
}

.thumbnail:hover, .thumbnail.active {
    border-color: var(--color-border);
    opacity: 0.7;
}

.gallery-main {
    flex: 1;
    aspect-ratio: 4/5;
    background: var(--color-surface);
}

.gallery-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info-panel h1 {
    font-size: 2.5rem;
    margin-bottom: var(--spacing-xs);
    letter-spacing: -0.02em;
}

.product-info-panel .price {
    font-size: 1.5rem;
    color: var(--color-text-muted);
    margin-bottom: var(--spacing-md);
}

.product-info-panel .description {
    color: var(--color-text-muted);
    margin-bottom: var(--spacing-lg);
    line-height: 1.8;
}

.selector-label {
    display: block;
    margin-bottom: var(--spacing-xs);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--color-text-muted);
}

.size-selector {
    display: flex;
    gap: var(--spacing-xs);
    margin-bottom: var(--spacing-lg);
}

.size-btn {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--color-border);
    background: transparent;
    color: var(--color-text);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.size-btn:hover, .size-btn.active {
    border-color: var(--color-text);
    background: var(--color-surface);
}

@media (max-width: 900px) {
    .product-detail-grid {
        grid-template-columns: 1fr;
    }
    .product-gallery {
        position: relative;
        top: 0;
    }
}
</style>

<section class="section-padding" style="min-height: 100vh;">
    <div class="container">
        <div class="product-detail-grid">
            
            <div class="product-gallery reveal">
                <div class="gallery-thumbnails">
                    <img src="assets/images/<?= $primary_img ?>" class="thumbnail active" alt="Thumb 1">
                    <img src="assets/images/<?= $primary_img === 'tee.png' ? 'hoodie.png' : 'tee.png' ?>" class="thumbnail" alt="Thumb 2">
                </div>
                <div class="gallery-main">
                    <img src="assets/images/<?= $primary_img ?>" id="mainImage" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
            </div>
            
            <div class="product-info-panel reveal" style="transition-delay: 0.2s;">
                <h1><?= htmlspecialchars($product['name']) ?></h1>
                <div class="price">&#8369;<?= number_format($product['price'], 2) ?></div>
                
                <div class="description">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </div>
                
                <?php if(!empty($colors)): ?>
                <div class="color-selector" style="margin-bottom: var(--spacing-md);">
                    <span class="selector-label">Color: <?= $colors[0] ?></span>
                </div>
                <?php endif; ?>

                <?php if(!empty($sizes)): ?>
                <span class="selector-label">Select Size</span>
                <div class="size-selector">
                    <?php foreach($sizes as $index => $size): ?>
                        <button class="size-btn <?= $index === 0 ? 'active' : '' ?>"><?= htmlspecialchars($size) ?></button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <button class="btn btn-primary js-add-to-cart" 
                            data-id="<?= $product['id'] ?>"
                            data-name="<?= htmlspecialchars($product['name']) ?>"
                            data-price="<?= $product['price'] ?>"
                            data-image="assets/images/<?= $primary_img ?>"
                            data-color="<?= !empty($colors) ? htmlspecialchars($colors[0]) : 'Default' ?>"
                            style="width: 100%; padding: 1.5rem; margin-bottom: var(--spacing-sm);">Add to Cart</button>
                    <button class="btn" style="width: 100%; border-color: transparent;" onclick="alert('Added to wishlist (Mock)');">Add to Wishlist</button>
                <?php else: ?>
                    <button class="btn btn-primary" style="width: 100%; padding: 1.5rem; margin-bottom: var(--spacing-sm);" onclick="window.location.href='<?= SITE_URL ?>/login.php';">Add to Cart</button>
                    <button class="btn" style="width: 100%; border-color: transparent;" onclick="window.location.href='<?= SITE_URL ?>/login.php';">Add to Wishlist</button>
                <?php endif; ?>
                
                <div style="margin-top: var(--spacing-lg); border-top: 1px solid var(--color-border); padding-top: var(--spacing-md); font-size: 0.9rem; color: var(--color-text-muted);">
                    <p style="margin-bottom: 0.5rem;">&#10003; Premium Materials</p>
                    <p style="margin-bottom: 0.5rem;">&#10003; Ships within 48 hours</p>
                    <p>&#10003; Free returns within 30 days</p>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

document.querySelectorAll('.thumbnail').forEach(thumb => {
    thumb.addEventListener('click', (e) => {
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        e.target.classList.add('active');
        document.getElementById('mainImage').src = e.target.src;
    });
});
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
