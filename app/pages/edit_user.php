<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';

$pageTitle = "Benutzer bearbeiten";
$postAction = page_url('edit_user');

// Require user role 'admin'
require_admin();

if($_SERVER["REQUEST_METHOD"] === "GET"){
    $user_id = (int) $_GET['user-id'];
} elseif($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = (int) $_POST['user_id'];   
} else {
    $user_id = null;
}


// Fetch user data
if ($user_id) {
    $userData = getUserDataByUserID($user_id, $pdo);
}

$validationErrors = [];

// Handle POST request
if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST)) {
    $userData = $_POST;
    
    // Validate input
    $first_name = trim($_POST["first_name"] ?? '');
    if ($first_name === '') {
        $validationErrors["first_name"] = "Bitte geben Sie einen Vornamen ein.";
    }

    $last_name = trim($_POST["last_name"] ?? '');
    if ($last_name === '') {
        $validationErrors["last_name"] = "Bitte geben Sie einen Nachnamen ein.";
    }

    if (empty($validationErrors)) {

        updateUser($userData, $pdo);

        // Redirect to user management
        header('Location: ' . page_url('user_management'));
        exit();
    }
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

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <!-- Sidebar -->
            <?php include INCLUDES_PATH . '/sidebar_admin.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Header -->
                <header class="py-4 border-bottom p-3">
                    <h2>Benutzerdetails</h2>
                </header>

                <!-- Profilinhalt -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm my-4">
                                <div class="card-body">
                                    <?php include INCLUDES_PATH . '/user_form.php'; ?>
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