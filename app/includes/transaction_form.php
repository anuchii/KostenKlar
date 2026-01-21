<form method="post" action="<?= $postAction ?>">
    <input type="hidden" name="transaction_id"
        value="<?= htmlspecialchars((string) ($old['transaction_id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
    <div class="mb-3">
        <label for="transaction-date" class="col-form-label">Datum</label>
        <input type="date"
            class="form-control <?= field_invalid_class($validationErrors, 'transaction_date') ?>"
            id="transaction-date" 
            name="transaction_date"
            value="<?= htmlspecialchars((string) ($old['transaction_date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <?= field_error($validationErrors, 'transaction_date') ?>
    </div>
    <div class="mb-3">
        <label for="transaction-title" class="col-form-label">Bezeichnung</label>
        <input type="text"
            class="form-control <?= field_invalid_class($validationErrors, 'transaction_title') ?>"
            id="transaction-title" 
            name="transaction_title" 
            value="<?= htmlspecialchars((string) ($old['transaction_title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <?= field_error($validationErrors, 'transaction_title') ?>
    </div>
    <div class="mb-3">
        <label for="transaction-amount" class="col-form-label">Betrag</label>
        <input type="text"
            class="form-control <?= field_invalid_class($validationErrors, 'transaction_amount') ?>"
            id="transaction-amount" 
            name="transaction_amount" 
            placeholder="0.00" 
            value="<?= htmlspecialchars((string) ($old['transaction_amount'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <?= field_error($validationErrors, 'transaction_amount') ?>
    </div>
    <div class="mb-3">
        <label for="transaction-note" class="col-form-label">Notiz</label>
        <textarea class="form-control" id="transaction-note" name="transaction_note"
            rows="3"><?= htmlspecialchars((string) ($old['transaction_note'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>
    <div class="mb-3">
        <div class="form-group">
            <label for="category" class="col-form-label">Kategorie</label>
            <select 
                class="form-select" 
                id="category"
                name="transaction_category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category["category_id"] ?>"
                        <?= (isset($old["transaction_category_id"]) && ($old["transaction_category_id"] == $category["category_id"])) ? 'selected' : '' ?>>
                        <?= htmlspecialchars((string) $category["category_name"], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Buchungstyp</label>
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="radio" 
                name="transaction_type"
                id="expense" 
                value="expense" 
                <?= (((isset($old['transaction_type']) && $old['transaction_type'] === 'expense')) || (!isset($old['transaction_type']))) ? 'checked' : '' ?>>
            <label class="form-check-label" for="expense">Ausgabe</label>
        </div>
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="radio" 
                name="transaction_type"
                id="revenue" 
                value="revenue"
                <?= (isset($old['transaction_type']) && $old['transaction_type'] === 'revenue') ? 'checked' : '' ?>>
            <label class="form-check-label" for="revenue">Einnahme</label>
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">Speichern</button>
        <a href="<?= page_url('user_dashboard') ?>" class="btn btn-outline-secondary">Abbrechen</a>
    </div>
</form>