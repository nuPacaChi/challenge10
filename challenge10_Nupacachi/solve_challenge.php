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