<?php
require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/transactions.php';

$pageName = "Dashboard";

// Require login
$userData = getLoggedUserData();

if (!$userData) {
    header('Location: ' . page_url('login'));
    exit();
}

// Jahr & Monat aus Dropdowns
$year = isset($_GET['year']) ? (int) $_GET['year'] : (int) date('Y');
$month = isset($_GET['month']) ? (int) $_GET['month'] : (int) date('m');

// Plausibilitätscheck
$currentYear = (int) date('Y');
if ($year < 2000 || $year > $currentYear + 1) {
    $year = $currentYear;
}
if ($month < 1 || $month > 12) {
    $month = (int) date('m');
}

// Nur für UI
$selectedYearMonth = sprintf('%04d-%02d', $year, $month);

if (!empty($_SESSION["user_data"])) {
    $userData["first_name"] = $_SESSION["user_data"]["first_name"];
    $userData["last_name"] = $_SESSION["user_data"]["last_name"];
    $userData["user_id"] = $_SESSION["user_data"]["user_id"];

    // Fetch transactions for current month and user_id = $_SESSION["user_data"]["user_id]
    $transactions = getTransactionsByUserIDAndMonth($userData["user_id"], $year, $month, $pdo);

    // Fetch sums for current month and user_id = $_SESSION["user_data"]["user_id]
    $expenseSum = (float) getSumByUserIDAndMonth($userData["user_id"], $year, $month, "expense", $pdo)["sum"] ?? 0.00;
    $revenueSum = (float) getSumByUserIDAndMonth($userData["user_id"], $year, $month, "revenue", $pdo)["sum"] ?? 0.00;
    $balance = $revenueSum - $expenseSum;
} else {
    header('Location: ' . page_url('login'));
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

            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Dashboard Header -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Übersicht</h1>
                            <p class="text-muted mb-0">Willkommen zurück,
                                <?php echo ("{$userData['first_name']} {$userData['last_name']}"); ?>.</p>
                        </div>
                        <form method="get" action="<?= page_url('user_dashboard') ?>"
                            class="d-flex align-items-end gap-2">
                            <input type="hidden" id="page-hidden" name="page" value="user_dashboard">
                            <div>
                                <label class="form-label small text-muted mb-1">Abrechnungsmonat</label>
                                <div class="d-flex gap-2">

                                    <select name="year" class="form-select flex-grow-1" style="min-width: 110px;">
                                        <?php
                                        $currentYear = (int) date('Y');
                                        for ($y = $currentYear - 5; $y <= $currentYear; $y++) {
                                            $selected = ($y === $year) ? 'selected' : '';
                                            echo "<option value=\"$y\" $selected>$y</option>";
                                        }
                                        ?>
                                    </select>

                                    <select name="month" class="form-select flex-grow-1">
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $value = sprintf('%02d', $m);
                                            $selected = ($m === $month) ? 'selected' : '';
                                            echo "<option value=\"$value\" $selected>$value</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-nowrap"
                                style="height: 38px;">Anzeigen</button>
                        </form>
                    </div>
                </header>
                <div class="container py-4">
                    <!--Cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Einnahmen</div>
                                            <div class="fw-bold fs-5 text-success">€
                                                <?php echo (number_format($revenueSum, 2, ',', '')); ?></div>
                                        </div>
                                        <i class="bi bi-arrow-down-left-circle text-success fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Ausgaben</div>
                                            <div class="fw-bold fs-5 text-danger">€
                                                <?php echo (number_format($expenseSum, 2, ',', '')); ?></div>
                                        </div>
                                        <i class="bi bi-arrow-up-right-circle text-danger fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Saldo</div>
                                            <div class="fw-bold fs-5">€
                                                <?php echo (number_format($balance, 2, ',', '')); ?></div>
                                        </div>
                                        <i class="bi bi-wallet2 fs-3 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm rounded-3 mb-4">
                                <div class="card-header bg-white">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong>Buchungen</strong>
                                        <a href="<?= page_url('new_transaction') ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>Neue Buchung
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Datum</th>
                                                <th scope="col">Bezeichnung</th>
                                                <th scope="col">Betrag</th>
                                                <th scope="col" class="d-none d-md-table-cell">Kategorie</th>
                                                <th scope="col" class="d-none d-lg-table-cell">Notiz</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($transactions as $transaction): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo (date("d.m.Y", strtotime($transaction["transaction_date"])) ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($transaction["transaction_title"] ?? ""); ?>
                                                    </td>
                                                    <td
                                                        class="<?php echo ($transaction["transaction_type"] === "expense" ? "text-danger" : "text-success"); ?> fw-semibold">
                                                        <?php echo ($transaction["transaction_type"] === "expense" ? "-" : ""); ?>
                                                        <?php echo (number_format($transaction["transaction_amount"], 2, ',', '') ?? ""); ?>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <?php echo ($transaction["category_name"] ?? ""); ?>
                                                    </td>
                                                    <td class="d-none d-lg-table-cell">
                                                        <?php echo ($transaction["transaction_note"] ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-outline-primary btn-sm text-center"
                                                            href="<?= route('show_transaction', ['transaction-id' => $transaction["transaction_id"]]) ?>">Details</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include INCLUDES_PATH . '/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>