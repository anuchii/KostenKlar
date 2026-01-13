<?php
session_set_cookie_params([
    'path' => '/',   // robust: Cookie gilt für die ganze App
]);
session_start();
require_once __DIR__ . '/../app/config/paths.php';
define('BASE_URL', '/kostenklar/public');
$page = $_GET['page'] ?? 'startseite';

$routes = [
    'login' => PAGES_PATH . '/login.php',
    'new_transaction' => PAGES_PATH . '/new_transaction.php',
    'profil' => PAGES_PATH . '/profil.php',
    'update_profil' => ACTIONS_PATH . '/update_profil.php',
    'register' => PAGES_PATH . '/register.php',
    'statistik' => PAGES_PATH . '/statistik.php',
    'user_dashboard' => PAGES_PATH . '/user_dashboard.php',
    'logout' => ACTIONS_PATH . '/logout.php',
    'login_action' => ACTIONS_PATH . '/login_action.php',
    'upload_avatar' => ACTIONS_PATH . '/upload_avatar.php',
    'startseite' => PAGES_PATH .  '/startseite.php',
    'show_transaction' => PAGES_PATH . '/show_transaction.php',
    'delete_transaction' => PAGES_PATH . '/delete_transaction.php',
    'edit_transaction' => PAGES_PATH . '/edit_transaction.php',
    //'admin_dashboard' => 
];
if (!isset($routes[$page])) {
    http_response_code(404);
    exit('404 - Seite nicht gefunden');
}

require $routes[$page];


