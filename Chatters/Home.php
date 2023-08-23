<?php
    include 'login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatters</title>
    <link rel="stylesheet" href="Home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="loadscreen">
        <div class="cont">
            <div>
                Chatters
            </div>
        </div>
    </div>
    
    <div class="h1">
        <a class="sign" href="signup.php">Sign Up</a>
        <h1>
            Chatters
        </h1>
        <p class="date">&copy;<?php echo date("20y");?></p>
    </div>
    <div class="flex">
    <div class="form">
        <div class="h11">
            <h1>
            Login
            </h1>
        </div>
        
        <form class="Father" id="form" method = "POST">
            <div class="EmailFather">
                <label class="emaillabel" for="Email">Email</label>
                <input id="Email" type="Email" name = "email">
                <input style="display:none" type="text" name = 'name'>
                <span id="emailErrorMessage" style = "font-size: 13px; color:red; position:absolute"></span>
            </div>
            <br>
            <div class="PassFather">
                <label class="passlabel" for="Password">Password</label>
                <input id="Password" type="password" name = "password">
                <span id="passwordErrorMessage" style = "font-size: 13px; color:red; position:absolute"></span>
            </div>
            <span class="err"><?php echo @$err?></span>
            <input class="Sumbit" type="submit" value="Log In">
        </form>
    </div></div>
</body>
<script>
    document.getElementById("form").addEventListener("submit", (e) => {
        e.preventDefault();
        let email = document.getElementById("Email").value
        let password = document.getElementById("Password").value
        let reg = new RegExp('[~!@#$%^&*()_+{}\\[\\]:;,.<>/?-]').exec(password)
        if( email == "" || email == null || email == undefined ){
            document.getElementById("emailErrorMessage").innerHTML = "Email Address Is Required"
        }else{
            document.getElementById("emailErrorMessage").innerHTML = null
        }
        
        
        if( password == "" || password == null || password == undefined ){
            document.getElementById("passwordErrorMessage").innerHTML = "Password field Is Required"
        }else if(reg == null){
            document.getElementById("passwordErrorMessage").innerHTML = "value must contain 1 uppercase, 1 lowercase, 1 number, and 1 special character."
        }else{
            document.getElementById("passwordErrorMessage").innerHTML = null
        }
        if(email != "" && password != "" && reg != null){
            document.getElementById("form").submit()
        }
    
    })
    window.addEventListener('load', function() {
    setTimeout(function() {
        document.querySelector('.loadscreen').style.opacity = '0';
        document.querySelector('.loadscreen').style.transition = '1s';
        setTimeout(function() {
            document.querySelector('.loadscreen').remove();
        },1000)
    }, 3500);
});

    
</script>
</html>
