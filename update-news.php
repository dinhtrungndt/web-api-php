<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/update-news.php
// cập nhật 1 bản tin
include_once './connection.php';

try {
    // Đọc dữ liệu từ client gửi lên
    $data = json_decode(file_get_contents("php://input"));

    // Đọc dữ liệu từ json
    $id = $data->id;
    $title = $data->title;
    $content = $data->content;
    $image = $data->image;
    $user_id = $data->user_id;
    $topic_id = $data->topic_id;

    // Cập nhật dữ liệu vào database
    $sqlQuery = "UPDATE news SET title = :title, content = :content, image = :image, user_id = :user_id, topic_id = :topic_id WHERE id = :id";

    // Thực thi câu lệnh pdo với prepared statement
    $stmt = $dbConn->prepare($sqlQuery);

    // Bind các giá trị vào các tham số
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);
    $stmt->bindParam(":image", $image);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":topic_id", $topic_id);

    // Thực thi prepared statement
    $stmt->execute();

    // Trả về thông báo
    echo json_encode(array("message" => "Cập nhật bản tin thành công!"));
} catch (Exception $ex) {
    echo json_encode(array(
        "message" => "Cập nhật bản tin thất bại!",
        "error" => $ex->getMessage()
    ));
}
