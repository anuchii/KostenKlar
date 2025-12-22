<?php

function validateRegistrationData($registrationData)
{
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $first_name = trim($_POST["first_name"] ?? '');
        if ($first_name === '') {
            $errors["first_name"] = "Bitte geben Sie Ihren Vornamen ein.";
        }
        $last_name = trim($_POST["last_name"] ?? '');
        if ($last_name === '') {
            $errors["last_name"] = "Bitte geben Sie Ihren Nachnamen ein.";
        }
        $email = trim($_POST["email"] ?? '');
        if ($email === '' || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Bitte geben Sie eine gültige E-Mail-Adresse ein.";
        }
        //TODO: try-catch block um Exception zu fangen bei falscheingabe.
       
        if (empty($_POST["gebdatum"])) {
            $errors["gebdatum"] = "Bitte geben Sie Ihr Geburtsdatum ein.";
        } else {
            $gebdatum = new DateTime($_POST["gebdatum"]);
            $heute = new DateTime();
            $alter = $heute->diff($gebdatum)->y;
            if ($alter < 16) {
                $errors["gebdatum"] = "Sie müssen mindestens 16 Jahre alt sein.";
            }
        }
            

        if (empty($_POST["password"])) {
            $errors["password"] = "Passwort kann nicht leer sein.";
        } else if (strlen($_POST["password"]) < 12) {
            $errors["password"] = "Das Passwort muss mindestens 12 Zeichen lang sein.";
        }


        if (empty($_POST["password-confirmation"])) {
            $errors["password-confirmation"] = "Bitte bestätigen Sie Ihr Passwort";
        }
        if (!empty($_POST["password"]) && !empty($_POST["password-confirmation"])) {
            if ($_POST["password"] !== $_POST["password-confirmation"]) {
                $errors["password"] =  "Die Passwörter stimmen nicht überein!";
                $errors["password-confirmation"] = "Die Passwörter stimmen nicht überein!";
            }
        }
      
        if (empty($_POST["geschlecht"])) {
            $errors["geschlecht"] = "Bitte wählen Sie ein Geschlecht aus.";
        }
            

        if (!isset($_POST["terms-and-conditions"])) {
            $errors["terms-and-conditions"] = "Sie müssen die AGB akzeptieren.";
        }

        if (empty($errors)) {

            //Felder zurücksetzen
            $_POST = [];

            // Erfolgsnachricht setzen--> vlt brauchen wir nicht wenn wir direkt zum login oder zum dashboard geschickt werden. 
            $erfolgsmeldung = "Registrierung erfolgreich!";
        }
        return $errors;
    }
}
