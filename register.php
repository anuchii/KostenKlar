<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $errors = [];

    if (empty($_POST["firstname"])) {
        $errors[] = "Bitte geben Sie Ihren Vornamen ein.";
    }

    if (empty($_POST["lastname"])) {
        $errors[] = "Bitte geben Sie Ihren Nachnamen ein.";
    }

    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Bitte geben Sie eine gültige E-Mail-Adresse ein.";
    }

    if (empty($_POST["gebdatum"])) {
        $errors[] = "Bitte geben Sie Ihr Geburtsdatum ein.";
    } else {
        $birthdate = new DateTime($_POST["gebdatum"]);
        $today = new DateTime();
        $age = $today->diff($birthdate)->y;
        if ($age < 16) {
            $errors[] = "Sie müssen mindestens 16 Jahre alt sein.";
        }
    }

    if (empty($_POST["geschlecht"])) {
        $errors[] = "Bitte wählen Sie ein Geschlecht aus.";
    }

    if (!isset($_POST["terms-and-conditions"])) {
        $errors[] = "Sie müssen die AGB akzeptieren.";
    }

    if (empty($errors)) {
        /*Todo für 12.11.2025*/
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registrierung</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>


<body>
    <style>
        body {
            background-image: url('images/option1_hintergrund.jpg.avif');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            min-height: 100vh;
            color: #fff;
        }

        .register-card {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 1rem;
            padding: 2.5rem;
            max-width: 520px;
            margin: 60px auto;
            backdrop-filter: blur(6px);
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="register-card text-center">
            <h1>Registrierung</h1>
            <p>Bitte füllen Sie das Formular vollständig aus.</p>
            <form class="p-3 needs validation" method="post" novalidate> <!--action hinzufügen-->
                <div class="mb-3">


                    <label class="form-label" for="firstname"> Vorname: </label>
                    <input class="form-control <?php echo isset($errors['firstname']) ? 'is-invalid' : '' ?>"
                        type="text" id="firstname" placeholder="Vorname" name="firstname">


                    <label class="form-label" for="lastname"> Nachname: </label>
                    <input class="form-control" type="text" id="lastname" placeholder="Nachname" name="lastname" required>

                    <label class="form-label" for="gebdatum">Geburtsdatum</label>
                    <input class="form-control" id="gebdatum" type="date" min="1920-01-01" max="2009-11-02" name="gebdatum" required>
                    <!-- kann man programieren damit es sich automatisch ändert-->

                    <label class="form-label" for="email">E-Mail Adresse: </label>
                    <input class="form-control" type="email" id="email" placeholder="beispiel@email.com" name="email" required>

                    <label class="form-label" for="password">Passwort: </label>
                    <input class="form-control" type="password" id="password" pattern="[a-z0-9]{12,}" name="password" required>
                    <!-- wenn man passwort sehen möchte wird nur den type gewechselt-->


                </div>
                <label class="form-label d-block mt-2">Geschlecht</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="weiblich" name="geschlecht" type="radio">
                    <label class="form-check-label" for="weiblich">Weiblich</label>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="maenlich">Männlich</label>
                    <input class="form-check-input" id="maenlich" name="geschlecht" type="radio">
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="divers">Divers</label>
                    <input class="form-check-input" id="divers" name="geschlecht" type="radio">
                </div>
                <hr>
                <div>
                    <label for="profilbild">Laden Sie Ihr Profilbild hoch <input id="profilbild" type="file" name="profilbild"> </label><br>
                </div>
                <hr>


                <div>
                    <label class="form-label" for="referrer"> Wie haben Sie über uns gehört?
                        <select class="form-select" id="referrer" name="referrer">
                            <option selected>(Wählen Sie eine Option)</option>
                            <option value="1">FH</option>
                            <option value="2">Instagram</option>
                            <option value="3">Ana Florea</option>
                            <option value="4">other one</option>
                        </select>
                    </label><br>
                </div>


                <hr>
                <label class="form-check-label" for="terms-and-conditions"> <input id="terms-and-conditions" type="checkbox" name="terms-and-conditions" required>
                    Ich akzeptiere die <a href="https://www.freecodecamp.org/news/terms-of-service/">Allgemeinen Geschäftsbedingungen</a> </label><br>

                <input class="btn btn-warning" type="submit" value="Registrieren">

            </form>
        </div>
    </div>
</body>

</html>