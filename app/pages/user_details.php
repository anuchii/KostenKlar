<?php include INCLUDES_PATH . '/head.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">

            <!-- Sidebar -->
            <?php include INCLUDES_PATH . '/sidebar_admin.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <?php include INCLUDES_PATH . '/header.php'; ?>

                <!-- Header -->
                <header class="py-4 border-bottom p-3">
                    <h2>Benutzerdetails</h2>
                </header>

                <!-- Profilinhalt -->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow-sm my-4">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">ID</th>
                                                <td>
                                                    <?php echo ($user["user_id"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Vorname</th>
                                                <td>
                                                    <?php echo ($user["first_name"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Nachname</th>
                                                <td>
                                                    <?php echo ($user["last_name"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-Mail</th>
                                                <td>
                                                    <?php echo ($user["email"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Geschlecht</th>
                                                <td>
                                                    <?php echo ($user["geschlecht"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Geburtsdatum</th>
                                                <td>
                                                    <?php echo (isset($user["gebdatum"]) ? date("d.m.Y", strtotime($user["gebdatum"])) : ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Rolle</th>
                                                <td>
                                                    <?php echo ($user["role"] ?? ""); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td>
                                                    <?php echo ($user["status"] ?? ""); ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="mb-3 me-3 d-inline">
                                        <a href="<?= BASE_URL . '/admin/user/edit?id=' . $user['user_id'] ?>" type="button"
                                            class="btn btn-primary text-nowrap">
                                            <i class="bi bi-pencil text-black" aria-hidden="true"></i>
                                            Bearbeiten
                                        </a>
                                    </div>


                                    <div class="mb-3 me-3 d-inline">
                                        <form action="<?= BASE_URL . '/admin/user/delete' ?>" method="post" class="d-inline" onsubmit="return confirm('Eintrag wirklich löschen?');">
                                            <input type="hidden" name="user_id" value="<?= (int) $user["user_id"] ?>">
                                            <button type="submit" class="btn btn-primary text-nowrap" aria-hidden="true">
                                                <i class="bi bi-trash text-black"></i>
                                                Löschen
                                            </button>
                                        </form>
                                    </div>
                                    <div class="mb-3 me-3 d-inline">
                                        <form action="<?= BASE_URL . '/admin/user/change-status' ?>" method="post" class="d-inline"
                                            onsubmit="return confirm('Benutzerstatus wirklich ändern?');">
                                            <input type="hidden" name="user_id" value="<?= (int) $user["user_id"] ?>">
                                            <button type="submit" class="btn btn-primary text-nowrap">
                                                <i class="bi bi-person-x text-black" aria-hidden="true"></i>
                                                Aktivierungsstatus ändern
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