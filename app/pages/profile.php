<?php include INCLUDES_PATH . '/head.php'; ?>

<body class="bg-light">
    <div class=" container-fluid">
        <div class="row" style="min-height: 100vh">

            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Profil Header -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Mein Profil</h1>
                            <p class="text-muted mb-0">Verwalte deine persönlichen Daten und dein Profilbild.</p>
                        </div>
                    </div>
                </header>

                <!-- Profil-Inhalt -->
                <div class="container py-4">
                    <div class="row g-3">
                        <!-- Profil-Kästchen  -->
                        <div class="col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profilbild"
                                            class="rounded-circle border" width="72" height="72">
                                        <div>
                                            <div class="fw-semibold">
                                                <?php echo htmlspecialchars($userData['first_name'] . ' ' . $userData['last_name']); ?>
                                            </div>
                                            <div class="text-muted small">Profilbild & Konto</div>
                                        </div>
                                    </div>

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
                                        action="<?= BASE_URL . '/avatar/upload' ?>">

                                        <div class="mb-2">
                                            <input type="file" name="avatar" accept="image/png, image/jpeg, image/webp"
                                                class="form-control form-control-sm" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
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
                            <form method="POST" action="<?= BASE_URL . '/profile/update' ?>" novalidate>
                                <div class="card shadow-sm rounded-3">
                                    <div class="card-header bg-white">
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
                                                    <option value="männlich" <?= $g === 'männlich' ? 'selected' : '' ?>>Männlich</option>
                                                    <option value="weiblich" <?= $g === 'weiblich' ? 'selected' : '' ?>>Weiblich</option>
                                                    <option value="divers" <?= $g === 'divers' ? 'selected' : '' ?>>Divers</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Kontakt-Kästchen-->
                                <div class="card shadow-sm rounded-3 mt-3">
                                    <div class="card-header bg-white">
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