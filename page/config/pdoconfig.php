<?php
$DB_host = "localhost";
$DB_user = "id22325289_minomt";
$DB_pass = "!Noobboymc999";
$DB_name = "id22325289_restro4youbaby";
try {
    $pdo = new PDO("mysql:host={$DB_host};port=3306;dbname={$DB_name}", $DB_user, $DB_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $e->getMessage();
}
