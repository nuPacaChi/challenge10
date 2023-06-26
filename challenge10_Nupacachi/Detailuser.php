<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thông tin chi tiết người dùng</title>
    <meta charset="utf-8">
    <style>
        /* Thiết lập kiểu cho bảng */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Thiết lập kiểu cho tiêu đề cột */
        th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
        }

        /* Thiết lập kiểu cho dòng chẵn */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Thiết lập kiểu cho dòng lẻ */
        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Thiết lập kiểu cho ô dữ liệu */
        td {
            padding: 8px;
        }

        .chat-container {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
        }

        .chat-container h2 {
            margin-top: 0;
            width: 100%;
        }

        .chat-container .user-info {
            width: 50%;
        }

        .chat-container .message-list {
            width: 50%;
            margin-top: 10px;
        }

        .chat-container form {
            display: flex;
            gap: 10px;
            width: 100%;
        }

        .chat-container form input[type="text"] {
            flex-grow: 1;
            padding: 5px;
        }

        .chat-container form button {
            padding: 5px 10px;
        }

        .chat-container .message-list .message {
            margin-bottom: 5px;
            padding: 5px;
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php
    // Kiểm tra xem đã truyền username từ trang admin.php hay chưa
    if (isset($_POST['username'])) {
        $username = $_POST['username'];

        // Kết nối tới cơ sở dữ liệu
        $link = mysqli_connect('localhost', 'root', '', 'login');

        // Truy vấn thông tin người dùng
        $query = "SELECT * FROM user WHERE `Tên đăng nhập` = '$username'";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            // Hiển thị thông tin người dùng
            $row = mysqli_fetch_assoc($result);
            $fullName = $row['Họ tên'];
            $email = $row['email'];
            $phoneNumber = $row['sđt'];

            echo "<div class='chat-container'>";
            echo "<div class='user-info'>";
            echo "<h2>Thông tin chi tiết người dùng</h2>";
            echo "<table>";
            echo "<tr><th>Tên đăng nhập:</th><td>$username</td></tr>";
            echo "<tr><th>Họ tên:</th><td>$fullName</td></tr>";
            echo "<tr><th>Email:</th><td>$email</td></tr>";
            echo "<tr><th>Số điện thoại:</th><td>$phoneNumber</td></tr>";
            echo "</table>";
            echo "</div>";

            // Hiển thị đoạn chat với người dùng
            echo "<div class='message-list'>";
            echo "<h2>Đoạn chat với người dùng</h2>";

            // Truy vấn tin nhắn với người dùng
            $query = "SELECT * FROM messages WHERE username = '$username'";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="message-list">';
            while ($row = mysqli_fetch_assoc($result)) {
                $messageId = $row['id'];
                echo '<div class="message">';
                echo '<strong>' . $row['sender'] . ':</strong> ' . $row['message'];
                echo '<div class="message-actions">';
                echo '<a href="edit_message.php?id=' . $messageId . '">Sửa</a> | ';
                echo '<a href="delete_message.php?id=' . $messageId . '">Xóa</a>';
                echo '</div>';
                echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>Không có tin nhắn nào với người dùng này.</p>';
            }

            // Hiển thị form để gửi tin nhắn mới
            echo '<form action="send_message.php" method="post">';
            echo '<input type="hidden" name="username" value="' . $username . '">';
            echo '<input type="text" name="message" placeholder="Nhập tin nhắn..." required>';
            echo '<button type="submit">Gửi</button>';
            echo '</form>';
            echo '</div>';
        } else {
            echo 'Không tìm thấy thông tin người dùng.';
        }
    } else {
        echo 'Không có thông tin người dùng.';
    }
    ?>

</body>

</html>