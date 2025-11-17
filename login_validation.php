<?php

// Validates login data
function validateLoginData($userData)
{
    $validationErrors = [];

    // Check email input
    if (empty($userData["email"])) {
        $validationErrors["email"] = "Bitte geben Sie eine E-Mail-Adresse ein.";
    }

    // Check password input
    if (empty($userData["password"])) {
        $validationErrors["password"] = "Bitte geben Sie eine E-Mail-Adresse ein.";
    }

    return $validationErrors;
}
