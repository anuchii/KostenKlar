<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/transactions.php';
require_once HELPERS_PATH . '/transaction_validation.php';

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

$currentDate = date('Y-m-d');

// Fetch categories
$categories = getTransactionCategories($pdo);

$errors = $_SESSION['transaction_errors'] ?? [];
$old = $_SESSION['transaction_old'] ?? ['transaction_date' => $currentDate];

unset($_SESSION['transaction_errors'], $_SESSION['transaction_old']);

render('new_transaction', [
    'pageTitle' => 'Neue Buchung',
    'errors' => $errors,
    'old' => $old,
    'userData' => $userData,
    'categories' => $categories
]);

?>