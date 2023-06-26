<form method="post" action="tinnhan.php">
    <input type="text" name="nguoi_nhan" placeholder="Người nhận">
    <textarea name="noi_dung" placeholder="Nội dung tin nhắn"></textarea>
    <input type="submit" value="Gửi">
</form>

<?php
    // Lấy thông tin từ form
    $nguoiNhan = $_POST['nguoi_nhan'];
    $noiDung = $_POST['noi_dung'];

        require('connect.php');


    // Lưu tin nhắn vào cơ sở dữ liệu
    $query = "INSERT INTO tin_nhan (nguoi_nhan, noi_dung) VALUES ('$nguoiNhan', '$noiDung')";
    if (mysqli_query($conn, $query)) {
        echo "Tin nhắn đã được gửi thành công";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }

    // Đóng kết nối
    mysqli_close($conn);
?>