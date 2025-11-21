<?php
session_start();

if (!empty($_SESSION['user_data'])) {
    $userData = $_SESSION['user_data'];
} else {
    header("Location: login_page.php");
    exit();
}


//falls noch keines hochgeladen wurde: standard-Profilbild setzen
$profileImage = isset($_SESSION['profileImage'])
    ? $_SESSION['profileImage']
    : 'https://cdn-icons-png.flaticon.com/512/847/847969.png';
//TODO: Profilbild hinzufügen backend programmieren. (Präsenz9-Code anschauen)
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KostenKlar–Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="images/logo.png">

</head>

<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh">


            <?php include 'sidebar.php'; ?>

            <!--HauptInhalt -->
            <div class="col-12 col-lg-10 p-0">

                <!-- Abmelden-Bar -->
                <?php include 'header.php'; ?>
                <!-- Header -->
                <header class="py-4 border-bottom p-3">
                    <h2>Mein Profil</h2>
                    <p class="text-muted mb-0">Persönliche Informationen</p>
                </header>

                <!-- Profil-Inhalt -->
                <div class="container py-4">
                    <div class="row">
                        <!-- Profil-Kästchen  -->
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <!-- TODO: Profilbild upload -->
                                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profilbild"
                                        class="rounded-circle mb-3" width="120" height="120">
                                    <h5 class="card-title mb-0">
                                        <?php echo htmlspecialchars($userData['first_name'] . ' ' . $userData['last_name']); ?>
                                    </h5>

                                    <p class="text-muted"></p>
                                    <button class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Profilbild bearbeiten
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Details-Kästchen -->
                        <!--TODO: padding einfügen wenn Bildschrim sehr klein,
                          damit allgemeine infos nicht mit Profil-Kästchen pickt-->
                        <div class="col-md-8">
                            <div class="card shadow-sm mb-4">

                                <div class="card-header bg-light">
                                    <strong>Allgemeine Informationen</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">Vorname:</div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($userData['first_name']); ?>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">Nachname:</div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($userData['last_name']); ?>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">Geburtsdatum:</div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($userData['gebdatum'] ) ?>
                                        </div>
                                    </div>
                                    <!--TODO: Männlich mit ä statt ae?-->
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">Geschlecht:</div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars(ucfirst($userData['geschlecht'])); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Kontakt-Kästchen-->
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <strong>Kontakt</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4 fw-bold">E-Mail:</div>
                                        <div class="col-sm-8">
                                            <?php echo htmlspecialchars($userData['email']); ?>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <!-- Password gehört nicht beim Kontakt-Kästchen-->

                                        <!-- <div class="col-sm-4 fw-bold">Passwort:</div>
                                        <div class="col-sm-8">zubearbeiten</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Optionaler Abschnitt -->
                    <div class="row mt-4">
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <strong>Zusätzliche Informationen</strong>
                                </div>
                                <div class="card-body">
                                    <p>ToDo........</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /container -->
            </div><!-- /col-10 -->
        </div><!-- /row -->
    </div><!-- /container-fluid -->
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>