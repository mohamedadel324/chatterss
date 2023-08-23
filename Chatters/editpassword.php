<?php
    include 'db.php';
    session_start();
    $sql = "SELECT * FROM login WHERE id = {$_SESSION['login_name']}";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $user_password = $user['password'];
    $oldpass = !empty($_POST['Currentpassword']) ? $conn->real_escape_string($_POST['Currentpassword']) : null;
    $newpass = !empty($_POST['newpassword']) ? $conn->real_escape_string($_POST['newpassword']) : null;
        if (isset($_POST['newpassword']) && isset($_POST['Currentpassword'])) {
            if ($oldpass == $user_password) {
                $sql = "UPDATE login SET password='$newpass' WHERE id = {$_SESSION['login_name']}";
                $conn->query($sql);
                }
            else if (empty(($conn->real_escape_string($_POST['Currentpassword']))) || empty($conn->real_escape_string($_POST['newpassword']))) {
                echo "empty value";
            }else if ($user_password != $oldpass) {
                echo "<p>Your Current Password Is Incorrect</p>";
            }
            

            
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Your Password</title>
    <link rel="stylesheet" href="editpassword.css">
</head>
<body>
    <div>
        
    </div>
    <form id="pass" class="Passwords" method="POST">
        <label for="Currentpassword">Enter Your Current Passowrd</label>
        <input name="Currentpassword" id="Currentpassword" type="text">
        <label for="newpassword">Enter Your New Passowrd</label>
        <input name="newpassword" id="newpassword" type="text">
        <label for="retypenewpassword">Retype Your New Passowrd</label>
        <input id="retypenewpassword" type="text">
        <input type="submit" id="newpass">
    </form>
    <a href="profile.php">back</a>
    <span id='eror'>
    </span>
    <script>
        let password     = document.getElementById('newpassword');
        let retypenewpassword = document.getElementById('retypenewpassword');
        let eror = document.getElementById('eror');
        let form = document.getElementById('pass');
        form.addEventListener('submit', function(e) {
            e.preventDefault()
            if (password.value == null && retypenewpassword.value == null ||password.value == '' && retypenewpassword.value == '') {
                eror.innerHTML = 'password is empty !'
            }
            if (password.value != retypenewpassword.value) {
                eror.innerHTML = 'passwords dont match !'
            }
            if (!(password.value == null && retypenewpassword.value == null ||password.value == '' && retypenewpassword.value == '') && !(password.value != retypenewpassword.value) ) {
                form.submit()
            }
        })
    </script>
</body>
</html>