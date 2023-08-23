<?php
    include 'db.php';
    session_start();
    if (isset($_SESSION['login_name'])) {
        $sql = "SELECT * FROM login WHERE id = {$_SESSION['login_name']}";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $email = $user['email'];
        $name = $user['name'];
        $user_password = $user['password'];
        $lastname = $user['lastname'];
        $img =  $user['imgname'];
        $gender = !empty($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : null;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <h1>
            Hello <?php echo $name;?> <?php echo $lastname ?>
        </h1>
        <img class="Profile_Img" src="./<?php echo $img; ?>"/>
    </div>
    <form class="form_class" id="form" method="post">
        <div class="inputs_container">
            <input id="email" type="text" value="<?php  echo $email ?>" disabled>
            <input method="POST" name="passwordsub" type="password" id="password" disabled value="<?php  echo $user_password ?>">
        </div>
        <div class="edit_password_parent">
            <a href="editpassword.php">
                <input type="button" value="Edit Password" class="edit_password" >
            </a>
        </div>
        <div class="genderparent">
            <a href="gender.php">
                <input type="button" value="Edit Gender" class="gender">
            </a>
        </div>
        <a href="welcome.php">back</a>
    </form>
    <script>

    </script>
</body>
</html>

