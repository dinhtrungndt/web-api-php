<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:  GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/get-news.php
// import file connection.php
include_once './connection.php';
$sql = "SELECT id, title, content, image, created_at, user_id, topic_id FROM news";

//  lấy bài viết dựa theo user_id
// http://127.0.0.1:8686/get-news.php?user_id=1
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT id, title, content, image, created_at, user_id, topic_id FROM news WHERE user_id = $user_id";
}

// Thực thi câu lệnh pdo
$stmt = $dbConn->prepare($sql);
$stmt->execute();

// Lấy tất cả dữ liêuj từ câu lệnh pdo
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Trả về dữ liệu dạng json
echo json_encode($news);
