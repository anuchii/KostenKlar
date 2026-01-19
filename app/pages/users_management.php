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