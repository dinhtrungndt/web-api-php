<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST GET PUT DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/search-news.php?keyword=abc
// Tìm kiếm bản tin theo từ khóa
include_once './connection.php';

// Đọc dữ liệu từ phương thức GET của query string
$keyword = $_GET['keyword'];
// imprort file kết nối đến database
$sqlQuery = "SELECT id, title, content, created_at, user_id, topic_id
                FROM news WHERE title
                    LIKE '%$keyword%' OR content LIKE '%$keyword%'";

// Thực thi câu lệnh pdo_drivers
$stmt = $dbConn->prepare($sqlQuery);
$stmt->execute();

// Lấy tất cả dữ liêuj từ câu lệnh pdo
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Trả về dữ liệu dạng json
echo json_encode($news);
