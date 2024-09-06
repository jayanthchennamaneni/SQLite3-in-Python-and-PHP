<?php

// creating a connection to database
$db = new SQLite3('chelsea-php.db');

// creating a table
$db->exec('CREATE TABLE IF NOT EXISTS players (id INTEGER PRIMARY KEY, name TEXT UNIQUE, priceinmill INT)');

// inserting a row
$stmt = $db->prepare('INSERT INTO players (name, priceinmill) VALUES (:name, :priceinmill)');
$stmt->bindValue(':name', 'Kante', SQLITE3_TEXT);
$stmt->bindValue(':priceinmill', 1000, SQLITE3_INTEGER);
$stmt->execute();

// inserting multiple rows
$players1 = [['jackson', 700],['caicedo', 800]];

$stmt = $db->prepare('INSERT INTO players (name, priceinmill) VALUES (:name, :priceinmill)');
foreach ($players1 as $player) {
    $stmt->bindValue(':name', $player[0], SQLITE3_TEXT);
    $stmt->bindValue(':priceinmill', $player[1], SQLITE3_INTEGER);
    $stmt->execute();
}

//  Updating data
$stmt = $db->prepare('UPDATE players SET priceinmill = :priceinmill WHERE name = :name');
$stmt->bindValue(':priceinmill', 1000, SQLITE3_INTEGER);
$stmt->bindValue(':name', 'Costa', SQLITE3_TEXT);
$stmt->execute();


// Deleting data
$stmt = $db->prepare('DELETE FROM players WHERE name = :name');
$stmt->bindValue(':name', 'caicedo', SQLITE3_TEXT);
$stmt->execute();


// Using parameterized queries
$stmt = $db->prepare('SELECT * FROM players WHERE name = :name');
$stmt->bindValue(':name', 'Kante', SQLITE3_TEXT);
$result = $stmt->execute();
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    print_r($row);
}


// Transactions
$db->exec('BEGIN TRANSACTION');
try {
    $db->exec("INSERT INTO players (name, priceinmill) VALUES ('robben', 350)");
    $db->exec("UPDATE players SET priceinmill = 980 WHERE name = 'robben'");
    $db->exec('COMMIT');
} catch (Exception $e) {
    $db->exec('ROLLBACK');
    echo "Transaction failed: " . $e->getMessage();
}

// Querying data
$results = $db->query('SELECT * FROM players');
while ($row = $results->fetchArray(SQLITE3_ASSOC)){
    print_r($row);
}


// Closing the connection
$db->close();

?>