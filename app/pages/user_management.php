<?php
    require_once __DIR__ . '/../config/db_config.php';
    require_once HELPERS_PATH . '/url.php';
    require_once CONFIG_PATH . '/db_config.php';
    require_once HELPERS_PATH . '/users.php';
    require_once HELPERS_PATH . '/functions.php';
    
    $pageName = 'Benutzerverwaltung';

    session_start();

    // Require user role 'admin'
    require_admin();

    // Fetch users
    $users = getAllUsers($pdo);

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
                    <h2>Benutzerverwaltung</h2>
                </header>

                <!-- Profilinhalt -->
                <div class="container">
                   

                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm my-4">
                                <div class="card-header bg-light">
                                    <strong>Benutzer</strong>
                                </div>
                                <div class="card-body">
                                    
                                <?php include INCLUDES_PATH . '/user_table.php'; ?>

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