<?php include INCLUDES_PATH . '/head.php'; ?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Dashboard Header -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Übersicht</h1>
                            <p class="text-muted mb-0">Willkommen zurück, <?php echo ("{$userData['first_name']} {$userData['last_name']}"); ?>.</p>
                        </div>
                        <form method="get" action="<?= BASE_URL . '/dashboard' ?>" class="d-flex align-items-end gap-2">
                            <div>
                                <label class="form-label small text-muted mb-1">Abrechnungsmonat</label>
                                <div class="d-flex gap-2">
                                    <select name="year" class="form-select flex-grow-1" style="min-width: 110px;">
                                        <?php
                                        $currentYear = (int)date('Y');
                                        for ($y = $currentYear - 5; $y <= $currentYear; $y++) {
                                            $selected = ($y === $year) ? 'selected' : '';
                                            echo "<option value=\"$y\" $selected>$y</option>";
                                        }
                                        ?>
                                    </select>

                                    <select name="month" class="form-select flex-grow-1">
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $value = sprintf('%02d', $m);
                                            $selected = ($m === $month) ? 'selected' : '';
                                            echo "<option value=\"$value\" $selected>$value</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-nowrap" style="height: 38px;">Anzeigen</button>
                        </form>
                    </div>
                </header>

                <!-- Profilinhalt -->
                <div class="container py-4">
                    <!-- KPI Cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Einnahmen</div>
                                            <div class="fw-bold fs-5 text-success">€ <?php echo (number_format($revenueSum, 2, ',', '')); ?></div>
                                        </div>
                                        <i class="bi bi-arrow-down-left-circle text-success fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Ausgaben</div>
                                            <div class="fw-bold fs-5 text-danger">€ <?php echo (number_format($expenseSum, 2, ',', '')); ?></div>
                                        </div>
                                        <i class="bi bi-arrow-up-right-circle text-danger fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Saldo</div>
                                            <div class="fw-bold fs-5">€ <?php echo (number_format($balance, 2, ',', '')); ?></div>
                                        </div>
                                        <i class="bi bi-wallet2 fs-3 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm rounded-3 mb-4">
                                <div class="card-header bg-white">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <strong>Buchungen</strong>
                                        <a href="<?= BASE_URL . '/transaction/new' ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>Neue Buchung
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Datum</th>
                                                <th scope="col">Bezeichnung</th>
                                                <th scope="col">Betrag</th>
                                                <th scope="col" class="d-none d-md-table-cell">Kategorie</th>
                                                <th scope="col" class="d-none d-lg-table-cell">Notiz</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($transactions as $transaction): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo (date("d.m.Y", strtotime($transaction["transaction_date"])) ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($transaction["transaction_title"] ?? ""); ?>
                                                    </td>
                                                    <td class="<?php echo ($transaction["transaction_type"] === "expense" ? "text-danger" : "text-success"); ?> fw-semibold">
                                                        <?php echo ($transaction["transaction_type"] === "expense" ? "-" : ""); ?>
                                                        <?php echo (number_format($transaction["transaction_amount"], 2, ',', '') ?? ""); ?>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        <?php echo ($transaction["category_name"] ?? ""); ?>
                                                    </td>
                                                    <td class="d-none d-lg-table-cell">
                                                        <?php echo ($transaction["transaction_note"] ?? ""); ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-outline-primary btn-sm text-center" href="<?= BASE_URL . '/transaction/show?id=' . $transaction["transaction_id"] ?>">Details</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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