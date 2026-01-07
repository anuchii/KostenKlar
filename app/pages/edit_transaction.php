<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once ACTIONS_PATH . '/transactions.php';
require_once ACTIONS_PATH . '/transaction_validation.php';



$pageName = "edit_transaction";
$pageTitle = "Buchung bearbeiten";

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

if($_SERVER["REQUEST_METHOD"] === "GET"){
    $transaction_id = (int) $_GET['transaction-id'];
} elseif($_SERVER["REQUEST_METHOD"] === "POST") {
    $transaction_id = (int) $_POST['transaction_id'];   
} else {
    $transaction_id = null;
}

// Fetch categories
$categories = getTransactionCategories($pdo);

// Fetch transaction data
if ($transaction_id) {
    $transactionData = getTransactionByID($transaction_id, $pdo);
    $transactionData["transaction_amount"] = number_format($transactionData["transaction_amount"], 2, ',', '');
}

$validationErrors = [];

// Handle POST request
if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST)) {
    $transactionData = $_POST;

    $validationErrors = validateTransactionData($transactionData);

    if (empty($validationErrors)) {
        $transactionData["transaction_amount"] = floatval(str_replace(',', '.', $transactionData["transaction_amount"]));

        $success = updateTransaction($transactionData, $pdo);

        $transactionDate = $transactionData['transaction_date'];
        $yearMonth = date('Y-m', strtotime($transactionDate));
        header('Location: ' . page_url('user_dashboard') . '&year-month=' . $yearMonth);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">
</head>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <?php include INCLUDES_PATH . '/header.php'; ?>

            <main>
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title p-2"><?php echo $pageTitle ?></h5>
                                <?php include INCLUDES_PATH . '/transaction_form.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php include INCLUDES_PATH . '/footer.php'; ?>
            
</body>
</html>