<?php

require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/transactions.php';

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

// Require user role 'admin'
require_admin();

// Fetch user statistics
$userCount = getActiveUserCount($pdo);
$transactionCount = getTransactionCount($pdo);

render('admin_dashboard', [
    'pageTitle' => 'Admin Dashboard',
    'userData' => $userData,
    'userCount' => $userCount,
    'transactionCount' => $transactionCount
]);





