<?php
    // Kết nối tới cơ sở dữ liệu
    $link = mysqli_connect('localhost', 'root', '', 'login');

    // Kiểm tra xem có dữ liệu được gửi từ form hay không
    if (isset($_POST['submit'])) {
        $username = $_POST['username']; // Lấy giá trị username từ URL

        // Lấy thông tin cần sửa từ form
        $password = $_POST['password'];
        $hashedPassword = md5($password);

        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];

        // Cập nhật thông tin người dùng trong cơ sở dữ liệu
        $query = "UPDATE user SET `Mật khẩu` = ' $hashedPassword', `Họ tên` = '$fullName', email = '$email', sđt = '$phoneNumber' WHERE `Tên đăng nhập` = '$username'";
        $result = mysqli_query($link, $query);

        if ($result) {
            echo 'Sửa thông tin người dùng thành công.';
        } else {
            echo 'Lỗi: ' . mysqli_error($link);
        }
    }

    // Truy vấn thông tin người dùng dựa trên giá trị username
    $username = $_GET['username'];
    $query = "SELECT * FROM user WHERE `Tên đăng nhập` = '$username'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $displayName = isset($row['Tên đăng nhập']) ? $row['Tên đăng nhập'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa thông tin người dùng</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Sửa thông tin người dùng</h2>
    <form action="" method="post">
        <div class="form-group">
            <label>Tên đăng nhập:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($displayName); ?>" required>
        </div>
        <div class="form-group">
            <label>Mật khẩu:</label>
            <input type="password" name="password" value="<?php echo isset($row['Mật khẩu']) ? htmlspecialchars($row['Mật khẩu']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Họ tên:</label>
            <input type="text" name="fullName" value="<?php echo isset($row['Họ tên']) ? htmlspecialchars($row['Họ tên']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="phoneNumber" value="<?php echo isset($row['sđt']) ? htmlspecialchars($row['sđt']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Lưu">
        </div>
    </form>
</body>
</html>