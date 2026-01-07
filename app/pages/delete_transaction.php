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

$success = deleteTransaction($transaction_id, $pdo);

if ($success) {
    // Redirect to transactions page after successful deletion
    header('Location: ' . page_url('user_dashboard'));
    exit();
} else {
    // Handle error (e.g., transaction not found or deletion failed)
    echo "Error: Unable to delete the transaction.";
}