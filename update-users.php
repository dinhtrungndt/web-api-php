<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/update-users.php
include_once './connection.php';

try {
    // Đọc dữ liệu từ client gửi lên
    $data = json_decode(file_get_contents("php://input"));

    // Đọc dữ liệu từ json
    $id = $data->id;
    $email = $data->email;
    $password = $data->password;
    $name = $data->name;
    $role = $data->role;
    $avatar = $data->avatar;

    // Cập nhật dữ liệu vào database
    $sqlQuery = "UPDATE users SET email = :email, password = :password, name = :name, role = :role, avatar = :avatar WHERE id = :id";

    // Thực thi câu lệnh pdo với prepared statement
    $stmt = $dbConn->prepare($sqlQuery);

    // Bind các giá trị vào các tham số
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":role", $role);
    $stmt->bindParam(":avatar", $avatar);

    // Thực thi prepared statement
    $stmt->execute();

    // Trả về thông báo
    echo json_encode(array("message" => "Cập nhật user thành công!"));
} catch (Exception $ex) {
    echo json_encode(array(
        "message" => "Cập nhật user thất bại!",
        "error" => $ex->getMessage()
    ));
}
