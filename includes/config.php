<?php
// includes/config.php
session_start();

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'moyce_jae_db');

// Determine protocol (HTTP vs HTTPS)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";

// Determine domain/IP and port
$domainName = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

// Determine the subfolder (path relative to document root)
$doc_root = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])) : '';
$project_dir = str_replace('\\', '/', realpath(dirname(__DIR__)));

if (!empty($doc_root) && strpos($project_dir, $doc_root) === 0) {
    $relative_path = substr($project_dir, strlen($doc_root));
} else {
    // Fallback if document root cannot be detected or if accessed via CLI
    $relative_path = '/xampp/Project/TSHIRT';
}

// Ensure the relative path has a leading slash and no trailing slash
$relative_path = '/' . trim(str_replace('\\', '/', $relative_path), '/');
if ($relative_path === '/') {
    $relative_path = '';
}

define('SITE_URL', $protocol . $domainName . $relative_path);
define('SITE_NAME', 'Moyce Jae');

// Security Helpers
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
