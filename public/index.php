<?php
require_once __DIR__ . '/../app/config/paths.php';
define('BASE_URL', '/kostenklar/public');
$page = $_GET['page'] ?? 'login';

$routes = [
    'login' => PAGES_PATH . '/login.php',
    'new_transaction' => PAGES_PATH . '/new_transaction.php',
    'profil' => PAGES_PATH . '/profil.php',
    'register' => PAGES_PATH . '/register.php',
    'statistik' => PAGES_PATH . '/statistik.php',
    'user_dashboard' => PAGES_PATH . '/user_dashboard.php',
    'logout' => ACTIONS_PATH . '/logout.php',
    'auth_login' => ACTIONS_PATH . '/login.php',
    'startseite' => PAGES_PATH .  '/startseite.php',
    'show_transaction' => PAGES_PATH . '/show_transaction.php',
    'delete_transaction' => PAGES_PATH . '/delete_transaction.php',
    'edit_transaction' => PAGES_PATH . '/edit_transaction.php',
    'admin_dashboard' => PAGES_PATH . '/admin_dashboard.php',
    'user_management' => PAGES_PATH . '/user_management.php',
    'show_user' => PAGES_PATH . '/show_user.php',
    'edit_user' => PAGES_PATH . '/edit_user.php'
];
if (!isset($routes[$page])) {
    http_response_code(404);
    exit('404 - Seite nicht gefunden');
}

require $routes[$page];


