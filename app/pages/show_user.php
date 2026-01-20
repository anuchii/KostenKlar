<?php
require_once __DIR__ . "/../config/paths.php";
require_once HELPERS_PATH . '/url.php';
require_once HELPERS_PATH . '/functions.php';
require_once HELPERS_PATH . '/users.php';

$pageName = "Benutzerdetails";



// Require user role 'admin'
require_admin();

$user_id = isset($_GET['user-id'])
    ? (int) $_GET['user-id']
    : null;

if ($user_id) {
    // Fetch user
    $user = getUserDataByUserID($user_id, $pdo);
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
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">ID</th>
                                                <td>
                                                    <?php echo ($user["user_id"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Vorname</th>
                                                <td>
                                                    <?php echo ($user["first_name"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Nachname</th>
                                                <td>
                                                    <?php echo ($user["last_name"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-Mail</th>
                                                <td>
                                                    <?php echo ($user["email"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Geschlecht</th>
                                                <td>
                                                    <?php echo ($user["geschlecht"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Geburtsdatum</th>
                                                <td>
                                                    <?php echo (isset($user["gebdatum"]) ? date("d.m.Y", strtotime($user["gebdatum"])) : ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Rolle</th>
                                                <td>
                                                    <?php echo ($user["role"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td>
                                                    <?php echo ($user["status"] ?? ""); ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="mb-3 me-3 d-inline">
                                        <a href="<?= route('edit_user', ['user-id' => $user["user_id"]]) ?>" type="button"
                                            class="btn btn-primary text-nowrap">
                                            <i class="bi bi-pencil text-black" aria-hidden="true"></i>
                                            Bearbeiten
                                        </a>
                                    </div>


                                    <div class="mb-3 me-3 d-inline">
                                        <form action="<?= route('delete_user', ['user-id' => $user["user_id"]]) ?>" method="post" class="d-inline" onsubmit="return confirm('Eintrag wirklich löschen?');">
                                            <input type="hidden" name="user_id" value="<?= (int) $user["user_id"] ?>">
                                            <button type="submit" class="btn btn-primary text-nowrap" aria-hidden="true">
                                                <i class="bi bi-trash text-black"></i>
                                                Löschen
                                            </button>
                                        </form>
                                    </div>
                                    <div class="mb-3 me-3 d-inline">
                                        <form action="<?= route('deactivate_user', ['user-id' => $user['user_id']]) ?>" method="post" class="d-inline"
                                            onsubmit="return confirm('Benutzer wirklich deaktivieren?');">
                                            <button type="submit" class="btn btn-primary text-nowrap">
                                                <i class="bi bi-person-x text-black" aria-hidden="true"></i>
                                                Inaktivieren
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