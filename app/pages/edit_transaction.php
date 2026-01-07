<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once ACTIONS_PATH . '/transactions.php';
require_once ACTIONS_PATH . '/transaction_validation.php';



$pageName = "edit_transaction";

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
?>

<?php
// Handle POST request
if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST)) {
    $transactionData = $_POST;

    $validationErrors = validateTransactionData($transactionData);

    print_r($transactionData);

    if (empty($validationErrors)) {
        $transactionData["transaction_amount"] = floatval(str_replace(',', '.', $transactionData["transaction_amount"]));

        $success = updateTransaction($transactionData, $pdo);
        header('Location: ' . page_url('user_dashboard'));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neue Buchung</title>
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
                                <h5 class="card-title p-2">Neue Buchung</h5>
                                <form method="post" action="<?= page_url('edit_transaction') ?>">
                                    <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
                                    <div class="mb-3">
                                        <label for="transaction-date" class="col-form-label">Datum</label>
                                        <input type="date"
                                            class="form-control<?php echo (!isset($validationErrors["transaction_date"]) ? "" : " is-invalid"); ?>"
                                            id="transaction-date" name="transaction_date"
                                            value="<?php echo htmlspecialchars($transactionData['transaction_date'] ?? '') ?>">
                                        <?php
                                        echo (!isset($validationErrors["transaction_date"]) ? "" :
                                            '<div class="invalid-feedback">' . $validationErrors["transaction_date"] . '</div>');
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="transaction-title" class="col-form-label">Bezeichnung</label>
                                        <input type="text"
                                            class="form-control<?php echo (!isset($validationErrors["transaction_title"]) ? "" : " is-invalid"); ?>"
                                            id="transaction-title" name="transaction_title" 
                                            value="<?php echo htmlspecialchars($transactionData['transaction_title'] ?? '') ?>">
                                        <?php
                                        echo (!isset($validationErrors["transaction_title"]) ? "" :
                                            '<div class="invalid-feedback">' . $validationErrors["transaction_title"] . '</div>');
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="transaction-amount" class="col-form-label">Betrag</label>
                                        <input type="text" pattern="\d+,\d{2}"
                                            class="form-control<?php echo (!isset($validationErrors["transaction_amount"]) ? "" : " is-invalid"); ?>" id="
                                            transaction-amount" name="transaction_amount" placeholder="0,00"
                                            value="<?php echo ($transactionData["transaction_amount"] ?? ""); ?>">
                                        <?php
                                        echo (!isset($validationErrors["transaction_amount"]) ? "" :
                                            '<div class="invalid-feedback">' . $validationErrors["transaction_amount"] . '</div>');
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="transaction-note" class="col-form-label">Notiz</label>
                                        <textarea class="form-control" id="transaction-note"
                                            name="transaction_note"><?php echo htmlspecialchars($transactionData['transaction_note'] ?? '') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="category" class="col-form-label">Kategorie</label>
                                            <select class="form-select" id="category" name="category_id">
                                                <?php foreach ($categories as $category): ?>
                                                    <option 
                                                    value="<?php echo (($category["category_id"])); ?>" 
                                                    <?php echo ($transactionData["category_id"] == $category["category_id"] ? 'selected' : ''); ?>
                                                    >
                                                        <?php echo ($category["category_name"]); ?>
                                                    </option>
                                                        
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Buchungstyp</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="transaction_type"
                                                id="expense" value="expense" <?= $transactionData['transaction_type'] === 'expense'? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expense">Ausgabe</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="transaction_type"
                                                id="revenue" value="revenue" <?= $transactionData['transaction_type'] === 'revenue'? 'checked' : '' ?>>
                                            <label class="form-check-label" for="revenue">Einnahme</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning m-2">Speichern</button>
                                  <a href="<?= page_url('user_dashboard') ?>" class="btn btn-secondary">Schließen</a>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include INCLUDES_PATH . '/footer.php'; ?>
</body>
</html>