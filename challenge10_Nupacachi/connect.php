<!DOCTYPE html>
<html>
    <head>
        <title>Kết nối database</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        $link = mysqli_connect('localhost', 'root', '', 'login');
        mysqli_set_charset($link, "utf8");
        if (!$link) {
            die('Không thể kết nối với database: ' . mysqli_connect_error());
        }     
        ?>
        <div class="copyright" style="background: #d9edf7;color: #31708f; padding: 15px 15px;">&copy; Đế Tọa</div>
    </body>
</html>