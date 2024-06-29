<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:  GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:8686/get-student-fees.php
include_once './connection.php';

$sql = "SELECT s.id, s.name, s.age, s.sbd, s.avatar, f.tuition_fee, f.misc_fee
        FROM students s
        JOIN fees f ON s.id = f.student_id";

$stmt = $dbConn->prepare($sql);
$stmt->execute();

$studentFees = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($studentFees);
