<?php
include 'db.php';
include 'signupdb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <section class="section">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </section class="section">
<div class="loadscreen">
        <div class="cont">
            <div>
                Chatters
            </div>
        </div>
    </div>
    <div class="h1">
        <a class="Sign" href="Home.php">Login</a>
        <h1>
            Chatters
        </h1>
        <p class="date">&copy;<?php echo date("20y");?></p>
    </div>
<form class="Father" id="form" method = "POST">
<div class="img_container">
                <label class="img" for="img">
                    <img id="preview" src="nonperson.jpg" alt="Upload Your Image">
                </label>
                <input required id="img" type="file" accept=".jpg, .png" name="img" onchange="previewImage(event)">
            </div>
            <input placeholder="First Name" required id="name" type="text" name="name">
            <br>
            <input placeholder="Last Name" required id="lastname" type="text" name="lastname">
            <br>
            <div class="EmailFather">
                <input placeholder="Email" id="Email" type="Email" name="email">
            </div>
            <br>
            <div class="PassFather">
                <input placeholder="Password" name="password" id="Password" type="password">
            </div>
            <div class="RetypePassFather">
                <input placeholder="Retype Your Password" name="retype" id="RetypePassword" type="password">
            </div>
            <div class="username_father">
                <input required placeholder="Enter Your Username" name="newusername" id="username" type="text">
            </div>
            <p class="eror" style="color: red; display: none;">password Dont Match</p>
            <input class="Sumbit" type="submit" value="SignUp">
        </form>
</body>
<script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
        var preview = document.getElementById('preview');
        preview.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
    }
    // document.getElementById("form").addEventListener("submit", (e) => {
    //     e.preventDefault();
    //     let email = document.getElementById("Email").value
    //     let password = document.getElementById("Password").value
    //     let reg = new RegExp('[~!@#$%^&*()_+{}\\[\\]:;,.<>/?-]').exec(password)
    //     let repassword = document.getElementById("RetypePassword").value
    //     let regre = new RegExp('[~!@#$%^&*()_+{}\\[\\]:;,.<>/?-]').exec(repassword)
    //     if( email == "" || email == null || email == undefined ){
    //         document.getElementById("emailErrorMessage").innerHTML = "Email Address Is Required"
    //     }else{
    //         document.getElementById("emailErrorMessage").innerHTML = null
    //     }
        
        
    //     if( password == "" || password == null || password == undefined ){
    //         document.getElementById("passwordErrorMessage").innerHTML = "Password field Is Required"
    //     }else if(reg == null){
    //         document.getElementById("passwordErrorMessage").innerHTML = "value must contain 1 uppercase, 1 lowercase, 1 number, and 1 special character."
    //     }else{
    //         document.getElementById("passwordErrorMessage").innerHTML = null
    //     }
    //     if (password != repassword){
    //         document.getElementById("passwordErrorMessage").innerHTML = "Passwords dont match"
    //     }
    //     if(email != "" && password != "" && reg != null && regre != null && password == repassword){
    //         document.getElementById("form").submit()
    //     }
    // })
    window.addEventListener('load', function() {
            setTimeout(function() {
                document.querySelector('.loadscreen').style.opacity = '0';
                document.querySelector('.loadscreen').style.transition = '1s';
                setTimeout(function() {
                    document.querySelector('.loadscreen').remove();
                }, 1000);
            }, 3000);
    }); 
</script>
</html>