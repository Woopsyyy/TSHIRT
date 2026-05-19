<aside class="admin-sidebar" style="position: sticky; top: 0; height: 100vh; overflow-y: auto;">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <div class="nav-brand" style="font-size: 1.5rem; letter-spacing: -0.05em; padding-bottom: 2rem; border-bottom: 1px solid var(--color-border); margin-bottom: 1rem;">
        <i class="ph ph-hexagon" style="margin-right: 0.5rem; vertical-align: middle;"></i><?= SITE_NAME ?>
    </div>
    
    <nav class="admin-nav" style="display: flex; flex-direction: column; gap: 0.5rem;">
        <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 0.8rem; font-weight: 500;">
            <i class="ph ph-squares-four" style="font-size: 1.2rem;"></i> Dashboard
        </a>
        <a href="products.php" class="<?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 0.8rem; font-weight: 500;">
            <i class="ph ph-t-shirt" style="font-size: 1.2rem;"></i> Products
        </a>
        <a href="orders.php" class="<?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 0.8rem; font-weight: 500;">
            <i class="ph ph-shopping-cart" style="font-size: 1.2rem;"></i> Orders
        </a>
        <a href="customers.php" class="<?= basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 0.8rem; font-weight: 500;">
            <i class="ph ph-users" style="font-size: 1.2rem;"></i> Customers
        </a>
        <a href="settings.php" class="<?= basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 0.8rem; font-weight: 500;">
            <i class="ph ph-gear" style="font-size: 1.2rem;"></i> Settings
        </a>
        
        <div style="margin-top: auto; padding-top: 2rem; display: flex; flex-direction: column; gap: 0.5rem;">
            <a href="<?= SITE_URL ?>" style="display: flex; align-items: center; gap: 0.8rem; color: var(--color-text-muted);">
                <i class="ph ph-storefront" style="font-size: 1.2rem;"></i> Back to Store
            </a>
            <a href="<?= SITE_URL ?>/logout.php" style="display: flex; align-items: center; gap: 0.8rem; color: #ff6b6b;">
                <i class="ph ph-sign-out" style="font-size: 1.2rem;"></i> Logout
            </a>
        </div>
    </nav>
</aside>

<style>
/* Sidebar Animations & Premium Feel */
.admin-sidebar {
    background: #000;
    color: #fff;
    border-right: 1px solid #222;
    padding: 2rem;
    display: flex;
    flex-direction: column;
}
.admin-sidebar .nav-brand {
    color: #fff;
    border-bottom: 1px solid #222 !important;
}
.admin-sidebar a {
    color: #888;
    padding: 0.8rem 1rem;
    border-radius: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.admin-sidebar a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(5px);
}
.admin-sidebar a.active {
    color: #000 !important;
    background: #fff !important;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
}
.admin-sidebar a.active i {
    color: #000;
}
.admin-sidebar a i {
    transition: transform 0.3s ease;
}
.admin-sidebar a:hover i {
    transform: scale(1.1);
}
</style>
