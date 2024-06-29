<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/check-reset-password.php
// kiểm tra token có hợp lệ hay không

try {
    // kiểm tra token có hợp lệ hay không
    include_once './connection.php';

    // đọc email và token từ body
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $token = $data->token;

    $sqlQuery = "SELECT * FROM forgot_password WHERE email = '$email' AND token = '$token' and created_at >= now() - INTERVAL 1 hour and available = 1";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {

        // nếu token hợp lệ thì trả về true
        echo json_encode(array(
            "status" => true,
            "message" => "Token is valid."
        ));
    } else {
        // nếu token không hợp lệ thì trả về false
        echo json_encode(array(
            "status" => false,
            "message" => "Token is invalid."
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "message" => $e->getMessage()
    ));
}
