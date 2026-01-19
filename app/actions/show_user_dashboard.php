<?php
require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/transactions.php';

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

// Jahr & Monat aus Dropdowns
$year  = isset($request['parameters']['GET']['year'])  ? (int)$_GET['year']  : (int)date('Y');
$month = isset($request['parameters']['GET']['month']) ? (int)$_GET['month'] : (int)date('m');

// Plausibilitätscheck
$currentYear = (int)date('Y');
if ($year < 2000 || $year > $currentYear + 1) {
    $year = $currentYear;
}
if ($month < 1 || $month > 12) {
    $month = (int)date('m');
}

// Nur für UI
$selectedYearMonth = sprintf('%04d-%02d', $year, $month);

$userData["first_name"] = $_SESSION["user_data"]["first_name"];
$userData["last_name"] = $_SESSION["user_data"]["last_name"];
$userData["user_id"] = $_SESSION["user_data"]["user_id"];

// Fetch transactions for current month and user_id = $_SESSION["user_data"]["user_id]
$transactions = getTransactionsByUserIDAndMonth($userData["user_id"], $year, $month, $pdo);

// Fetch sums for current month and user_id = $_SESSION["user_data"]["user_id]
$expenseSum = (float) getSumByUserIDAndMonth($userData["user_id"], $year, $month, "expense", $pdo)["sum"] ?? 0.00;
$revenueSum = (float) getSumByUserIDAndMonth($userData["user_id"], $year, $month, "revenue", $pdo)["sum"] ?? 0.00;
$balance = $revenueSum - $expenseSum;

render('user_dashboard', [
    'pageTitle' => 'Dashboard',
    'userData' => $userData,
    'transactions' => $transactions,
    'expenseSum' => $expenseSum,
    'revenueSum' => $revenueSum,
    'balance' => $balance,
    'year' => $year,
    'month' => $month
]);