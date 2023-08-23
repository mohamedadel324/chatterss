<?php

    session_start();
    if (isset($_SESSION['login_name'])) {
        include 'db.php';
        $gender = '';
        if (isset($_POST['gender'])) {
            $gender = $conn->real_escape_string($_POST['gender']);
            
            $sql = "UPDATE login SET gender = '$gender' WHERE id = {$_SESSION['login_name']}";
            if ($conn->query($sql) === TRUE) {
                echo "Gender updated successfully";
            } else {
                echo "Error updating gender";
            }
        }
        $sql_userselect = "SELECT gender FROM login WHERE id = {$_SESSION['login_name']}";
        $result = $conn->query($sql_userselect);
        $row = $result->fetch_assoc();
        $current_gender = $row['gender'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gender</title>
    <link rel="stylesheet" href="gender.css">
</head>
<body>
    <div class = "center">
    <form method="post">
        <input class="radi" type="radio" name="gender" value="male" <?php if ($current_gender === 'male') echo 'checked'; ?>> Male<br>
        <input class="radi" type="radio" name="gender" value="female" <?php if ($current_gender === 'female') echo 'checked'; ?>> Female<br>
        <!-- <input type="radio" name="gender" value="other" > Other<br> -->
        <input class="save" type="submit" value="Save">
    </form>
</div>
    <a href="profile.php">back</a>
</body>
</html>