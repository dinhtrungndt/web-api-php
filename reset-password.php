<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/reset-password.php
//  đọc email và token, password, password_confirmation từ body

try {
    include_once './connection.php';
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $token = $data->token;
    $password = $data->password;
    $password_confirmation = $data->password_confirmation;

    // kiểm tra password và password_confirmation có giống nhau hay không
    if ($password != $password_confirmation) {
        echo json_encode(array(
            "status" => false,
            "message" => "Password and password confirmation are not the same."
        ));
        return;
    }

    //  kiểm tra email và token có hợp lệ hay không
    $sqlQuery = "SELECT * FROM forgot_password WHERE email = '$email' AND token = '$token' and created_at >= now() - INTERVAL 1 hour and available = 1";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // ma hoa password
    $password = password_hash($password, PASSWORD_BCRYPT);

    if ($result) {
        //    cập nhập mật khẩu vào users
        $query = "update users set password = '$password' where email = '$email'";
        $stmt = $dbConn->prepare($query);
        $stmt->execute();
        // cập nhập available = 0 trong forgot_password
        $query = "update forgot_password set available = 0 where email = '$email'";
        $stmt = $dbConn->prepare($query);
        $stmt->execute();
        echo json_encode(array(
            "status" => true,
            "message" => "Reset password successfully."
        ));
    } else {
        // nếu email và token không hợp lệ thì trả về false
        echo json_encode(array(
            "status" => false,
            "message" => "Email or token is invalid."
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "message" => $e->getMessage()
    ));
}
