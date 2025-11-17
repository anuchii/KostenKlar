<?php
    require_once __DIR__ . "/transactions.php";

    $pageName = "Dashboard";

    session_start();
    $year = (int) date('Y');
    $month = (int) date('m');
    $yearMonth = date('Y-m');
    $currentDate = date('Y-m-d');

    // Require login
    // Require status = active
    // Require role = user

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
        header("Location: login_page.php");
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
            <div class="col-12 col-lg-2 bg-secondary p-0">
                <div class="sticky-top">
                    <nav
                        class="navbar navbar-dark navbar-expand-lg bg-secondary border-bottom flex-lg-column align-items-stretch p-3">
                        <div class="container-fluid flex-lg-column align-items-stretch">

                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <a class="navbar-brand d-flex align-items-center text-white gap-2" href="#">
                                    <img src="images/logo_schnell3.png" alt="KostenKlar Logo" width="30" height="30"
                                        class="d-inline-block align-text-top">
                                    <span>KostenKlar</span>
                                </a>


                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                                    aria-label="Menü umschalten">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>
                            <hr>

                            <div class="collapse navbar-collapse w-100 mt-3" id="sidebarMenu">
                                <ul class="navbar-nav flex-column w-100">
                                    <li class="nav-item"><a class="nav-link text-white"
                                            href="dashboard.html">Übersicht</a></li>
                                    <li class="nav-item"><a class="nav-link text-white" href="#">Statistik</a></li>
                                    <li class="nav-item"><a class="nav-link active text-white" aria-current="page"
                                            href="profil.html">Profil</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <!-- Abmelden-Bar -->
                <nav class="navbar navbar-expand-lg bg-secondary border-bottom px-0 me-0">
                    <div class="container-fluid px-0">
                        <ul class="navbar-nav ms-auto me-0">
                            <li class="nav-item me-0">

                                <a class="btn btn-warning text-dark pe-3 me-3" href="login.php">
                                    Abmelden <i class="bi bi-arrow-bar-right  text-dark ps-1"></i>
                                </a>

                            </li>
                        </ul>
                    </div>
                </nav>

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
                                            <th scope="col">Kategorie</th>
                                            <th scope="col">Notiz</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($transactions as $transaction): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo(date("d.m.Y", strtotime($transaction["transaction_date"])) ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo($transaction["transaction_description"] ?? ""); ?>
                                                    </td>
                                                    <td class="<?php echo($transaction["transaction_type"] === "expense" ? "text-danger" : "text-sucess"); ?>">
                                                        <?php echo($transaction["transaction_amount"] ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo($transaction["category_name"] ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo($transaction["transaction_note"] ?? ""); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <!-- Button trigger modal -->
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#new-modal">
                                            <i class="bi bi-plus-circle text-white"></i>
                                        </button>
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

    <footer class="bg-secondary text-white text-center py-3 mt-1">
        <p>© 2025 KostenKlar </p>
        <a href="impressum.html" class="text-white-50 me-2">Impressum</a>
        <a href="datenschutz.html" class="text-white-50">Datenschutz</a>
    </footer>

     <!-- Modal -->
                    <div class="modal fade" id="new-modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Neue Buchung</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="transaction-date" class="col-form-label">Datum</label>
                                            <input type="date" class="form-control" id="transaction-date" value="<?php echo($currentDate); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="transaction-title" class="col-form-label">Bezeichnung</label>
                                            <input type="text" class="form-control" id="transaction-title"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="transaction-amount" class="col-form-label">Betrag</label>
                                            <input type="number" class="form-control" id="transaction-amount" step="0.01" min="0" placeholder="0,00"></textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="transaction-note" class="col-form-label">Notiz</label>
                                            <textarea class="form-control" id="transaction-note"></textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label for="category" class="col-form-label">Kategorie</label>
                                                <select class="form-select" id="category">
                                                    <option>Lebensmittel</option>
                                                    <option>Mobilität</option>
                                                    <option>Haushalt</option>
                                                    <option>Wohnen</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Buchungstyp</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transaction-type" id="expense" value="option1" checked>
                                                <label class="form-check-label" for="expense">Ausgabe</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transaction-type" id="income" value="option2">
                                                <label class="form-check-label" for="income">Einnahme</label>
                                            </div>
                                            
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    <button type="button" class="btn btn-secondary">Speichern</button>
                                </div>
                            </div>
                        </div>
                    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>