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

deleteUserById($userId, $pdo);

header('Location: ' . BASE_URL . '/admin/users');
exit;