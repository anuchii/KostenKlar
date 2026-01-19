<?php include INCLUDES_PATH . '/head.php'; ?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row min-vh-100">

            <?php include INCLUDES_PATH . '/sidebar.php'; ?>

            <div class="col-12 col-lg-10 p-0">
                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Page Header (Dashboard Style) -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Neue Buchung</h1>
                            <p class="text-muted mb-0">Erstelle eine neue Einnahme oder Ausgabe.</p>
                        </div>
                        <a href="<?= BASE_URL . '/dashboard' ?>" class="btn btn-outline-secondary" style="height: 38px;">Zurück</a>
                    </div>
                </header>

                <main>
                    <div class="container py-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                                <div class="card shadow-sm rounded-3">
                                    <div class="card-header bg-white">
                                        <strong>Buchungsdetails</strong>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="<?= BASE_URL . '/transaction/new' ?>">
                                            <div class="mb-3">
                                                <label for="transaction-date" class="col-form-label">Datum</label>
                                                <input type="date"
                                                    class="form-control<?php echo (!isset($errors["transaction_date"]) ? "" : " is-invalid"); ?>"
                                                    id="transaction-date" name="transaction_date"
                                                    value="<?= htmlspecialchars($old['transaction_date']) ?? $currentDate ?>">
                                                <?php
                                                echo (!isset($errors["transaction_date"]) ? "" :
                                                    '<div class="invalid-feedback">' . $errors["transaction_date"] . '</div>');
                                                ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction-title" class="col-form-label">Bezeichnung</label>
                                                <input type="text"
                                                    class="form-control<?php echo (!isset($errors["transaction_title"]) ? "" : " is-invalid"); ?>"
                                                    id="transaction-title" name="transaction_title", value="<?= htmlspecialchars($old["transaction_title"] ?? '') ?>">
                                                <?php
                                                echo (!isset($errors["transaction_title"]) ? "" :
                                                    '<div class="invalid-feedback">' . $errors["transaction_title"] . '</div>');
                                                ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction-amount" class="col-form-label">Betrag</label>
                                                <input type="text" pattern="\d+,\d{2}"
                                                    class="form-control<?php echo (!isset($errors["transaction_amount"]) ? "" : " is-invalid"); ?>"
                                                    id="transaction-amount" name="transaction_amount" placeholder="0,00", value="<?= htmlspecialchars($old["transaction_amount"] ?? '') ?>">
                                                <?php
                                                echo (!isset($errors["transaction_amount"]) ? "" :
                                                    '<div class="invalid-feedback">' . $errors["transaction_amount"] . '</div>');
                                                ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction-note" class="col-form-label">Notiz</label>
                                                <textarea class="form-control" id="transaction-note" name="transaction_note" rows="3"><?= $old['transaction_note'] ?? '' ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <label for="category" class="col-form-label">Kategorie</label>
                                                    <select class="form-select" id="category" name="transaction_category_id">
                                                        <?php foreach ($categories as $category): ?>
                                                            <option 
                                                                value="<?= $category["category_id"] ?>"
                                                                <?php echo ((isset($old["transaction_category_id"]) && ($old["transaction_category_id"] == $category["category_id"])) ? 'selected' : ''); ?>>
                                                                <?= $category["category_name"] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Buchungstyp</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="transaction_type"
                                                        id="expense" value="expense"<?= (((isset($old['transaction_type']) && $old['transaction_type'] === 'expense')) || (!isset($old['transaction_type']))) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="expense">Ausgabe</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="transaction_type"
                                                        id="revenue" value="revenue"<?= (isset($old['transaction_type']) && $old['transaction_type'] === 'revenue') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="revenue">Einnahme</label>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 mt-3">
                                                <button type="submit" class="btn btn-primary">Speichern</button>
                                                <a href="<?= BASE_URL . '/dashboard' ?>" class="btn btn-outline-secondary">Abbrechen</a>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
    </div>
    <?php include INCLUDES_PATH . '/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>