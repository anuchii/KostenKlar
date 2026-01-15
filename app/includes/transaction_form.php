<?php 

// app/includes/transaction_form.php
//
// This template requires: 
// 
// $transactionData[$transaction_date, $transaction_title, $transaction_amount, $transaction_note, $category_id, $transaction_type]                          ], 
// $validationErrors["transaction_date", "transaction_title", "transaction_amount"],
// $categories["category_id", "category_name"],
// $transaction_id (optional)
// $pageName

?>

<form method="post" action="<?= page_url($pageName) ?>">

    <?php if(isset($transaction_id)): ?>
        <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="transaction-date" class="col-form-label">Datum</label>
        <input type="date"
            class="form-control<?php echo (!isset($validationErrors["transaction_date"]) ? "" : " is-invalid"); ?>"
            id="transaction-date" name="transaction_date"
            value="<?php echo htmlspecialchars($transactionData['transaction_date'] ?? '') ?>">
        <?php
        echo (!isset($validationErrors["transaction_date"]) ? "" :
            '<div class="invalid-feedback">' . $validationErrors["transaction_date"] . '</div>');
        ?>
    </div>
    
    <div class="mb-3">
        <label for="transaction-title" class="col-form-label">Bezeichnung</label>
        <input type="text"
            class="form-control<?php echo (!isset($validationErrors["transaction_title"]) ? "" : " is-invalid"); ?>"
            id="transaction-title" name="transaction_title" 
            value="<?php echo htmlspecialchars($transactionData['transaction_title'] ?? '') ?>">
        <?php
        echo (!isset($validationErrors["transaction_title"]) ? "" :
            '<div class="invalid-feedback">' . $validationErrors["transaction_title"] . '</div>');
        ?>
    </div>
    
    <div class="mb-3">
        <label for="transaction-amount" class="col-form-label">Betrag</label>
        <input type="text" pattern="\d+,\d{2}"
            class="form-control<?php echo (!isset($validationErrors["transaction_amount"]) ? "" : " is-invalid"); ?>" id="
            transaction-amount" name="transaction_amount" placeholder="0,00"
            value="<?php echo ($transactionData["transaction_amount"] ?? ""); ?>">
        <?php
        echo (!isset($validationErrors["transaction_amount"]) ? "" :
            '<div class="invalid-feedback">' . $validationErrors["transaction_amount"] . '</div>');
        ?>
    </div>
    
    <div class="mb-3">
        <label for="transaction-note" class="col-form-label">Notiz</label>
        <textarea class="form-control" id="transaction-note"
            name="transaction_note"><?php echo htmlspecialchars($transactionData['transaction_note'] ?? '') ?></textarea>
    </div>
    
    <div class="mb-3">
        <div class="form-group">
            <label for="category" class="col-form-label">Kategorie</label>
            <select class="form-select" id="category" name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option 
                    value="<?php echo (($category["category_id"])); ?>" 
                    <?php echo ($transactionData["category_id"] == $category["category_id"] ? 'selected' : ''); ?>
                    >
                        <?php echo ($category["category_name"]); ?>
                    </option>
                        
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Buchungstyp</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="transaction_type"
                id="expense" value="expense" <?= $transactionData['transaction_type'] === 'expense'? 'checked' : '' ?>>
            <label class="form-check-label" for="expense">Ausgabe</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="transaction_type"
                id="revenue" value="revenue" <?= $transactionData['transaction_type'] === 'revenue'? 'checked' : '' ?>>
            <label class="form-check-label" for="revenue">Einnahme</label>
        </div>
    </div>

    <button type="submit" class="btn btn-warning m-2">Speichern</button>
    <a href="<?= page_url('user_dashboard') ?>" class="btn btn-secondary">Schließen</a>

</form>