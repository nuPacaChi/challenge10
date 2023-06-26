<?php
// Kiểm tra xem đã truyền username và message từ form hay chưa
if (isset($_POST['username']) && isset($_POST['message'])) {
    $username = $_POST['username'];
    $message = $_POST['message'];

    // Kết nối tới cơ sở dữ liệu
    $link = mysqli_connect('localhost', 'root', '', 'login');

    // Thực hiện truy vấn để lưu tin nhắn
    $query = "INSERT INTO messages (username, sender, message) VALUES ('$username', 'Admin', '$message')";
    mysqli_query($link, $query);

    // Chuyển hướng về trang detailuser.php
    header('Location: detailuser.php?username=' . $username);
    exit();
} else {
    echo 'Không có thông tin người dùng hoặc tin nhắn.';
}
?>
