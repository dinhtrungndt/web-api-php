<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/get-monhoc-detail.php
// lấy chi tiết 1 bản tin
include_once './connection.php';
// Đọc id từ query string
$id = $_GET['id'];

// Đọc dữ liệu từ database
$sqlQuery = "SELECT id, tenloaimon FROM loaimonhocs WHERE id = $id";

// Thực thi câu lệnh pdo
$stmt = $dbConn->prepare($sqlQuery);
$stmt->execute();

// Đọc dữ liệu 1 bảng tin
$monhoc = $stmt->fetch(PDO::FETCH_ASSOC);

// trả về dữ liệu dạng json
echo json_encode($monhoc);
