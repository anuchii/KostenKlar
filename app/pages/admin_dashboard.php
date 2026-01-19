<?php include INCLUDES_PATH . '/head.php'; ?>

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
                            <p class="text-muted mb-0">Willkomen zurück, <?php echo ("{$userData['first_name']} {$userData['last_name']}"); ?></p>
                        </div>
                    </div>
                </header>

                <!-- Profilinhalt -->
                <div class="container py-4">
                    <div class="row g-3 mb-3">

                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Aktive Benutzer</div>
                                            <div class="fw-bold fs-5 text-success">
                                                <?php echo ($userCount); ?>
                                            </div>
                                        </div>
                                        <i class="bi bi-people text-success fs-3" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Inaktive Benutzer</div>
                                            <div class="fw-bold fs-5">
                                                <?php echo ($inactiveUserCount); ?>
                                            </div>
                                        </div>
                                        <i class="bi bi-person-slash fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Erfasste Transaktionen</div>
                                            <div class="fw-bold fs-5 text-danger">
                                                <?php echo ($transactionCount); ?>
                                            </div>
                                        </div>
                                        <i class="bi bi-receipt-cutoff text-danger fs-3"></i>
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