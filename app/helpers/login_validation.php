<?php

/**
 * Validiert die Eingaben des Login-Formulars.
 *
 * Prüft, ob E-Mail-Adresse und Passwort vorhanden sind,
 * und gibt bei fehlenden Angaben entsprechende Fehlermeldungen zurück.
 *
 * @param array $userData Die vom Login-Formular übermittelten Daten.
 * @return array Ein assoziatives Array mit Validierungsfehlern (leer, wenn keine Fehler vorliegen).
 */
function validateLoginData($userData)
{
    $errors = [];

    // Check email input
    if (empty($userData["email"])) {
        $errors["email"] = "Bitte geben Sie Ihre E-Mail-Adresse ein.";
    }

    // Check password input
    if (empty($userData["password"])) {
        $errors["password"] = "Bitte geben Sie Ihr Passwort ein.";
    }

    return $errors;
}
