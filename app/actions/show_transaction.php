<?php

require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/transactions.php';
require_once APP_PATH . '/rendering.php';

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

$transaction_id = (int) $request['parameters']['GET']['id'] ?? null;

if ($transaction_id) {
    // Fetch transaction
    $transaction = getTransactionByID($transaction_id, $pdo);
}

// Check if transaction exists and belongs to logged in user
if (!$transaction || $transaction["user_id"] != $userData["user_id"]) {
    // Redirect to dashboard if transaction is invalid
    // TODO: Redirect to dashboard and flash error message
    header('Location: ' . BASE_URL . '/dashboard');
    exit();
}

render('transaction', [
    'pageTitle' => 'Buchungsdetails',
    'transaction' => $transaction,
    'userData' => $userData
]);
