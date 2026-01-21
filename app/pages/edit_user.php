<?php

require_once __DIR__ . '/../config/paths.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';

$pageTitle = "Benutzer bearbeiten";
$postAction = page_url('edit_user');

require_login_or_redirect('login');
require_role_or_abort('admin');

$user_id = (int) ($_GET['user_id'] ?? ($_GET['user-id'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once ACTIONS_PATH . '/edit_user_action.php';
    exit;
}
// Fetch user data
if ($user_id > 0) {
    $userData = getUserDataByUserID($user_id, $pdo);
}

if (empty($userData)) {
    header('Location: ' . page_url('user_management'));
    exit;
}

$validationErrors = $_SESSION['edit_user_errors'] ?? [];
$old = $_SESSION['edit_user_old'] ?? [];
unset($_SESSION['edit_user_errors'], $_SESSION['edit_user_old']);

if (!empty($old)) {

    foreach (['first_name', 'last_name', 'status'] as $key) {
        if (array_key_exists($key, $old)) {
            $userData[$key] = $old[$key];
        }
    }
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

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">
            <?php include INCLUDES_PATH . '/sidebar_admin.php'; ?>
            <div class="col-12 col-lg-10 p-0">
                <?php include INCLUDES_PATH . '/header.php'; ?>
                <header class="py-4 border-bottom p-3">
                    <h2>Benutzerdetails</h2>
                </header>
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
                </div>
            </div>
        </div>
    </div>
    <?php include INCLUDES_PATH . '/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>