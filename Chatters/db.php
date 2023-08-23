<?php
    $servername = "localhost";
    $username = "id21138861_admin";
    $password = "5265793Zx!";
    $dbname = "id21138861_priv_chat";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>