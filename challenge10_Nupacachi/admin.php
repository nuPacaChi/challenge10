<!DOCTYPE html>
<html lang="en">

<head>
    <title>Teacher Panel</title>
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

        .user-actions {
            display: flex;
        }

        .user-actions form {
            margin-right: 5px;
        }
    </style>
</head>
<h1> Dành cho giáo viên</h1>
<body>
    <div class="container">
        <!-- Form thêm người dùng -->
        <h3>Thêm người dùng</h3>
        <form action="add_user.php" method="post">
            <div class="form-group">
                <label>Tên đăng nhập:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="fullName" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="tel" name="phoneNumber" required>
            </div>
            <div class="form-group">
                <button type="submit">Thêm</button>
            </div>
        </form>

        <h2>Thông tin</h2>
        <?php
        // Kết nối tới cơ sở dữ liệu
        $link = mysqli_connect('localhost', 'root', '', 'login');

        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        session_start();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            // Truy vấn thông tin người dùng
            $query = "SELECT * FROM user WHERE `Tên đăng nhập` = '$username'";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                // Hiển thị thông tin người dùng
                $row = mysqli_fetch_assoc($result);
                $fullName = $row['Họ tên'];

                echo "<h2>Chào mừng $fullName!</h2>";
            } else {
                echo 'Không tìm thấy thông tin người dùng.';
            }
        } else {
            echo 'Bạn chưa đăng nhập.';
        }
        ?>

        <!-- Hiển thị thông tin người dùng dưới dạng bảng -->
        <?php
        // Truy vấn danh sách người dùng
        $query = "SELECT * FROM user";
        $result = mysqli_query($link, $query);

        // Kiểm tra và hiển thị thông tin người dùng dưới dạng bảng
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Tên đăng nhập</th>';
            echo '<th>Mật khẩu</th>';
            echo '<th>Họ Tên</th>';
            echo '<th>Email</th>';
            echo '<th>Số điện thoại</th>';
            echo '<th>Chức năng</th>';
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['Tên đăng nhập'] . '</td>';
                echo '<td>' . $row['Mật khẩu'] . '</td>';
                echo '<td>' . $row['Họ tên'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['sđt'] . '</td>';
                echo '<td class="user-actions">';
                echo '<form action="edit_user.php" method="post">';
                echo '<input type="hidden" name="username" value="' . $row['Tên đăng nhập'] . '">';
                echo '<button type="submit">Sửa</button>';
                echo '</form>';
                echo '<form action="delete_user.php" method="post">';
                echo '<input type="hidden" name="username" value="' . $row['Tên đăng nhập'] . '">';
                echo '<button type="submit">Xóa</button>';
                echo '</form>';
                echo '<form action="Detailuser.php" method="post">';
                echo '<input type="hidden" name="username" value="' . $row['Tên đăng nhập'] . '">';
                echo '<button type="submit">Xem chi tiết</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'Không có người dùng nào trong cơ sở dữ liệu.';
        }
        ?>
        

            </div>
    <div class="container">
    <div class="row">
        <h3>Upload file bài tập</h3>
        <form action="uploadfile.php" method="post" enctype="multipart/form-data">
            <input type="file" name="myfile"><br>
            <button type="submit" name="save">Upload</button>
        </form>
    </div>
    </div>
    
    <?php include 'filesLogic.php';?>
    
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Download files</title>
</head>
<body>

<table>
<thead>
    <th>ID</th>
    <th>Filename</th>
    <th>size (in mb)</th>
    <th>Downloads</th>
    <th>Action</th>
</thead>
<tbody>
  <?php foreach ($files as $file): ?>
    <tr>
      <td><?php echo $file['Id']; ?></td>
      <td><?php echo $file['name']; ?></td>
      <td><?php echo floor($file['size'] / 1000) . ' KB'; ?></td>
      <td><?php echo $file['downloads']; ?></td>
      <td><a href="downloads.php?file_id=<?php echo $file['Id'] ?>">Download</a></td>
    </tr>
  <?php endforeach;?>

</tbody>
</table>

<!DOCTYPE html>
<html>
<head>
  <title>Tạo Challenge</title>
</head>
<body>
  <h1>Create Challenge</h1>
  <form action="process_create_challenge.php" method="post" enctype="multipart/form-data">
    <label>Upload File:</label>
    <input type="file" name="file">
    <br>
    <label>Hint:</label>
    <input type="text" name="hint">
    <br>
    <input type="submit" value="Submit">
  </form>
</body>
</html>

</body>
</html>
    
    
</body>

</html>