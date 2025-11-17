<?php

// Validates registration data
function validateRegistrationData($registrationData) {
    $validationErrors = [];

    // Check first name input
    if(empty($registrationData["first_name"])) {
        $validationErrors["first_name"] = "First name cannot be empty.";
    }

    // Check last name input
    if(empty($registrationData["last_name"])) {
        $validationErrors["last_name"] = "Last name cannot be empty.";
    }
  
    // Check email input
    if(empty($registrationData["email"])) {
        $validationErrors["email"] = "Email adress cannot be empty.";
    } else if (!filter_var($registrationData["email"], FILTER_VALIDATE_EMAIL)){
        $validationErrors["email"] = "Email adress invalid.";
    }

    // Check password input
    if(empty($registrationData["password"])) {
        $validationErrors["password"] = "Password cannot be empty.";
    }

    // Check password confirmation input
    if(empty($registrationData["password_confirmation"])) {
        $validationErrors["password_confirmation"] = "Password confirmation cannot be empty.";
    }
    
    if(!empty($registrationData["password"]) && !empty($registrationData["password_confirmation"])) {
        if($registrationData["password"] !== $registrationData["password_confirmation"]) {
            $validationErrors["password"] = "Passwords must match.";
            $validationErrors["password_confirmation"] = "Passwords must match.";
        }
    }
    
    return $validationErrors;
}
