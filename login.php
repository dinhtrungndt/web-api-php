<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST ");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/login.php
// đăng nhập
include_once './connection.php';
include_once './helpers/jwt.php';

try {
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $password = $data->password;
    $sqlQuery = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $check = password_verify($password, $user['password']);
        if ($check == false) {
            echo json_encode(array(
                "status" => false,
                "message" => "Password is incorrect."
            ));
            return;
        }
        $headers = array('alg' => 'HS256', 'type' => 'JWT');
        $payload = array(
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
            'exp' => (time() + 60)
        );
        $token = generate_jwt($headers, $payload);
        echo json_encode(array(
            "status" => true,
            "user" => $user,
            "token" => $token
        ));
    } else {
        echo json_encode(array(
            "status" => false,
            "user" => null,
        ));
    }
} catch (Exception $ex) {
    echo json_encode(array(
        "success" => "Đăng nhập thất bại!",
        "error" => $ex->getMessage()
    ));
}
