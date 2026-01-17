<?php
require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';
require_once ACTIONS_PATH . '/transactions.php';

$pageName = "Dashboard";

session_start();

// Require user role 'admin'
require_admin();

$userData = getLoggedUserData();

// Fetch user statistics
$userCount = getActiveUserCount($pdo);
$transactionCount = getTransactionCount($pdo);

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

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <!-- Sidebar -->
            <?php include INCLUDES_PATH . '/sidebar-admin.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Header -->
                <header class="py-4 border-bottom p-3">
                    <h2>Übersicht</h2>
                    <p class="text-muted mb-0"><?php echo ("{$userData['first_name']} {$userData['last_name']}"); ?></p>
                </header>

                <!-- Profilinhalt -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm my-4">
                                <div class="card-header bg-light">
                                    <strong>Statistik</strong>
                                </div>
                                <div class="card-body d-flex flex-column flex-md-row flex-wrap gap-3">
                                    <div class="card flex-fill">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-body-secondary text-success">Aktive Benutzer
                                                </h5>
                                                <h5 class="card-title text-success">
                                                    <?php echo ($userCount); ?>
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="card flex-fill">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-body-secondary text-danger">Erfasste Transaktionen</h5>
                                                <h5 class="card-title text-danger">
                                                    <?php echo ($transactionCount); ?>
                                            </h6>
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

    <?php include INCLUDES_PATH . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>