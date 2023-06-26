<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $username = $_POST['username'];

    // Kết nối tới cơ sở dữ liệu
    $link = mysqli_connect('localhost', 'root', '', 'login');

    // Thực thi truy vấn để xóa người dùng
    $query = "DELETE FROM user WHERE `Tên đăng nhập`='$username'";
    $result = mysqli_query($link, $query);

    // Kiểm tra kết quả truy vấn và thông báo kết quả
    if ($result) {
        echo 'Xóa người dùng thành công.';
    } else {
        echo 'Xóa người dùng thất bại.';
    }
}
?>