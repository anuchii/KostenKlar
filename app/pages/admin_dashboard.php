<?php include INCLUDES_PATH . '/head.php'; ?>

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