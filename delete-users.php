<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './connection.php';

try {
    // Nhận id từ request
    $id = $_GET['id'];

    // Xóa dữ liệu trong database
    $sqlQuery = "DELETE FROM users WHERE id = $id";
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();

    echo json_encode(array("message" => "Xóa người dùng thành công!"));
} catch (Exception $ex) {
    echo json_encode(array(
        "message" => "Xóa người dùng thất bại!",
        "error" => $ex->getMessage()
    ));
}
