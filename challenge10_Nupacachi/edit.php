<?php 
    include_once(__DIR__.'\db\sqlFunction.php');
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }

    $username_session = $_SESSION['username'];
    $sql = 'SELECT * FROM users where username = "'.$username_session.'";';
    $userList_session = executeSelect($sql);
    $user_session = $userList_session[0];
    $avatar_session = $user_session['avatar'];
    $id_session = $user_session['user_id'];
    $role_session = $user_session['role_id'];

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="mb-3">
            <div style="float: left; margin-top: 27px;">
                <a href="admin.php"><button class="btn btn-success">Home</button></a>
            </div>
            <div style="float: right; margin-top: 27px;">
                <img src="<?php echo $avatar_session; ?>" alt="avatar" width="40px" height="40px">
                <a href="profile.php"><button class="btn btn-success">Profile</button></a>
                <a href="logout.php"><button class="btn btn-warning">Log out</button></a>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                </br>
                <h1 style="color:green;text-align:center;">Information of student and teacher</h1>
                </br>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
<?php  
    $sql = "SELECT * FROM Users";
    $userList = executeSelect($sql);

    foreach($userList as $urs){
        $role;
        if($urs['role_id'] == 2) $role = "Teacher";
        else if($urs['role_id'] == 1) $role = "Student"; 
        echo '<tr>
        <td>'.$urs['user_id'].'</td>
        <td>'.$urs['full_name'].'</td>
        <td>'.$urs['username'].'</td>
        <td>'.$urs['email'].'</td>
        <td>'.$urs['phone_number'].'</td>
        <td>'.$role.'</td>';
        
        if($role_session == 2){
            echo '<td><a href="editUser.php?id='.$urs['user_id'].'"><button class="btn btn-warning">Edit</button></a></td>
        <td><a href="deleteUser.php?id='.$urs['user_id'].'"><button class="btn btn-danger">Delete</button></a></td>';
        }
        if($id_session != $urs['user_id']){
            echo '<td><a href="messenger.php?toid='.$urs['user_id'].'&fromid='.$id_session.'"><button class="btn btn-primary">Chat</button></a></td>';
        }
    echo '</tr>';
    }
?>
                    </tbody>
                </table>
            </div>
            <?php 
                if($role_session == 2){
                    echo '<a href="addStudent.php"><button class="btn btn-primary">Add student</button></a>';
                }
            ?>
        </div>
    </div>
</body>