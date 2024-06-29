<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


use PHPMailer\PHPMailer\PHPMailer;

include_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/PHPMailer-master/src/Exception.php';


// http://127.0.0.1:8686/forgot-password.php
// quên mật khẩu
// import connection.php
include_once './connection.php';
try {
  $baseUrl = "http://172.16.123.185:3000";
  // đọc email từ body
  $data = json_decode(file_get_contents("php://input"));
  $email = $data->email;

  // kiểm tra email có trong db hay không
  $sqlQuery = "SELECT id FROM users WHERE email = '$email'";
  $stmt = $dbConn->prepare($sqlQuery);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($result) {
    // nếu có email trong db thì gửi email
    // send email otp
    // tạo token bằng cách mã hóa email và thời gian
    $token = md5(time() . $email);
    // lưu token vào database
    $query = "insert into forgot_password (email, token)
                        values ('$email', '$token') ";
    $stmt = $dbConn->prepare($query);
    $stmt->execute();
    // gửi email có link reset mật khẩu
    $link = "<a href='{$baseUrl}/reset-password?email="
      . $email . "&token=" . $token . "'<a class='button' href=''>Reset Password</a>";
    $mail = new PHPMailer();
    $mail->CharSet = "utf-8";
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "nguyendinhtrung.it";
    $mail->Password = "jwdximtoedtkugoi";
    $mail->SMTPSecure = "ssl";
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->Port = "465";
    $mail->From = "nguyendinhtrung.it@gmail.com";
    $mail->FromName = "My FPT - Forgot Password";
    $mail->addAddress($email, 'Hello');
    $mail->Subject = "Reset Password";
    $mail->isHTML(true);
    $mail->Body = "
        <!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
      }
      .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      h1 {
        color: #333333;
      }
      p {
        color: #666666;
      }
      .button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        background-color: #4caf50;
        color: #ffffff;
        border-radius: 5px;
        cursor: pointer;
      }
      .button:hover {
        background-color: #45a049;
      }
    </style>
  </head>
  <body>
    <div class='container'>
      <h1>Reset Your Password</h1>
      <p>Hello,</p>
      <p>
        We received a request to reset your password. Click the button below to
        reset it:
      </p>
      {$link}
      <p>
        If you didn't request this, you can safely ignore this email. Your
        password will not be changed.
      </p>
    </div>
  </body>
</html>";
    $res = $mail->Send();
    if ($res) {
      echo json_encode(array(
        "message" => "Email sent.",
        "status" => true
      ));
    } else {
      echo json_encode(array(
        "message" => "Email sent failed.",
        "status" => false
      ));
    }
  } else {
    // nếu không có email trong db thì trả về thông báo
    echo json_encode(array(
      "status" => false,
      "message" => "Email không tồn tại."
    ));
  }
} catch (\Throwable $th) {
  echo json_encode(array(
    "status" => false,
    "message" => "Có lỗi nè."
  ));
}
