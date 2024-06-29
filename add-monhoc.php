<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/add-monhoc.php
// thêm mới 1 bản tin
include_once './connection.php';

try {

    // Đọc dữ liệu từ client gửi lên
    $data = json_decode(file_get_contents("php://input"));

    // Đọc dữ liệu từ json
    $tenmonhoc = $data->tenmonhoc;
    $loaimonhoc_id = $data->loaimonhoc_id;

    // Thêm dữ liệu vào database
    $sqlQuery = "INSERT INTO monhocs(tenmonhoc, loaimonhoc_id)
            VALUES ('$tenmonhoc', '$loaimonhoc_id')";

    // Thực thi câu lệnh pdo
    $stmt = $dbConn->prepare($sqlQuery);
    $stmt->execute();

    // Trả về thông báo
    echo json_encode(array("message" => "Thêm mới bản tin thành công!"));
} catch (Exception $ex) {
    echo json_encode(array(
        "message" => "Thêm mới bản tin thất bại!",
        "error" => $ex->getMessage()
    ));
}
