<?php

// Validates login data
function validateLoginData($userData) {
    $validationErrors = [];

    // Check email input
    if(empty($userData["email"])) {
        $validationErrors["email"] = "Please provide email adress.";
    }

    // Check password input
    if(empty($userData["password"])) {
        $validationErrors["password"] = "Please provide password.";
    }

    return $validationErrors;
}
