<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

require_admin();

$user_id = (int) $request['parameters']['GET']['id'] ?? null;

// Fetch user
if ($user_id) {
    $user = getUserDataByUserID($user_id, $pdo);
}

$errors = $_SESSION['user_errors'] ?? [];
$old = $_SESSION['user_old'] ?? $user;

unset($_SESSION['user_errors'], $_SESSION['user_old']);

render('edit_user', [
    'pageTitle' => 'Benutzerbearbeitung',
    'userData' => $userData,
    'errors' => $errors,
    'old' => $old
]);
