<?php
require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

// Require user role 'admin'
require_admin();

$user_id = $request['parameters']['GET']['id'] ?? null;

if ($user_id) {
    // Fetch user
    $user = getUserDataByUserID($user_id, $pdo);
}

render('user_details', [
    'pageTitle' => 'Benutzerdetails',
    'userData' => $userData,
    'user' => $user
]);