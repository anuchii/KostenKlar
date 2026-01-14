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
    $validationErrors = [];

    // Check email input
    if (empty($userData["email"])) {
        $validationErrors["email"] = "Bitte geben Sie Ihre E-Mail-Adresse ein.";
    }

    // Check password input
    if (empty($userData["password"])) {
        $validationErrors["password"] = "Bitte geben Sie Ihr Passwort ein.";
    }

    return $validationErrors;
}
