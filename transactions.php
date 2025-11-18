<?php

    require_once __DIR__ . '/db_config.php';

    function getTransactionsByUserIDAndMonth($user_id, $year, $month, $pdo) {
        // Prepare SQL statement
        $statement = $pdo->prepare(
            "SELECT t.*, c.* FROM transactions t
            LEFT JOIN categories c ON c.category_id = t.transaction_category_id
            WHERE user_id = :user_id 
                AND YEAR(transaction_date) = :year 
                AND MONTH(transaction_date) = :month"
        );

        // Bind values
        $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $statement->bindValue(":year", $year, PDO::PARAM_INT);
        $statement->bindValue(":month", $month, PDO::PARAM_INT);
        $statement->execute();

        // Fetch database entries
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    function getSumByUserIDAndMonth($user_id, $year, $month, $transaction_type, $pdo) {
        // Prepare SQL statement
        $statement = $pdo->prepare(
            "SELECT SUM(transaction_amount) AS sum FROM transactions
            WHERE user_id = :user_id
                AND transaction_type = :transaction_type
                AND YEAR(transaction_date) = :year 
                AND MONTH(transaction_date) = :month"
        );

        // Bind values
        $statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $statement->bindValue(":year", $year, PDO::PARAM_INT);
        $statement->bindValue(":month", $month, PDO::PARAM_INT);
        $statement->bindValue(":transaction_type", $transaction_type);
        $statement->execute();

        // Fetch database entries
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function getTransactionCategories($pdo) {
         // Prepare SQL statement
        $statement = $pdo->prepare(
            "SELECT * FROM categories"
        );

        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    function createTransaction($transactionData, $user_id, $pdo) {

    // Prepare SQL statement
        $statement = $pdo->prepare(
            "INSERT INTO transactions (transaction_date, transaction_title, transaction_amount, transaction_note, transaction_category_id, transaction_type, user_id)
            VALUES (:transaction_date, :transaction_title, :transaction_amount, :transaction_note, :transaction_category_id, :transaction_type, :user_id)"
        );

        // Bind values
        $statement->bindValue(":transaction_date", $transactionData["transaction_date"]);
        $statement->bindValue(":transaction_title", $transactionData["transaction_title"]);
        $statement->bindValue(":transaction_amount", $transactionData["transaction_amount"]);
        $statement->bindValue(":transaction_note", $transactionData["transaction_note"]);
        $statement->bindValue(":transaction_category_id", $transactionData["transaction_category"]);
        $statement->bindValue(":transaction_type", $transactionData["transaction_type"]);
        $statement->bindValue(":user_id", $user_id);

        // Execute statement
        $success = $statement->execute();

        return $success;
    }