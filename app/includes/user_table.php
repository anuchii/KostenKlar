
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Vorname</th>
            <th scope="col">Nachname</th>
            <th scope="col" class="d-none d-md-table-cell">E-Mail</th>
            <th scope="col" class="d-none d-lg-table-cell">Geschlecht</th>
            <th scope="col" class="d-none d-lg-table-cell">Geburtsdatum</th>
            <th scope="col" class="d-none d-lg-table-cell">Rolle</th>
            <th scope="col" class="d-none d-lg-table-cell">Status</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <?php echo ($user["user_id"] ?? ""); ?>
                </td>
                <td>
                    <?php echo ($user["first_name"] ?? ""); ?>
                </td>
                <td>
                    <?php echo ($user["last_name"] ?? ""); ?>
                </td>
                <td class="d-none d-md-table-cell">
                    <?php echo ($user["email"] ?? ""); ?>
                </td>
                <td class="d-none d-lg-table-cell">
                    <?php echo ($user["geschlecht"] ?? ""); ?>
                </td>
                <td class="d-none d-lg-table-cell">
                    <?php echo (isset($user["gebdatum"]) ? date("d.m.Y", strtotime($user["gebdatum"])) : ""); ?>
                </td>
                <td class="d-none d-lg-table-cell">
                    <?php echo ($user["role"] ?? ""); ?>
                </td>
                <td class="d-none d-lg-table-cell">
                    <?php echo ($user["status"] ?? ""); ?>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm text-center" href="<?= BASE_URL . '/admin/user?id=' . $user['user_id'] ?>">Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>