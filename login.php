<?php
require_once __DIR__ . '/includes/db.php';

if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("Location: " . SITE_URL . "/admin/dashboard.php");
    } else {
        header("Location: " . SITE_URL . "/index.php");
    }
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header("Location: " . SITE_URL . "/admin/dashboard.php");
        } else {
            header("Location: " . SITE_URL . "/index.php");
        }
        exit;
    } else {
        $error = "Invalid credentials. Hint: admin@moycejae.com / password";
    }
}
require_once __DIR__ . '/components/header.php';
?>

<style>
.auth-wrapper {
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-lg) 0;
    animation: authFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes authFadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.auth-card {
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 3rem 2.5rem;
    max-width: 480px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(0,0,0,0.02);
    transition: all 0.3s ease;
}
.auth-card:hover {
    box-shadow: 0 15px 50px rgba(0,0,0,0.04);
    border-color: var(--color-text);
}
.auth-input-group {
    position: relative;
    margin-bottom: var(--spacing-md);
}
.auth-input {
    width: 100%;
    padding: 1.1rem 1rem;
    background: transparent;
    border: 1px solid var(--color-border);
    color: var(--color-text);
    font-family: var(--font-main);
    border-radius: 6px;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    outline: none;
}
.auth-input:focus {
    border-color: var(--color-text);
    box-shadow: 0 0 0 4px rgba(0,0,0,0.02);
}
.auth-input::placeholder {
    color: var(--color-text-muted);
    opacity: 0.6;
}
.auth-title {
    font-weight: 300;
    font-size: 2.2rem;
    letter-spacing: -0.03em;
    margin-bottom: var(--spacing-xs);
    text-align: center;
}
.auth-subtitle {
    color: var(--color-text-muted);
    text-align: center;
    margin-bottom: var(--spacing-lg);
    font-size: 0.95rem;
}
.btn-auth {
    width: 100%;
    padding: 1.1rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    font-size: 0.85rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.alert {
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: var(--spacing-md);
    text-align: center;
    font-size: 0.9rem;
    animation: alertSlide 0.3s ease-out;
}
@keyframes alertSlide {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.alert-error {
    background: #fff5f5;
    color: #fa5252;
    border: 1px solid #ffe3e3;
}
</style>

<section class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-title">Welcome Back</div>
        <p class="auth-subtitle">Sign in to your Moyce Jae account.</p>
        
        <?php if($error): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="auth-input-group">
                <input type="email" name="email" class="auth-input" placeholder="Email" required>
            </div>
            <div class="auth-input-group" style="margin-bottom: var(--spacing-lg);">
                <input type="password" name="password" class="auth-input" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-auth">Sign In</button>
            <a href="<?= SITE_URL ?>/register.php" class="btn btn-auth" style="margin-top: 1rem; border: 1px solid var(--color-border); display: block; text-align: center; text-decoration: none; color: var(--color-text);">Create Account</a>
            
            <div style="text-align: center; margin-top: var(--spacing-md);">
                <a href="#" style="color: var(--color-text-muted); font-size: 0.9rem; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--color-text)'" onmouseout="this.style.color='var(--color-text-muted)'">Forgot Password?</a>
            </div>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
