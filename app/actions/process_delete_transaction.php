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

$transaction_id = (int) $request['parameters']['POST']['transaction_id'] ?? null;

if ($transaction_id) {
    $transactionData = getTransactionByID($transaction_id, $pdo);
    $transactionDate = $transactionData['transaction_date'];
    $yearMonth = date('Y-m', strtotime($transactionDate));
}

// Check if transaction exists and belongs to logged in user
if (!$transactionData || ($transactionData["user_id"] != $userData["user_id"])) {
    // Redirect to dashboard if transaction is invalid
    // TODO: Redirect to dashboard and flash error message
    header('Location: ' . BASE_URL . '/dashboard');
    exit();
}

$success = deleteTransaction($transaction_id, $pdo);

if ($success) {
    // Redirect to user dashboard after successful deletion
   header('Location: ' . BASE_URL . '/dashboard');
    exit();
} else {
    // Handle error (e.g., transaction not found or deletion failed)
    // TODO: Redirect to dashboard and flash error message
    echo "Fehler: Buchung konnte nicht gelöscht werden.";
}