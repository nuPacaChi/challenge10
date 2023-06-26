<?php
// Kết nối cơ sở dữ liệu
$link = mysqli_connect('localhost', 'root', '', 'login');

// Kiểm tra xem có file được upload hay không
if ($_FILES['file']['size'] > 0) {
  // Xử lý upload file
  $file = $_FILES['file'];
  $fileName = $file['name'];
  $fileTmpPath = $file['tmp_name'];
  $targetDirectory = 'C:/xampp/htdocs/challenge10_Nupacachi/uploads/';
  $targetFilePath = $targetDirectory . $fileName;
  move_uploaded_file($fileTmpPath, $targetFilePath);
} else {
  // Xử lý khi không có file được upload
  $fileName = ''; // Gán giá trị mặc định cho $fileName hoặc thông báo lỗi
}

// Lưu thông tin challenge vào cơ sở dữ liệu
$hint = $_POST['hint'];

// Thực hiện truy vấn INSERT để lưu thông tin challenge vào bảng challenges
$query = "INSERT INTO challenges (file_name, hint) VALUES ('$fileName', '$hint')";
$result = mysqli_query($link, $query);

if ($result) {
  // Chuyển hướng người dùng về trang thành công
  header('Location: admin.php?success=true');
} else {
  // Xử lý khi truy vấn INSERT thất bại
  // Hiển thị thông báo lỗi hoặc chuyển hướng người dùng về trang lỗi
}
?>