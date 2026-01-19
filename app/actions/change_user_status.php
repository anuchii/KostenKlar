<?php

require_once __DIR__ . "/../config/paths.php";
require_once CONFIG_PATH . "/db_config.php";
require_once HELPERS_PATH . "/functions.php";
require_once HELPERS_PATH . "/users.php";

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

require_admin();

$userId = (int) $request['parameters']['POST']['user_id'] ?? null;

// Fetch user
if ($userId) {
    // Fetch user
    $user = getUserDataByUserID($userId, $pdo);
}

$status = $user['status'];

if ($status === 'active') {
    $status = 'inactive';
} else if ($status === 'inactive') {
    $status = 'active';
}

changeUserStatusById($userId, $status, $pdo);

header('Location: ' . BASE_URL . '/admin/user?id=' . $userId);
exit;