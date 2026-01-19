<?php
require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';
require_once ACTIONS_PATH . '/transactions.php';

$pageName = "Dashboard";



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

<body class="bg-light">
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <!-- Sidebar -->
            <?php include INCLUDES_PATH . '/sidebar_admin.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Header -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h2>Übersicht</h2>
                            <p class="text-muted mb-0">Willkomen Zurück, <?php echo ("{$userData['first_name']} {$userData['last_name']}"); ?></p>
                        </div>
                    </div>
                </header>

                <!-- Profilinhalt -->
                <div class="container py-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Aktive Benutzer</div>
                                            <div class="fw-bold fs-5 text-success">
                                                <?php echo ($userCount); ?>
                                            </div>
                                        </div>
                                        <i class="bi bi-people text-success fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Erfasste Transaktionen</div>
                                            <div class="fw-bold fs-5 text-danger">
                                                <?php echo ($transactionCount); ?>
                                            </div>
                                        </div>
                                        <i class="bi bi-receipt text-danger fs-3"></i>
                                    </div>
                                </div>
                            </div>
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