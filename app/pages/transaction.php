<?php include INCLUDES_PATH . '/head.php'; ?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <!-- Sidebar -->
            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Header -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Buchungsdetails</h1>
                            <p class="text-muted mb-0">Details zur ausgewählten Buchung.</p>
                        </div>
                        <a href="<?= BASE_URL . '/dashboard' ?>" class="btn btn-outline-secondary" style="height: 38px;">Zurück</a>
                    </div>
                </header>

                <!-- Profilinhalt -->
                <div class="container py-4">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-header bg-white">
                                    <strong>Details</strong>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Datum</th>
                                                <td>
                                                    <?php echo (date("d.m.Y", strtotime($transaction["transaction_date"])) ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Bezeichnung</th>
                                                <td>
                                                    <?php echo ($transaction["transaction_title"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Betrag</th>
                                                <td>
                                                    <span class="fw-semibold <?= ($transaction['transaction_type'] === 'expense') ? 'text-danger' : 'text-success' ?>">
                                                        <?php echo (number_format($transaction["transaction_amount"], 2, ',', '') ?? ""); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kategorie</th>
                                                <td>
                                                    <?php echo ($transaction["category_name"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Notiz</th>
                                                <td>
                                                    <?php echo ($transaction["transaction_note"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Typ</th>
                                                <td>
                                                    <span class="badge <?= ($transaction['transaction_type'] === 'revenue') ? 'bg-success' : 'bg-danger' ?>">
                                                        <?php echo ($transaction["transaction_type"] == 'revenue' ? "Einnahme" : "Ausgabe"); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="d-flex gap-2 p-3">
                                        <a href="<?= BASE_URL . '/transaction/edit?id=' . $transaction['transaction_id'] ?>"
                                            class="btn btn-primary">
                                            <i class="bi bi-pencil me-1"></i>Bearbeiten
                                        </a>

                                        <form action=""
                                            method="post" onsubmit="return confirm('Eintrag wirklich löschen?');">
                                            <input type="hidden" name="transaction_id" value="<?= (int) $transaction['transaction_id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash me-1"></i>Löschen
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