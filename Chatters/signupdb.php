<?php
include 'db.php';
session_start();
if (isset($_SESSION['login_name'])) {
    // header("location: " . $_SERVER['HTTP_REFERER']);
    header("location: ./welcome.php");
}else{
    $email = !empty($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;
    $password = !empty($_POST['password']) ?$conn->real_escape_string($_POST['password']): null;
    $name = !empty($_POST['name']) ?$conn->real_escape_string($_POST['name']): null;
    $lastname = !empty($_POST['lastname']) ?$conn->real_escape_string($_POST['lastname']): null;
    @$file_tmp = $_FILES['img']['tmp_name'];
    @$file_name = $_FILES['img']['name'];
    @$file_size = $_FILES['img']['size'];
    if ($file_size > 2000000) {
        echo 'file is too large;';
        die;
    }
    
    move_uploaded_file($file_tmp, './img/'.basename($file_name));
    
    // Check if the email already exists in the login table
    $sql_select = "SELECT * FROM login WHERE email='$email'";
    $result = $conn->query($sql_select);
    if (isset($email) && isset($password)) {
        if (empty($email) || empty($password)) {
            echo 'empty data';
        } else if ($result->num_rows > 0) {
            echo "<span style='color:red'>This Email is already in use</span>";
        } else {
            // Get the maximum ID value from the login table
            $sql_max_id = "SELECT MAX(id) AS max_id FROM login";
            $result_max_id = $conn->query($sql_max_id);
            $row = $result_max_id->fetch_assoc();
            $max_id = $row['max_id'];
            // Increment the ID value
            $new_id = $max_id + 1;
            $sql_userselect = "SELECT username FROM login";
            $result_user = $conn->query($sql_userselect);
            $username_taken = false;
            $username = !empty($_POST['newusername']) ? $conn->real_escape_string($_POST['newusername']) : null;
            while ($fetching = $result_user->fetch_assoc()) {
                $usernamefetch = $fetching['username'];
                if ($username == $usernamefetch) {
                    $username_taken = true;
                    break;
                }
            }
            if ($username_taken) {
                echo "username taken";
            }else {
                $sql = "INSERT INTO login (id, name, lastname, email, password, imgname,username) VALUES ($new_id, '$name','$lastname','$email', '$password', './img/$file_name','$username')";
            if ($conn->query($sql)) {
                echo "";
                // header('location: Home.php');
            } else {
                echo "Error: " . $conn;
            }
            }
        }
    }
}

?>