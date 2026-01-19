<?php

require_once __DIR__ . "/../config/paths.php";
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/transactions.php';
require_once HELPERS_PATH . '/transaction_validation.php';

$transactionData = $request['parameters']['POST'];

$errors = validateTransactionData($transactionData);

if (!empty($errors)) {
    $_SESSION['transaction_errors'] = $errors;
    $_SESSION['transaction_old'] = $transactionData;

    header('Location: ' . BASE_URL . '/transaction/edit' . '?id=' . $transactionData['transaction_id']);
    exit;
}

// Prepare transactionData for update
$transactionData["transaction_amount"] = floatval(str_replace(',', '.', $transactionData["transaction_amount"]));

$user_id = $_SESSION["user_data"]["user_id"];

$transactionData["transaction_amount"] = floatval(str_replace(',', '.', $transactionData["transaction_amount"]));

updateTransaction($transactionData, $pdo);

// $transactionDate = $transactionData['transaction_date'];
// $yearMonth = date('Y-m', strtotime($transactionDate));

// header('Location: ' . BASE_URL . '&year-month=' . $yearMonth);
header('Location: ' . BASE_URL . '/dashboard');
exit();