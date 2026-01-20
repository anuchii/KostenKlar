
<form method="post" action="<?= $postAction ?>">

    <?php if(isset($user_id)): ?>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="first-name" class="col-form-label">Vorname</label>
        <input type="text"
            class="form-control<?php echo (!isset($validationErrors["first_name"]) ? "" : " is-invalid"); ?>"
            id="first-name" name="first_name"
            value="<?php echo htmlspecialchars($userData["first_name"] ?? '') ?>">
        <?php
        echo (!isset($validationErrors['first_name']) ? "" :
            '<div class="invalid-feedback">' . $validationErrors["first_name"] . '</div>');
        ?>
    </div>

    <div class="mb-3">
        <label for="last-name" class="col-form-label">Vorname</label>
        <input type="text"
            class="form-control<?php echo (!isset($validationErrors["last_name"]) ? "" : " is-invalid"); ?>"
            id="first-name" name="last_name"
            value="<?php echo htmlspecialchars($userData["last_name"] ?? '') ?>">
        <?php
        echo (!isset($validationErrors["last_name"]) ? "" :
            '<div class="invalid-feedback">' . $validationErrors["last_name"] . '</div>');
        ?>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status"
                id="expense" value="active" <?= $userData['status'] === 'active'? 'checked' : '' ?>>
            <label class="form-check-label" for="active">aktiv</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status"
                id="inactive" value="inactive" <?= $userData['status'] === 'inactive'? 'checked' : '' ?>>
            <label class="form-check-label" for="inactive">inaktiv</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary m-2">Speichern</button>
    <a href="<?= page_url('user_management') ?>" class="btn btn-secondary">Schließen</a>

</form>