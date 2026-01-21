<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/transactions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require login
$userData = getLoggedUserData();
if (!$userData) {
    header('Location: ' . page_url('login'));
    exit();
}

// transaction-id kann aus GET oder POST kommen
$transaction_id = isset($_POST['transaction-id'])
    ? (int)$_POST['transaction-id']
    : (isset($_GET['transaction-id']) ? (int)$_GET['transaction-id'] : null);

if (!$transaction_id) {
    header('Location: ' . page_url('user_dashboard'));
    exit();
}

// Transaction laden
$transactionData = getTransactionByID($transaction_id, $pdo);
if (!$transactionData) {
    header('Location: ' . page_url('user_dashboard'));
    exit();
}

// Gehört die Transaction dem eingeloggten User?
if (($transactionData['user_id'] ?? null) != ($userData['user_id'] ?? null)) {
    header('Location: ' . page_url('user_dashboard'));
    exit();
}

// year-month für Redirect bestimmen (für den Monat der gelöschten Buchung)
$transactionDate = $transactionData['transaction_date'] ?? null;
$yearMonth = $transactionDate ? date('Y-m', strtotime($transactionDate)) : date('Y-m');
$year = explode('-', $yearMonth)[0];
$month = explode('-', $yearMonth)[1];

// Löschen
$success = deleteTransaction($transaction_id, $pdo);

if ($success) {
    header('Location: ' . route('user_dashboard', ['year' => $year, 'month' => $month]));
    exit();
}

echo "Fehler: Buchung konnte nicht gelöscht werden.";
