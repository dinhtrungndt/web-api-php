<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once './connection.php';

try {
    $email = $_GET['email'];

    $sqlQuery = "SELECT COUNT(*) AS count FROM users WHERE email = '$email'";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Trả về kết quả dưới dạng JSON
    echo json_encode(array("exists" => $result['count'] > 0));
} catch (Exception $ex) {
    echo json_encode(array(
        "message" => "Error checking email existence.",
        "error" => $ex->getMessage()
    ));
}
