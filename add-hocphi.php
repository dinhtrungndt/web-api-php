<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/add-hocphi.php
// thêm mới 1 học phí
include_once './connection.php';

try {

    // Đọc dữ liệu từ client gửi lên
    $data = json_decode(file_get_contents("php://input"));

    // Đọc dữ liệu từ json
    $student_id = $data->student_id;
    $tuition_fee = $data->tuition_fee;
    $misc_fee = $data->misc_fee;
    $user_id = $data->user_id;

    // Thêm dữ liệu vào database
    $sqlQuery = "INSERT INTO fees(student_id, tuition_fee, misc_fee,created_at, user_id )
            VALUES ('$student_id', '$tuition_fee', '$misc_fee', now(), $user_id)";

    // Thực thi câu lệnh pdo
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();

    // Trả về thông báo
    echo json_encode(array("message" => "Thêm mới học phí thành công!"));
} catch (Exception $ex) {
    echo json_encode(array(
        "message" => "Thêm mới học phí thất bại!",
        "error" => $ex->getMessage()
    ));
}
