<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Panel</title>
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
<h1>Dành cho học sinh</h1>
<body>
    <div class="container">
       

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

</body>
</html>


            </div>
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Solve Challenge</title>
        <script>
    function showHint() {
        var hintElement = document.getElementById("hint");
        hintElement.style.display = "block";
    }
</script>
    </head>
    <body>
        <?php
        // Kết nối tới cơ sở dữ liệu
        $conn = mysqli_connect('localhost', 'root', '', 'login');

        if (!$conn) {
            die("Kết nối tới cơ sở dữ liệu thất bại: " . mysqli_connect_error());
        }

        // Xử lý form khi sinh viên nhập đáp án
        if (isset($_POST['submit'])) {
            // Lấy đáp án đã nhập từ form
            $answer = $_POST['answer'];
            $challengeId = $_POST['challenge_id'];

            // Kiểm tra đáp án
            $query = "SELECT file_name FROM challenges WHERE file_name Like '%$answer%'";
            $result = mysqli_query($conn, $query);
            
            $query2 = "SELECT id FROM challenges ORDER BY id ASC LIMIT 1;";
            $result2 = mysqli_query($conn, $query2);

            if (mysqli_num_rows($result2) > 0) {
            $row = mysqli_fetch_assoc($result2);
            $fileName = $row['file_name'];
            $hint = $row['hint'];

             echo "Gợi ý: $hint";
}
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $correctAnswer = $row['file_name'];
//            $content = $row['content'];
//            echo "<p>" + $correctAnswer + "</p>";
                if ($answer == $correctAnswer) {
                    // Lưu nội dung vào file đáp án
                    $filePath = "C:/xampp/htdocs/challenge10_Nupacachi/uploads/" . $correctAnswer;
//                file_put_contents($filePath, $content);
                    $myfile = fopen($filePath, "r") or die("Unable to open file!");
                    echo fread($myfile, filesize($filePath));
                   echo "<br>";
                    fclose($myfile);
                 
                   echo "Đáp án chính xác. ";
                } else {
                    echo "Đáp án không chính xác.";
                }
            } else {
                echo "Không tìm thấy challenge.";
            }
           
        }
        ?>
        

        <h1>Solve Challenge</h1>


        <form action="" method="POST">
            
            <label for="answer">Nhập đáp án:</label>
            <input type="text" name="answer" required>
            <input type="hidden" name="challenge_id" value="">
            <button type="submit" name="submit">Submit</button>

        </form>
  <?php
    // Hiển thị gợi ý
        $conn2 = mysqli_connect('localhost', 'root', '', 'login');
        $query = "SELECT id,hint FROM challenges ORDER BY id ASC LIMIT 1";
         $result = mysqli_query($conn2, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
       // print_r($row);
        $hint1 = $row['hint'];
        echo "<button type=\"button\" onclick=\"showHint()\">Hiển thị gợi ý</button>";
        echo "<p id=\"hint\" style=\"display: none;\">Gợi ý: $hint1</p>";
    }
    ?>

    <script>
        function showHint() {
            var hintElement = document.getElementById("hint");
            hintElement.style.display = "block";
        }
    </script>       
        
        
    </body>
</html>
</body>

</html>