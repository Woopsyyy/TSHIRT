<?php
require_once __DIR__ . '/components/header.php';
?>

<style>
.lookbook-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-xl);
}

.lb-item {
    position: relative;
    overflow: hidden;
    background: var(--color-surface);
}

.lb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
}

.lb-item:hover img {
    transform: scale(1.05);
}

.lb-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: var(--spacing-md);
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: #fff;
    opacity: 0;
    transition: opacity var(--transition-fast);
}

.lb-item:hover .lb-caption {
    opacity: 1;
}

/* Asymmetrical Masonry Layout */
.lb-item-1 { grid-column: span 12; height: 70vh; }
.lb-item-2 { grid-column: span 6; height: 60vh; }
.lb-item-3 { grid-column: span 6; height: 60vh; }
.lb-item-4 { grid-column: span 8; height: 80vh; }
.lb-item-5 { grid-column: span 4; height: 80vh; }
.lb-item-6 { grid-column: span 12; height: 60vh; }

@media (max-width: 768px) {
    .lb-item { grid-column: span 12 !important; height: 50vh !important; }
}
</style>

<section class="section-padding" style="padding-top: calc(var(--spacing-xl) + 60px);">
    <div class="container text-center">
        <h1 class="text-display reveal">SEASON 01</h1>
        <p class="text-lead reveal" style="transition-delay: 0.2s; margin-top: var(--spacing-sm); margin-bottom: var(--spacing-xl);">The foundation of modern streetwear architecture.</p>
        
        <div class="lookbook-grid">
            <div class="lb-item lb-item-1 reveal">
                <img src="<?= SITE_URL ?>/assets/images/hero.png?v=<?= filemtime(__DIR__ . '/assets/images/hero.png') ?>" alt="Editorial 1">
                <div class="lb-caption"><h3>The Heavyweight Silhouette</h3></div>
            </div>
            
            <div class="lb-item lb-item-2 reveal">
                <img src="<?= SITE_URL ?>/assets/images/tee.png" alt="Editorial 2">
                <div class="lb-caption"><h3>Charcoal Washed Base</h3></div>
            </div>
            
            <div class="lb-item lb-item-3 reveal">
                <img src="<?= SITE_URL ?>/assets/images/hoodie.png" alt="Editorial 3">
                <div class="lb-caption"><h3>Graphite Structure</h3></div>
            </div>
            
            <div class="lb-item lb-item-4 reveal">
                <img src="<?= SITE_URL ?>/assets/images/hero.png?v=<?= filemtime(__DIR__ . '/assets/images/hero.png') ?>" alt="Editorial 4" style="filter: grayscale(100%);">
                <div class="lb-caption"><h3>Monochrome Vision</h3></div>
            </div>
            
            <div class="lb-item lb-item-5 reveal">
                <img src="<?= SITE_URL ?>/assets/images/hoodie.png" alt="Editorial 5" style="filter: brightness(0.8);">
                <div class="lb-caption"><h3>Layering Framework</h3></div>
            </div>
            
            <div class="lb-item lb-item-6 reveal">
                <img src="<?= SITE_URL ?>/assets/images/hero.png?v=<?= filemtime(__DIR__ . '/assets/images/hero.png') ?>" alt="Editorial 6" style="object-position: top;">
                <div class="lb-caption"><h3>Moyce Jae Essentials</h3></div>
            </div>
        </div>
        
        <div class="reveal">
            <a href="<?= SITE_URL ?>/shop.php" class="btn btn-primary">Shop The Collection</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
