<?php
require_once __DIR__ . '/../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> | Luxury Streetwear</title>
    <meta name="description" content="Moyce Jae - Premium luxury streetwear essentials. Cinematic fashion experience.">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-links">
        <a href="<?= SITE_URL ?>/shop.php">Shop</a>
        <a href="<?= SITE_URL ?>/lookbook.php">Lookbook</a>
    </div>
    
    <a href="<?= SITE_URL ?>" class="nav-brand"><?= SITE_NAME ?></a>
    
    <style>
    .user-dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: #000000;
        border: 1px solid #222222;
        min-width: 160px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        border-radius: 8px;
        z-index: 1000;
        padding: 0.5rem 0;
        margin-top: 0.5rem;
        animation: dropFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes dropFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .user-dropdown:hover .dropdown-menu {
        display: block;
    }
    .dropdown-item {
        color: #888;
        padding: 0.7rem 1.2rem;
        text-decoration: none;
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
        text-align: left;
    }
    .dropdown-item:hover {
        color: #ffffff;
        background: rgba(255,255,255,0.05);
    }
    </style>
    
    <div class="nav-icons">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-dropdown">
                <a href="#" class="nav-icon" aria-label="Account">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </a>
                <div class="dropdown-menu">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="<?= SITE_URL ?>/admin/dashboard.php" class="dropdown-item">Admin Panel</a>
                    <?php endif; ?>
                    <a href="<?= SITE_URL ?>/logout.php" class="dropdown-item" style="color: #ff6b6b;">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= SITE_URL ?>/login.php" class="nav-icon" aria-label="Account">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </a>
        <?php endif; ?>
        
        <button class="nav-icon js-cart-toggle" aria-label="Cart">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </button>
    </div>
</nav>

<!-- Cart Drawer -->
<div class="cart-drawer-overlay" id="cartOverlay"></div>
<div class="cart-drawer" id="cartDrawer">
    <div class="cart-header">
        <h3>Your Cart</h3>
        <button class="nav-icon js-cart-toggle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <div class="cart-body" id="cartItems">
        <p style="text-align: center; color: var(--color-text-muted); margin-top: 2rem;">Your cart is empty.</p>
    </div>
    <div class="cart-footer">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
            <span>Subtotal</span>
            <span id="cartSubtotal">&#8369;0.00</span>
        </div>
        <a href="<?= SITE_URL ?>/checkout.php" class="btn btn-primary" style="width: 100%;">Checkout</a>
    </div>
</div>
