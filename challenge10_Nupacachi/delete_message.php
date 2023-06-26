<?php
// Kiểm tra xem đã truyền id của tin nhắn cần xóa hay chưa
if (isset($_GET['id'])) {
    $messageId = $_GET['id'];

    // Kết nối tới cơ sở dữ liệu
    $link = mysqli_connect('localhost', 'root', '', 'login');

    // Kiểm tra xem tin nhắn có tồn tại trong cơ sở dữ liệu hay không
    $query = "SELECT * FROM messages WHERE id = '$messageId'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0) {
        // Thực hiện truy vấn để xóa tin nhắn
        $deleteQuery = "DELETE FROM messages WHERE id = '$messageId'";
        mysqli_query($link, $deleteQuery);

        // Chuyển hướng về trang detailuser.php
        if (mysqli_affected_rows($link) > 0) {
            header('Location: detailuser.php?username=' . $_GET['username']);
        } else {
            echo 'Xóa tin nhắn không thành công.';
        }
    } else {
        echo 'Không tìm thấy tin nhắn.';
    }
} else {
    echo 'Không có thông tin tin nhắn.';
}
?>