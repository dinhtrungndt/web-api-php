<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://192.168.11.116:8686/old-new-password.php
include_once './connection.php';
try {
    $data = json_decode(file_get_contents("php://input"));
    $password_old = $data->password_old;
    $password_new = $data->password_new;
    $password_confirm = $data->password_confirm;

    // so sanh password_new va password_confirm
    if ($password_new != $password_confirm) {
        echo json_encode(array(
            "status" => false,
            "message" => "Password and password confirmation are not the same."
        ));
        return;
    }

    // kiem tra email da ton tai hay chua
    $sqlQuery = "SELECT * FROM users WHERE id = '$id'";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo json_encode(array(
            "status" => false,
            "message" => "User not found."
        ));
        return;
    }

    // kiem tra password cu co dung hay khong
    if (!password_verify($password_old, $user['password'])) {
        echo json_encode(array(
            "status" => false,
            "message" => "Old password is incorrect."
        ));
        return;
    }

    // ma hoa password
    $password_new = password_hash($password_new, PASSWORD_BCRYPT);

    $sqlQuery = "UPDATE users SET password = '$password_new' WHERE id = '$id'";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();
    echo json_encode(array(
        "status" => true,
        "message" => "Change password successfully."
    ));
} catch (Exception $e) {
    echo json_encode(array(
        "message" => $e->getMessage()
    ));
}
