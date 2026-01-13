<?php
require_once HELPERS_PATH . '/url.php';
if (!empty($_SESSION['user_data'])) {
    $userData = $_SESSION['user_data'];
} else {
    header('Location: ' . page_url('login'));
    exit();
}

$defaultProfileImage = 'https://cdn-icons-png.flaticon.com/512/847/847969.png';


if (!empty($userData['avatar_path'])) {
    $profileImage = upload_url($userData['avatar_path'] ?? null, $defaultProfileImage);
} else {
    $profileImage = $defaultProfileImage;
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">

</head>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <!-- Abmelden-Bar -->
                <?php include INCLUDES_PATH . '/header.php'; ?>
                <header class="py-4 border-bottom p-3">
                    <h2>Mein Profil</h2>
                    <p class="text-muted mb-0">Persönliche Informationen</p>
                </header>

                <!-- Profil-Inhalt -->
                <div class="container py-4">
                    <div class="row gy-3">
                        <!-- Profil-Kästchen  -->
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profilbild"
                                        class="rounded-circle mb-3" width="120" height="120">
                                    <h5 class="card-title mb-0">
                                        <?php echo htmlspecialchars($userData['first_name'] . ' ' . $userData['last_name']); ?>
                                    </h5>

                                    <p class="text-muted"></p>

                                    <?php if (!empty($_SESSION['flash_error'])): ?>
                                        <div class="alert alert-danger py-2" role="alert">
                                            <?= htmlspecialchars($_SESSION['flash_error']) ?>
                                        </div>
                                        <?php unset($_SESSION['flash_error']); ?>
                                    <?php elseif (!empty($_SESSION['flash_success'])): ?>
                                        <div class="alert alert-success py-2" role="alert">
                                            <?= htmlspecialchars($_SESSION['flash_success']) ?>
                                        </div>
                                        <?php unset($_SESSION['flash_success']); ?>
                                    <?php endif; ?>

                                    <form method="POST" enctype="multipart/form-data"
                                        action="<?= route('upload_avatar') ?>">

                                        <div class="mb-2">
                                            <input type="file" name="avatar" accept="image/png, image/jpeg, image/webp"
                                                class="form-control" required>
                                        </div>

                                        <button type="submit" class="btn btn-warning btn-sm">
                                            Hochladen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Details-Kästchen -->
                        <!--TODO: padding einfügen wenn Bildschrim sehr klein,
                          damit allgemeine infos nicht mit Profil-Kästchen pickt-->
                        <div class="col-md-8 ">
                            <form method="POST" action="<?= route('update_profil') ?>">
                            <div class="card shadow-sm mb-3">

                                <div class="card-header bg-light">
                                    <strong>Allgemeine Informationen</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-sm-4 fw-bold" for="first_name">Vorname:</label>
                                        <div class="col-sm-8">
                                            <input id="first_name" name="first_name" type="text" class="form-control"
                                                   value="<?= htmlspecialchars($userData['first_name'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-sm-4 fw-bold" for="last_name">Nachname:</label>
                                        <div class="col-sm-8">
                                            <input id="last_name" name="last_name" type="text" class="form-control"
                                                   value="<?= htmlspecialchars($userData['last_name'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-sm-4 fw-bold" for="gebdatum">Geburtsdatum:</label>
                                        <div class="col-sm-8">
                                            <input id="gebdatum" type="text" class="form-control" 
                                                   value="<?= htmlspecialchars($userData['gebdatum'] ?? '') ?>" readonly>
                                            
                                        </div>
                                    </div>

                                    <div class="row mb-2 align-items-center">
                                        <label class="col-sm-4 fw-bold" for="geschlecht">Geschlecht:</label>
                                        <div class="col-sm-8">
                                            <?php $g = $userData['geschlecht'] ?? ''; ?>
                                            <select id="geschlecht" name="geschlecht" class="form-select" required>
                                                <option value="" <?= $g === '' ? 'selected' : '' ?>>Bitte wählen</option>
                                                <option value="maennlich" <?= $g === 'maennlich' ? 'selected' : '' ?>>Männlich</option>
                                                <option value="weiblich" <?= $g === 'weiblich' ? 'selected' : '' ?>>Weiblich</option>
                                                <option value="divers" <?= $g === 'divers' ? 'selected' : '' ?>>Divers</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Kontakt-Kästchen-->
                            <div class="card shadow-sm ">
                                <div class="card-header bg-light">
                                    <strong>Kontakt</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2 align-items-center">
                                        <label class="col-sm-4 fw-bold" for="email">E-Mail:</label>
                                        <div class="col-sm-8">
                                            <input id="email" name="email" type="email" class="form-control"
                                                   value="<?= htmlspecialchars($userData['email'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Änderungen speichern</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /container -->
            </div><!-- /col-10 -->
        </div><!-- /row -->
    </div><!-- /container-fluid -->
    <?php include INCLUDES_PATH . '/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>