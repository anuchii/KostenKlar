<?php

// Validates transaction data
function validateTransactionData($transactionData) {
    $validationErrors = [];

    // Check date input
    if(empty($transactionData["transaction_date"])) {
        $validationErrors["transaction_date"] = "Datum darf nicht leer sein.";
    }

    // TODO: Check for valid date

    // Check title input
    if(empty($transactionData["transaction_title"])) {
        $validationErrors["transaction_title"] = "Bezeichnung darf nicht leer sein.";
    }
  
    // Check amount input
    if(empty($transactionData["transaction_amount"])) {
        $validationErrors["transaction_amount"] = "Betrag darf nicht leer sein.";
    } else {
        $amount = str_replace(',', '.', $transactionData["transaction_amount"]);
        if(!is_numeric($amount)) {
            $validationErrors["transaction_amount"] = "Ungültiger Betrag.";
        } else {
            $amount = floatval($amount);

            if($amount < 0.0) {
                $validationErrors["transaction_amount"] = "Betrag muss positiv sein.";
            }
        }
    }
    
    return $validationErrors;
}