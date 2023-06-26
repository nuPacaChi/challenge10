
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Đăng nhập</h2>
    <form action="index.php" method="post">
      <div class="form-group">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Đăng nhập</button>
    </form>
  </div>
<?php
// Kiểm tra xem có dữ liệu được gửi từ form không
if (isset($_POST['username']) && isset($_POST['password'])) {
    $u = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = md5($password);

    

    // Kết nối đến cơ sở dữ liệu
    require('connect.php');
    global $link;

    // Query để kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM user WHERE `Tên đăng nhập` = '$u' AND `Mật khẩu` = '$hashedPassword'";
    $result = mysqli_query($link, $sql);

    // Kiểm tra số lượng kết quả trả về
    if (mysqli_num_rows($result) == 0) {
        echo "Sai tài khoản hoặc mật khẩu.";
    } else {
        // Lấy thông tin người dùng từ kết quả truy vấn
        $row = mysqli_fetch_assoc($result);

        echo "Đăng nhập thành công.";

        // Kiểm tra xem tài khoản có chứa chuỗi "teacher" hay không
        if (strpos($row['Tên đăng nhập'], 'teacher') !== false) {
            // Chuyển hướng đến trang admin.php
            header('Location: admin.php');
            exit;
        } else {
            // Chuyển hướng đến trang student.php
            header('Location: student.php');
            exit;
        }
    }

    // Đóng kết nối
    mysqli_close($link);
}
?>
</body>
</html>