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

// Require user role 'admin'
require_admin();

$user = $request['parameters']['POST'];

$errors = [];
    
// Validate input
$first_name = trim($user["first_name"] ?? '');
if ($first_name === '') {
    $errors["first_name"] = "Bitte geben Sie einen Vornamen ein.";
}

$last_name = trim($user["last_name"] ?? '');
if ($last_name === '') {
    $errors["last_name"] = "Bitte geben Sie einen Nachnamen ein.";
}

if (!empty($errors)) {
    $_SESSION['user_errors'] = $errors;
    $_SESSION['user_old'] = $user;

    header('Location: ' . BASE_URL . '/admin/user/edit?id=' . $user['user_id']);
    exit;
}

updateUser($user, $pdo);

// Redirect to user details
header('Location: ' . BASE_URL . '/admin/user?id=' . $user['user_id']);
exit();


