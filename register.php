<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://192.168.11.116:8686/register.php
include_once './connection.php';
try {
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $password = $data->password;
    $password_confirm = $data->password_confirm;
    $name = $data->name;
    $role = "";
    $avatar = $data->avatar;
    // so sanh password va password_confirm
    if ($password != $password_confirm) {
        echo json_encode(array(
            "status" => false,
            "message" => "Password and password confirmation are not the same."
        ));
        return;
    }

    // kiem tra email da ton tai hay chua
    $sqlQuery = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo json_encode(array(
            "status" => false,
            "message" => "Email already exists."
        ));
        return;
    }

    // ma hoa password
    $password = password_hash($password, PASSWORD_BCRYPT);

    $sqlQuery = "INSERT INTO users (email, password,name,avatar)
                        VALUES ('$email', '$password','$name','$avatar')";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();
    echo json_encode(array(
        "status" => true,
        "message" => "Register successfully."
    ));
} catch (Exception $e) {
    echo json_encode(array(
        "message" => $e->getMessage()
    ));
}
