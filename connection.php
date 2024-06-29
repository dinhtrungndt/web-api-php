<?php
$databaseHost = '127.0.0.1:3306';
$databaseName = 'web-api-php';
$databaseUsername = 'root';
$databasePassword = 'anhdasai123';

try {
    $dbConn = new PDO(
        "mysql:host={$databaseHost};dbname={$databaseName}",
        $databaseUsername,
        $databasePassword
    );
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
