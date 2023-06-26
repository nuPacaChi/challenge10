<?php 
$conn =mysqli_connect('localhost','root','','login');
$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

 $id = $_GET['file_id'];

    // fetch file to download from database
    $sql2 = "SELECT * FROM files WHERE Id=$id";
    $result2 = mysqli_query($conn, $sql2);

    $file = mysqli_fetch_assoc($result2);
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
       // exit;
    }


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="style2.css">
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