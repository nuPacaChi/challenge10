<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = md5($password);

    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];

    // Kết nối tới cơ sở dữ liệu
    $link = mysqli_connect('localhost', 'root', '', 'login');
    
    // Thực thi truy vấn để thêm người dùng mới
    $query = "INSERT INTO user (`Tên đăng nhập`, `Mật khẩu`, `Họ tên`, `email`, `sđt`) 
              VALUES ('$username', '$hashedPassword', '$fullName', '$email', '$phoneNumber')";
    $result = mysqli_query($link, $query);

    // Kiểm tra kết quả truy vấn và thông báo kết quả
    if ($result) {
        echo 'Thêm người dùng thành công.';
    } else {
        echo 'Thêm người dùng thất bại.';
    }
}