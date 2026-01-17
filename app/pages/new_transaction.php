<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once ACTIONS_PATH . '/transactions.php';
require_once ACTIONS_PATH . '/transaction_validation.php';

$pageName = "new_transaction";
$pageTitle = "Neue Buchung";



// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . page_url('login'));
    exit();
}

// TODO:
// Require status = active
// Require role = user

$currentDate = date('Y-m-d');

$transactionData = [
    "transaction_date" => $currentDate,
    "transaction_title" => "",
    "transaction_amount" => "",
    "transaction_note" => "",
    "category_id" => "",
    "transaction_type" => "expense",
];

// Fetch categories
$categories = getTransactionCategories($pdo);

$validationErrors = [];

?>

<?php
// Handle registration POST request
if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST)) {
    $transactionData = $_POST;

    $validationErrors = validateTransactionData($transactionData);

    if (empty($validationErrors)) {
        // TODO: Prepare transactionData for insertion into database
        $transactionData["transaction_amount"] = floatval(str_replace(',', '.', $transactionData["transaction_amount"]));

        $user_id = $_SESSION["user_data"]["user_id"];
        createTransaction($transactionData, $user_id, $pdo);

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

<body class="bg-light">
    <div class="container-fluid">
        <div class="row min-vh-100">

            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <div class="col-12 col-lg-10 p-0">
                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Page Header (Dashboard Style) -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Neue Buchung</h1>
                            <p class="text-muted mb-0">Erstelle eine neue Einnahme oder Ausgabe.</p>
                        </div>
                        <a href="<?= page_url('user_dashboard') ?>" class="btn btn-outline-secondary" style="height: 38px;">Zurück</a>
                    </div>
                </header>

                <main>
                    <div class="container py-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                                <div class="card shadow-sm rounded-3">
                                    <div class="card-header bg-white">
                                        <strong>Buchungsdetails</strong>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="<?= page_url('new_transaction') ?>">
                                            <div class="mb-3">
                                                <label for="transaction-date" class="col-form-label">Datum</label>
                                                <input type="date"
                                                    class="form-control<?php echo (!isset($validationErrors["transaction_date"]) ? "" : " is-invalid"); ?>"
                                                    id="transaction-date" name="transaction_date"
                                                    value="<?php echo ($currentDate); ?>">
                                                <?php
                                                echo (!isset($validationErrors["transaction_date"]) ? "" :
                                                    '<div class="invalid-feedback">' . $validationErrors["transaction_date"] . '</div>');
                                                ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction-title" class="col-form-label">Bezeichnung</label>
                                                <input type="text"
                                                    class="form-control<?php echo (!isset($validationErrors["transaction_title"]) ? "" : " is-invalid"); ?>"
                                                    id="transaction-title" name="transaction_title">
                                                <?php
                                                echo (!isset($validationErrors["transaction_title"]) ? "" :
                                                    '<div class="invalid-feedback">' . $validationErrors["transaction_title"] . '</div>');
                                                ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction-amount" class="col-form-label">Betrag</label>
                                                <input type="text" pattern="\d+,\d{2}"
                                                    class="form-control<?php echo (!isset($validationErrors["transaction_amount"]) ? "" : " is-invalid"); ?>"
                                                    id="transaction-amount" name="transaction_amount" placeholder="0,00">
                                                <?php
                                                echo (!isset($validationErrors["transaction_amount"]) ? "" :
                                                    '<div class="invalid-feedback">' . $validationErrors["transaction_amount"] . '</div>');
                                                ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction-note" class="col-form-label">Notiz</label>
                                                <textarea class="form-control" id="transaction-note" name="transaction_note" rows="3"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="category" class="col-form-label">Kategorie</label>
                                                    <select class="form-select" id="category" name="transaction_category">
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo (($category["category_id"])); ?>">
                                                                <?php echo ($category["category_name"]); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Buchungstyp</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="transaction_type"
                                                        id="expense" value="expense" checked>
                                                    <label class="form-check-label" for="expense">Ausgabe</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="transaction_type"
                                                        id="revenue" value="revenue">
                                                    <label class="form-check-label" for="revenue">Einnahme</label>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 mt-3">
                                                <button type="submit" class="btn btn-primary">Speichern</button>
                                                <a href="<?= page_url('user_dashboard') ?>" class="btn btn-outline-secondary">Abbrechen</a>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
    </div>
    <?php include INCLUDES_PATH . '/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>