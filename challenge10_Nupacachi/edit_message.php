<?php
// Kiểm tra xem đã truyền id của tin nhắn cần sửa hay chưa
if (isset($_GET['id'])) {
    $messageId = $_GET['id'];

    // Kết nối tới cơ sở dữ liệu
    $link = mysqli_connect('localhost', 'root', '', 'login');

    // Kiểm tra xem tin nhắn có tồn tại trong cơ sở dữ liệu hay không
    $query = "SELECT * FROM messages WHERE id = '$messageId'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $message = $row['message'];

        // Hiển thị form sửa tin nhắn
        echo '<form action="update_message.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $messageId . '">';
        echo '<textarea name="message">' . $message . '</textarea>';
        echo '<button type="submit">Lưu</button>';
        echo '</form>';
    } else {
        echo 'Không tìm thấy tin nhắn.';
    }
} else {
    echo 'Không có thông tin tin nhắn.';
}
?>