<?php
    require_once __DIR__ . "/transactions.php";
    require_once __DIR__ . '/transaction_validation.php';
    require_once __DIR__ . '/functions.php';

    $pageName = "Dashboard";

    session_start();

     // Require login
    $userData = getLoggedUserData();

    if(!$userData) {
        header("Location: login.php");
        exit();
    }

    // TODO:
    // Require status = active
    // Require role = user

    $year = (int) date('Y');
    $month = (int) date('m');
    $yearMonth = date('Y-m');
    $currentDate = date('Y-m-d');



    if(!empty($_SESSION["user_data"])) {
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
        header("Location: login.php");
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
    <link rel="icon" type="image/png" href="images/logo.png">

</head>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include 'header.php';?>
                
                <!-- Header -->
                <header class="py-4 border-bottom p-3">
                    <h2>Übersicht</h2>
                    <p class="text-muted mb-0"><?php echo("{$userData['first_name']} {$userData['last_name']}"); ?></p>
                </header>

                <!-- Profilinhalt -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm my-4">
                                <div class="card-header bg-light">
                                    <strong>Abrechnungsmonat</strong>
                                </div>
                                <div class="card-body">
					                <input type="month" class="form-control" id="month" name="month" value="<?php echo($yearMonth); ?>" style="width: auto";>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <strong>Buchungen</strong>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th scope="col">Datum</th>
                                            <th scope="col">Bezeichnung</th>
                                            <th scope="col">Betrag</th>
                                            <th scope="col" class="d-none d-md-table-cell">Kategorie</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Notiz</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($transactions as $transaction): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo(date("d.m.Y", strtotime($transaction["transaction_date"])) ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo($transaction["transaction_title"] ?? ""); ?>
                                                    </td>
                                                    <td class="<?php echo($transaction["transaction_type"] === "expense" ? "text-danger" : "text-success"); ?>">
                                                        <?php echo($transaction["transaction_type"] === "expense" ? "-" : ""); ?>
                                                        <?php echo(number_format($transaction["transaction_amount"], 2, ',', '') ?? ""); ?>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <?php echo($transaction["category_name"] ?? ""); ?>
                                                    </td>
                                                    <td class="d-none d-lg-table-cell">
                                                        <?php echo($transaction["transaction_note"] ?? ""); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                   
                                    <div class="mb-3">
                                        <a href="new_transaction.php" type="button" class="btn btn-warning">
                                            <i class="bi bi-plus-circle text-black"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <strong>Summen</strong>
                                </div>
                                <div class="card-body d-flex flex-column flex-md-row flex-wrap gap-3">
                                    <div class="card flex-fill">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-body-secondary text-success">Einnahmen</h5>
                                            <h5 class="card-title text-success">EUR <?php echo(number_format($revenueSum, 2, ',', '')); ?></h6>
                                        </div>
                                    </div>

                                    <div class="card flex-fill">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-body-secondary text-danger">Ausgaben</h5>
                                            <h5 class="card-title text-danger">EUR <?php echo(number_format($expenseSum, 2, ',', '')); ?></h6>
                                        </div>
                                    </div>

                                    <div class="card flex-fill">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-body-secondary danger">Saldo</h5>
                                            <h5 class="card-title">EUR <?php echo(number_format($balance, 2, ',', '')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          
            </div><!-- /col-10 -->
        </div><!-- /row -->
    </div><!-- /container-fluid -->

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>