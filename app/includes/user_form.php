
<form method="post" action="<?= BASE_URL . '/admin/user/edit' ?>">

    <input type="hidden" name="user_id" value="<?= $old['user_id'] ?>">

    <div class="mb-3">
        <label for="first-name" class="col-form-label">Vorname</label>
        <input type="text"
            class="form-control<?php echo (!isset($errors["first_name"]) ? "" : " is-invalid"); ?>"
            id="first-name" name="first_name"
            value="<?php echo htmlspecialchars($old["first_name"] ?? '') ?>">
        <?php
        echo (!isset($errors['first_name']) ? "" :
            '<div class="invalid-feedback">' . $errors["first_name"] . '</div>');
        ?>
    </div>

    <div class="mb-3">
        <label for="last-name" class="col-form-label">Vorname</label>
        <input type="text"
            class="form-control<?php echo (!isset($errors["last_name"]) ? "" : " is-invalid"); ?>"
            id="first-name" name="last_name"
            value="<?php echo htmlspecialchars($old["last_name"] ?? '') ?>">
        <?php
        echo (!isset($errors["last_name"]) ? "" :
            '<div class="invalid-feedback">' . $errors["last_name"] . '</div>');
        ?>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status"
                id="expense" value="active" <?= $old['status'] === 'active'? 'checked' : '' ?>>
            <label class="form-check-label" for="active">aktiv</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status"
                id="inactive" value="inactive" <?= $old['status'] === 'inactive'? 'checked' : '' ?>>
            <label class="form-check-label" for="inactive">inaktiv</label>
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-primary">Speichern</button>
        <a href="<?= BASE_URL . '/admin/user?id=' . $old['user_id'] ?>" class="btn btn-secondary">Schließen</a>
    </div>

</form>