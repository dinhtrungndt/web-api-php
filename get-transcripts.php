<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:  GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/get-trascripts.php
// import file connection.php
include_once './connection.php';
$sql = "SELECT id, name, point, description, created_at, user_id FROM strascripts";

// Thực thi câu lệnh pdo
$stmt = $dbConn->prepare($sql);
$stmt->execute();

// Lấy tất cả dữ liêuj từ câu lệnh pdo
$transcripts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Trả về dữ liệu dạng json
echo json_encode($transcripts);
