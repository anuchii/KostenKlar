<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once ACTIONS_PATH . '/transactions.php';
require_once ACTIONS_PATH . '/transaction_validation.php';

session_start();

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . page_url('login'));
    exit();
}

// TODO:
// Require status = active
// Require role = user

$transaction_id = isset($_GET['transaction-id']) ? (int) $_GET['transaction-id'] : 0;

if ($transaction_id) {
    $transactionData = getTransactionByID($transaction_id, $pdo);
    $transactionDate = $transactionData['transaction_date'];
    $yearMonth = date('Y-m', strtotime($transactionDate));
    print_r($transactionData);
    print_r($yearMonth);
}

$success = deleteTransaction($transaction_id, $pdo);

if ($success) {
    // Redirect to user dashboard after successful deletion
    header('Location: ' . page_url('user_dashboard') . '&year-month=' . $yearMonth);
    exit();
} else {
    // Handle error (e.g., transaction not found or deletion failed)
    echo "Fehler: Buchung konnte nicht gelöscht werden.";
}