<?php
require_once __DIR__ . '/../config/db_config.php';


function getTransactionsByUserIDAndMonth($user_id, $year, $month, $pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT t.*, c.* FROM transactions t
            LEFT JOIN categories c ON c.category_id = t.transaction_category_id
            WHERE user_id = :user_id 
                AND YEAR(transaction_date) = :year 
                AND MONTH(transaction_date) = :month
            ORDER BY transaction_date DESC"
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

function getSumByUserIDAndMonth($user_id, $year, $month, $transaction_type, $pdo)
{
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

function getTransactionByID($transaction_id, $pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT t.*, c.* FROM transactions t
            LEFT JOIN categories c ON c.category_id = t.transaction_category_id
            WHERE transaction_id = :transaction_id"
    );

    // Bind values
    $statement->bindValue(":transaction_id", $transaction_id, PDO::PARAM_INT);
    $statement->execute();

    // Fetch database entries
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function getTransactionCategories($pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT * FROM categories"
    );

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}


function createTransaction($transactionData, $user_id, $pdo)
{

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
    $statement->bindValue(":transaction_category_id", $transactionData["transaction_category_id"]);
    $statement->bindValue(":transaction_type", $transactionData["transaction_type"]);
    $statement->bindValue(":user_id", $user_id);

    // Execute statement
    $success = $statement->execute();

    return $success;
}

function deleteTransaction($transaction_id, $pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "DELETE FROM transactions WHERE transaction_id = :transaction_id"
    );

    // Bind values
    $statement->bindValue(":transaction_id", $transaction_id, PDO::PARAM_INT);

    // Execute statement
    $success = $statement->execute();

    return $success;
}

function updateTransaction($transactionData, $pdo)
{

    // Prepare SQL statement
    $statement = $pdo->prepare(
        "UPDATE transactions 
            SET transaction_date = :transaction_date, 
                transaction_title = :transaction_title, 
                transaction_amount = :transaction_amount, 
                transaction_note = :transaction_note, 
                transaction_category_id = :transaction_category_id, 
                transaction_type = :transaction_type
            WHERE transaction_id = :transaction_id"
    );

    // Bind values
    $statement->bindValue(":transaction_id", $transactionData["transaction_id"], PDO::PARAM_INT);
    $statement->bindValue(":transaction_date", $transactionData["transaction_date"]);
    $statement->bindValue(":transaction_title", $transactionData["transaction_title"]);
    $statement->bindValue(":transaction_amount", $transactionData["transaction_amount"]);
    $statement->bindValue(":transaction_note", $transactionData["transaction_note"]);
    $statement->bindValue(":transaction_category_id", $transactionData["transaction_category_id"]);
    $statement->bindValue(":transaction_type", $transactionData["transaction_type"]);

    // Execute statement
    $success = $statement->execute();

    return $success;
}

/**
 * getMonthlySumByUserIdAndYear: Die Funktion holt monatliche Einnahmen und Ausgaben aus der Datenbank und ergänzt fehlende Monate in PHP
 * @param mixed $user_id id des angemeldeten Users
 * @param int $year das ausgewählte Jahr 
 * @param mixed $pdo PDO-Datenbankverbindung
 *
 * @return array<int, array{
 *   year:int,
 *   month:int,
 *   revenue_sum:float,
 *   expense_sum:float,
 *   saldo:float
 * }>
 */
function getMonthlySumByUserIdAndYear($user_id, int $year, $pdo)
{
    $statement = $pdo->prepare(
        "SELECT 
              MONTH(transaction_date) AS month,
              SUM(CASE WHEN transaction_type = 'revenue' THEN transaction_amount ELSE 0 END) AS revenue_sum,
              SUM(CASE WHEN transaction_type = 'expense' THEN transaction_amount ELSE 0 End) As expense_sum
              FROM transactions
              WHERE user_id = :user_id
              AND YEAR(transaction_date) = :year
              GROUP BY MONTH(transaction_date)
              ORDER BY MONTH(transaction_date)
         "
    );

    $statement->bindValue(":user_id", $user_id);
    $statement->bindValue(":year", $year);

    $statement->execute();

    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    $result = [];
    //leeres Array vorbereitet, um auch Monate ohne Daten zu haben 
    for ($m = 1; $m <= 12; $m++) {
        $result[$m] = [
            'year' => $year,
            'month' => $m,
            'revenue_sum' => 0.0,
            'expense_sum' => 0.0,
            'saldo' => 0.0,
        ];
    }
    // Result wird hier befüllt
    foreach ($rows as $row) {
        $m = (int) $row['month'];
        $revenue = isset($row['revenue_sum']) ? (float) $row['revenue_sum'] : 0.0;
        $expense = isset($row['expense_sum']) ? (float) $row['expense_sum'] : 0.0;

        if ($m >= 1 && $m <= 12) {
            $result[$m]['revenue_sum'] = $revenue;
            $result[$m]['expense_sum'] = $expense;
            $result[$m]['saldo'] = $revenue - $expense;
        }
    }
    return $result;
}


function getPieChartData(int $selectedYear, int $user_id, $pdo)
{
    $statement = $pdo->prepare(
        "SELECT 
            c.category_name AS kategorie,
            SUM(t.transaction_amount) AS gesamtbetrag
         FROM transactions t
         JOIN categories c 
            ON c.category_id = t.transaction_category_id
         WHERE t.user_id = :user_id
           AND YEAR(t.transaction_date) = :year
           AND  t.transaction_type = 'expense'
         GROUP BY c.category_name
         ORDER BY gesamtbetrag DESC"
    );

    $statement->bindValue(':year', $selectedYear);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $pieData = [
        'category' => [],
        'totalExpenses' => []
    ];
    foreach ($results as $row) {
        $pieData['category'][] = $row['kategorie'];
        $pieData['totalExpenses'][] = (float) $row['gesamtbetrag'];
    }
    return $pieData;
}

function getTransactionCount($pdo)
{
    // Prepare SQL statement
    $statement = $pdo->prepare(
        "SELECT COUNT(*) FROM transactions"
    );

    $statement->execute();

    // Fetch database entries
    $result = $statement->fetchColumn();

    return $result;
}
