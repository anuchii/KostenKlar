<?php
require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/validator.php';
require_once HELPERS_PATH . '/transactions.php';
require_once HELPERS_PATH . '/users.php';
require_once HELPERS_PATH . '/flash.php';
require_once HELPERS_PATH . '/form.php';

$pageTitle = 'Buchung bearbeiten';
$postAction = page_url('edit_transaction');

// Login prüfen
$userId = $_SESSION['user_data']['user_id'] ?? ($_SESSION['user_data']['id'] ?? null);
if ($userId === null) {
    header('Location: ' . page_url('login'));
    exit;
}
// Kategorien laden
$categories = getTransactionCategories($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rules = [
        'transaction_id' => [],
        'transaction_date' => ['required', 'date'],
        'transaction_title' => ['required', 'max:255'],
        'transaction_amount' => ['required', 'money'],
        'transaction_note' => [],
        'transaction_category_id' => ['required'],
        'transaction_type' => ['required'],
    ];

    [$clean, $errors] = validate($_POST, $rules);

    if (!empty($errors)) {
        // Aktuelle Eingaben in Session speichern
        $_SESSION['transaction_old'] = $clean;
        $_SESSION['transaction_errors'] = $errors;

        header('Location: ' . route('edit_transaction', ['transaction-id' => $clean['transaction_id']]));
        exit;
    }
    // Buchung updaten
    $userId = $_SESSION["user_data"]["user_id"];

    $ok = updateTransaction($clean, $pdo);

    $transactionDate = $clean['transaction_date'];
    $yearMonth = date('Y-m', strtotime($transactionDate));
    $year = explode('-', $yearMonth)[0];
    $month = explode('-', $yearMonth)[1];
    header('Location: ' . route('user_dashboard', ['year' => $year, 'month' => $month]));
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $transaction_id = $_GET['transaction-id'];

    $transaction = getTransactionByID($transaction_id, $pdo);
    $validationErrors = $_SESSION['transaction_errors'] ?? [];
    $old = $_SESSION['transaction_old'] ?? $transaction;
    unset($_SESSION['transaction_errors'], $_SESSION['transaction_old']);
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
                <!-- Edit-Transaktion Header-->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Buchung bearbeiten</h1>
                            <p class="text-muted mb-0">Passe die Details deiner Buchung an.</p>
                        </div>
                        <a href="<?= page_url('user_dashboard') ?>" class="btn btn-outline-secondary"
                            style="height: 38px;">Zurück</a>
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
                                        <?php include INCLUDES_PATH . '/transaction_form.php'; ?>
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