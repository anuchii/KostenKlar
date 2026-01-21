<?php
require_once HELPERS_PATH . '/url.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KostenKlar – Überblick über deine Finanzen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
      <link href="<?= asset_url('css/start.css') ?>" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">
</head>

<body class="bg-light d-flex flex-column min-vh-100 pb-5">
    <?php include_once INCLUDES_PATH . '/nav_public.php' ?>
    <main class="flex-grow-1">
    <!-- Hero -->
    <header class="py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-6">

                    <h1 class="display-5 fw-bold">Behalte deine Ausgaben im Blick – einfach, schnell, klar.</h1>
                    <p class="lead text-muted mt-3 mb-4">
                        KostenKlar hilft dir, Transaktionen zu erfassen, Statistiken zu sehen und deine Finanzen besser zu verstehen.
                        Ohne unnötigen Aufwand.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-primary btn-lg" href="<?= page_url('register') ?>">
                            Kostenlos starten
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <a class="btn btn-outline-secondary btn-lg" href="<?= page_url('login') ?>">Ich habe schon einen Account</a>
                    </div>
                    <div class="d-flex gap-4 mt-4 text-muted small">
                        <div class="d-flex align-items-center gap-2"><i class="bi bi-shield-check"></i> Intuitiv</div>
                        <div class="d-flex align-items-center gap-2"><i class="bi bi-lightning-charge"></i> In Minuten startklar</div>
                        <div class="d-flex align-items-center gap-2"><i class="bi bi-graph-up"></i> Klarer Überblick</div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-semibold">Beispiel: Monatsübersicht</div>
                                <span class="badge text-bg-light">Preview</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded">
                                        <div class="text-muted small">Einnahmen</div>
                                        <div class="fs-5 fw-semibold">€ 1.850</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded">
                                        <div class="text-muted small">Ausgaben</div>
                                        <div class="fs-5 fw-semibold">€ 1.210</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 bg-light rounded">
                                        <div class="d-flex justify-content-between">
                                            <div class="text-muted small">Gesamt</div>
                                            <div class="fw-semibold">€ 640</div>
                                        </div>
                                        <div class="text-muted small mt-2">Budget-Auslastung (Demo)</div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Funktionen -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Was du mit KostenKlar machen kannst</h2>
                <p class="text-muted mb-0">Die wichtigsten Features – kompakt, praktisch, übersichtlich.</p>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-plus-circle fs-4"></i>
                                <h5 class="mb-0">Transaktionen erfassen</h5>
                            </div>
                            <p class="text-muted mb-0">Einnahmen & Ausgaben schnell eintragen und kategorisieren.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-graph-up fs-4"></i>
                                <h5 class="mb-0">Statistiken</h5>
                            </div>
                            <p class="text-muted mb-0">Sieh, wo dein Geld hingeht – klare Auswertungen statt Chaos.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-person-check fs-4"></i>
                                <h5 class="mb-0">Profil & Personalisierung</h5>
                            </div>
                            <p class="text-muted mb-0">Profilbild hochladen, Daten bearbeiten und alles aktuell halten.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
    <?php include INCLUDES_PATH . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>