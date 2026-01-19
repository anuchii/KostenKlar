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

$transaction_id = (int) $request['parameters']['GET']['id'] ?? null;

// Fetch categories
$categories = getTransactionCategories($pdo);

// Fetch transaction data
if ($transaction_id) {
    $transaction = getTransactionByID($transaction_id, $pdo);
    $transaction["transaction_amount"] = number_format($transaction["transaction_amount"], 2, ',', '');
}


// Check if transaction exists and belongs to logged in user
if (!$transaction || $transaction["user_id"] != $userData["user_id"]) {
    // Redirect to dashboard if transaction is invalid
    header('Location: ' . BASE_URL . '/dashboard');
    exit();
}

$errors = $_SESSION['transaction_errors'] ?? [];
$old = $_SESSION['transaction_old'] ?? $transaction;

unset($_SESSION['transaction_errors'], $_SESSION['transaction_old']);

render('edit_transaction', [
    'pageTitle' => 'Buchungsbearbeitung',
    'userData' => $userData,
    'errors' => $errors,
    'old' => $old
]);
