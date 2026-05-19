<?php
// components/footer.php
?>
<footer class="footer section-padding">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="<?= SITE_URL ?>" class="nav-brand" style="margin-bottom: 1rem; display: block;"><?= SITE_NAME ?></a>
                <p style="color: var(--color-text-muted); max-width: 300px;">Redefining modern luxury streetwear with premium essentials and cinematic aesthetics.</p>
            </div>
            <div class="footer-col">
                <h4>Shop</h4>
                <ul>
                    <li><a href="<?= SITE_URL ?>/shop.php?category=oversized-tees">Oversized Tees</a></li>
                    <li><a href="<?= SITE_URL ?>/shop.php?category=hoodies">Hoodies</a></li>
                    <li><a href="<?= SITE_URL ?>/shop.php?category=accessories">Accessories</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="<?= SITE_URL ?>/contact.php">Contact</a></li>
                    <li><a href="<?= SITE_URL ?>/shipping.php">Shipping & Returns</a></li>
                    <li><a href="<?= SITE_URL ?>/tracking.php">Order Tracking</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</span>
            <span>Made for the culture.</span>
        </div>
    </div>
</footer>

<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
