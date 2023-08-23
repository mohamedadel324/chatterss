<?php
include 'db.php';
session_start();
if (isset($_SESSION['login_name'])) {
    // header("location: " . $_SERVER['HTTP_REFERER']);
    header("location: ./welcome.php");
} else {
    // session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Assuming you have already established a database connection
        // Retrieve the user's input from the sign-up page
        @$email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        // Perform necessary sanitization and validation on the input data
        // Generate a login code
        $loginCode = md5(uniqid(rand(), true));
        // Store the login code in the database
        $query = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            // Login code successfully stored in the database
            $sql_sel = "SELECT id FROM login WHERE email = '$email' AND password = '$password'";
            $result = $conn->query($sql_sel);
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
            }
            $_SESSION['login_name'] = $id;
            header('location: welcome.php');
        } else {
            $err = "<p class='wrong'>Invalid Email or Password</p>";
        }
        // Close the database connection
        $conn->close();
    }

}


?>