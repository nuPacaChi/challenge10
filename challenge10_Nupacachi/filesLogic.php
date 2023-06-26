<?php
$conn =mysqli_connect('localhost','root','','login');
$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
if(isset($_POST['save'])){
    $filename = $_FILES['myfile']['name'];
    
    $destination ='C:/xampp/htdocs/challenge10_Nupacachi/downloads/'. $filename;
    $extension = pathinfo($filename,PATHINFO_EXTENSION);
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    
    if(!in_array($extension, ['zip', 'pdf', 'docx','txt'])) {
        echo "You file extension must be .zip, .pdf or .docx .txt";
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "file lon qua";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (name, size, downloads) VALUES ('$filename', $size, 0)";
            if (mysqli_query($conn, $sql)) {
                echo "File uploaded successfully";
                  header("Location: admin.php");
            }
        } else {
            echo "Failed to upload file.";
        }
    }
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE Id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'C:/xampp/htdocs/challenge10_Nupacachi/downloads/' . $file['name'];

       $isExist  = file_exists($filepath) ;
       
       echo 'Exist: ' . $isExist . " - " . $file['name'];
    
    if ($isExist) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('C:/xampp/htdocs/challenge10_Nupacachi/downloads/' . $file['name']));
        readfile('C:/xampp/htdocs/challenge10_Nupacachi/downloads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE Id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}

}