<?php
require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/transactions.php';


$pageName = "Buchungsdetails";



// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . page_url('login'));
    exit();
}

// TODO:
// Require status = active
// Require role = user

$transaction_id = isset($_GET['transaction-id'])
    ? (int) $_GET['transaction-id']
    : null;

if ($transaction_id) {
    // Fetch transaction
    $transaction = getTransactionByID($transaction_id, $pdo);
}

// Check if transaction exists and belongs to logged in user
if (!$transaction || $transaction["user_id"] != $userData["user_id"]) {
    // Redirect to dashboard if transaction is invalid
    // TODO: Redirect to dashboard and flash error message
    header('Location: ' . page_url('user_dashboard'));
    exit();
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageName ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">

</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <!-- Sidebar -->
            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Header -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Buchungsdetails</h1>
                            <p class="text-muted mb-0">Details zur ausgewählten Buchung.</p>
                        </div>
                        <a href="<?= page_url('user_dashboard') ?>" class="btn btn-outline-secondary" style="height: 38px;">Zurück</a>
                    </div>
                </header>

                <!-- Profilinhalt -->
                <div class="container py-4">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-header bg-white">
                                    <strong>Details</strong>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Datum</th>
                                                <td>
                                                    <?php echo (date("d.m.Y", strtotime($transaction["transaction_date"])) ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Bezeichnung</th>
                                                <td>
                                                    <?php echo ($transaction["transaction_title"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Betrag</th>
                                                <td>
                                                    <span class="fw-semibold <?= ($transaction['transaction_type'] === 'expense') ? 'text-danger' : 'text-success' ?>">
                                                        <?php echo (number_format($transaction["transaction_amount"], 2, ',', '') ?? ""); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kategorie</th>
                                                <td>
                                                    <?php echo ($transaction["category_name"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Notiz</th>
                                                <td>
                                                    <?php echo ($transaction["transaction_note"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Typ</th>
                                                <td>
                                                    <span class="badge <?= ($transaction['transaction_type'] === 'revenue') ? 'bg-success' : 'bg-danger' ?>">
                                                        <?php echo ($transaction["transaction_type"] == 'revenue' ? "Einnahme" : "Ausgabe"); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="d-flex gap-2 p-3">
                                        <a href="<?= route('edit_transaction', ['transaction-id' => $transaction['transaction_id']]) ?>"
                                            class="btn btn-primary">
                                            <i class="bi bi-pencil me-1" aria-hidden="true"></i>Bearbeiten
                                        </a>

                                        <form action="<?= route('delete_transaction', ['transaction-id' => $transaction['transaction_id']]) ?>"
                                            method="post" onsubmit="return confirm('Eintrag wirklich löschen?');">
                                            <input type="hidden" name="transaction-id" value="<?= (int) $transaction['transaction_id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash me-1" aria-hidden="true"></i>Löschen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /container -->
            </div><!-- /col-10 -->
        </div><!-- /row -->
    </div><!-- /container-fluid -->

    <?php include INCLUDES_PATH . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>