<?php
    require_once __DIR__ . "/transactions.php";
    require_once __DIR__ . '/transaction_validation.php';
    require_once __DIR__ . '/functions.php';

    $pageName = "Neue Buchung";

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

    // Fetch categories
    $categories = getTransactionCategories($pdo);

    $validationErrors = [];

?>

<?php
    // Handle registration POST request
    if(($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST)) {
        $transactionData = $_POST;
        $success = false;

        $validationErrors = validateTransactionData($transactionData);

        // echo("<pre>");
        // var_dump($transactionData);
        // echo("</pre>");

        

        if(empty($validationErrors)) {
                // TODO: Prepare transactionData for insertion into database
                $transactionData["transaction_amount"] = floatval(str_replace(',', '.', $transactionData["transaction_amount"]));

                $user_id = $_SESSION["user_data"]["user_id"];
                $success = createTransaction($transactionData, $user_id, $pdo);
                header("Location: user_dashboard.php");
                exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KostenKlar–Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="images/logo.png">

</head>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

<?php include __DIR__ . '\header.php'; ?>
    <main>
        <div class="container d-flex justify-content-center align-items-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title p-2">Neue Buchung</h5>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="transaction-date" class="col-form-label">Datum</label>
                                <input type="date" class="form-control<?php echo(!isset($validationErrors["transaction_date"]) ? "" : " is-invalid"); ?>" id="transaction-date" name="transaction_date" value="<?php echo($currentDate); ?>">
                                <?php 
                                    echo(!isset($validationErrors["transaction_date"]) ? "" : 
                                    '<div class="invalid-feedback">' . $validationErrors["transaction_date"] . '</div>');
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="transaction-title" class="col-form-label">Bezeichnung</label>
                                <input type="text" class="form-control<?php echo(!isset($validationErrors["transaction_title"]) ? "" : " is-invalid"); ?>" id="transaction-title" name="transaction_title">
                                <?php 
                                    echo(!isset($validationErrors["transaction_title"]) ? "" : 
                                    '<div class="invalid-feedback">' . $validationErrors["transaction_title"] . '</div>');
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="transaction-amount" class="col-form-label">Betrag</label>
                                <input type="text" pattern="\d+,\d{2}" class="form-control<?php echo(!isset($validationErrors["transaction_amount"]) ? "" : " is-invalid"); ?>"" id="transaction-amount" name="transaction_amount" placeholder="0,00">
                                <?php 
                                    echo(!isset($validationErrors["transaction_amount"]) ? "" :
                                    '<div class="invalid-feedback">' . $validationErrors["transaction_amount"] . '</div>');
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="transaction-note" class="col-form-label">Notiz</label>
                                <textarea class="form-control" id="transaction-note" name="transaction_note"></textarea>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="category" class="col-form-label">Kategorie</label>
                                    <select class="form-select" id="category" name="transaction_category">
                                        <?php foreach($categories as $category): ?>
                                            <option value="<?php echo(($category["category_id"])); ?>"><?php echo($category["category_name"]); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Buchungstyp</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="transaction_type" id="expense" value="expense" checked>
                                    <label class="form-check-label" for="expense">Ausgabe</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="transaction_type" id="revenue" value="revenue">
                                    <label class="form-check-label" for="revenue">Einnahme</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning m-2">Speichern</button>
                            <a href="user_dashboard.php" type="button" class="btn btn-secondary">Schließen</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include __DIR__ . '/footer.php'; ?>

