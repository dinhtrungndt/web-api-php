<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/add-users.php
// thêm mới 1 users
include_once './connection.php';

try {

    // Đọc dữ liệu từ client gửi lên
    $data = json_decode(file_get_contents("php://input"));

    // Đọc dữ liệu từ json
    $email = $data->email;
    $password = $data->password;
    $name = $data->name;
    $role = $data->role;
    $avatar = $data->avatar;

    // ma hoa password
    $password = password_hash($password, PASSWORD_BCRYPT);

    // Thêm dữ liệu vào database
    $sqlQuery = "INSERT INTO users(email, password, name, role, avatar)
            VALUES ('$email', '$password', '$name', '$role', '$avatar')";

    // Thực thi câu lệnh pdo
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();

    // Trả về thông báo
    echo json_encode(array("message" => "Thêm mới người dùng thành công!"));
} catch (Exception $ex) {
    echo json_encode(array(
        "message" => "Thêm mới người dùng thất bại!",
        "error" => $ex->getMessage()
    ));
}
