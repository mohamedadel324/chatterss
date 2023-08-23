<?php
include 'db.php';
session_start();

if (isset($_SESSION['login_name'])) {
    $sql = "SELECT * FROM login WHERE id = {$_SESSION['login_name']}";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $name = $user['name'];
    $lastname = $user['lastname'];
    $img = $user['imgname'];
    $id = $user['id'];
    $nowuser = $user['username'];
    $user_2 = !empty($_POST['searching']) ? $conn->real_escape_string($_POST['searching']) : null;
    @$search = $conn->real_escape_string($_POST['search']);
}

$self = '';
$wronguser = '';
$already = '';

if (!empty($search)) {
    if (strtolower($search) == strtolower($nowuser)) {
        $self = "<p style='text-align:center'>You are searching yourself</p>";
    } else if ($search != $nowuser) {
        $sql = "SELECT * FROM login WHERE username = '$search'";
        $result = $conn->query($sql);
        $fetch = $result->fetch_assoc();
        @$searchname = $fetch['name'];
        @$searchimg = $fetch['imgname'];
        @$username = $fetch['username'];
        @$gender = $fetch['gender'];
        if ($gender == '' || $gender == null) {
            $gender = "Not Selected";
        } else {
            $gender = $fetch['gender'];
        }
        if ($fetch == null) {
            $searchimg = '';
            $gender = '';
            $wronguser = "<p style='text-align:center'>Wrong Username</p>";
        }
    }
}

$pending = "pending";

$sql_search = isset($_POST['addfriend']) ? $_POST['addfriend'] : null;

if ($sql_search) {
    $nowuser = $user['username'];
} else {
    $nowuser = null;
    $pending = null;
}

if ($sql_search == $nowuser) {
    echo '';
} else {
    $sql_sel = "SELECT * FROM friends WHERE (user_1 = '$nowuser' AND user_2 = '$sql_search') OR (user_1 = '$sql_search' AND user_2 = '$nowuser')";
    $query = $conn->query($sql_sel);
    $result = $query->fetch_assoc();

    if ($result) {
        echo "You are already added as friends.";
    } else {
        $sql = "INSERT INTO `friends` (user_1, user_2, status) VALUES ('$nowuser', '$sql_search', '$pending')";
        $result = $conn->query($sql);
    }
}

$nowuser = $user['username'];
$sql_s = "SELECT user_1 FROM friends WHERE status = 'pending'";
$re = $conn->query($sql_s);
$zzx = null;

while ($RWO = $re->fetch_assoc()) {
    $zzx = $RWO['user_1'];
}

$accept = !empty($_POST['accept']) ? $conn->real_escape_string($_POST['accept']) : null;
if ($accept === $zzx) {
    if ($nowuser == $accept) {
        echo '';
    } else {
        $updatesql = "UPDATE friends SET status = 'accept' WHERE user_1 = '$accept' AND user_2 = '$nowuser'";
        $conn->query($updatesql);
    }
}

$sql_accepted_friends = "SELECT user_1, user_2 FROM friends WHERE (user_1 = '$nowuser' OR user_2 = '$nowuser') AND status = 'accept'";
$result_accepted_friends = $conn->query($sql_accepted_friends);

$accepted_friends = array();

while ($row = $result_accepted_friends->fetch_assoc()) {
    if ($row['user_1'] == $nowuser) {
        $friend_username = $row['user_2'];
    } else {
        $friend_username = $row['user_1'];
    }

    $sql_accepted_photos = "SELECT * FROM login WHERE username = '$friend_username'";
    $result_accepted_photos = $conn->query($sql_accepted_photos);

    if ($result_accepted_photos->num_rows > 0) {
        $friend_data = $result_accepted_photos->fetch_assoc();
        $friend_imgname = $friend_data['imgname'];
        $accepted_friends[$friend_username] = $friend_imgname;
    }
}
?>  

<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo "hello $name $lastname"; ?>
    </title>
    <link rel="stylesheet" href="welcome.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<body>
    <div id="list" style="opacity:0;height:0px; z-index:2">
        <div style="display:none; opacity: 0;" class="items">
            <a class="logout" href="logout.php">logout</a>
        </div>
        <button id='closebtn'>
            close
        </button>
        <!-- <label for="toggleSwitch">Change Color</label>
        <div class="switchparent">
            
            <label class="switch">
                <input type="checkbox" id="toggleSwitch" checked>   
                <span class="slider round"></span>
            </label>
        </div> -->
    </div>
    <div class='welcome_container'>
        <!-- <p style="order:1"></p> Hello <?php echo $name; ?> <?php echo $lastname; ?></p> -->
        <!-- <h1 style="order:5;">Chatters</h1> -->
        <div style="cursor:pointer; order:1;" class='control' id='profile'>
            <a href="profile.php">
                <img class="Profile_Img" src="./<?php echo $img; ?>" />
            </a>
        </div>
        <img style='width:50px; height:50px; order:0; cursor:pointer' class="imgmenu" src="menu.png" alt="">
        <div class="friends_parent">
            <button id="btn" style="border:none;cursor:pointer;">
                <img class="friends" src="friends.png" alt="">
            </button>
            <form style="display:none;" class="frndform" id="frm" method="POST">
                <label for="accept">Enter A Freind Sent To You Freind Request</label>
                <input name="accept" type="text" id="accept" placeholder="Enter A Freind Sent To You Freind Request">
                <input id="accept_1" type="Submit" value="Accept">
                <label id="forsearch" for="search">Enter Username Please</label>
                <input id="search" name="search" type="text" placeholder='Search For Freinds'>
                <btn class="frndclose">Close</btn>
            </form>

        </div>
    </div>
    <div>
        <?php echo @$wronguser ?>
        <?php echo @$self ?>
    </div>
    <?php if ($search == "" || $search == null) {
        echo "";
    } else { ?>
        <div class="FreindSearch">
            <?php
            if (!empty($fetch) == null) {
                echo '';
            } else {
                ?>
                <img class="searchimg" src="./<?php echo $searchimg; ?>" alt="">
            <?php } ?>
            <div class="infoo">
                <p>
                    <?php if (@$fetch == null) {
                        echo '';
                    } else
                        echo "Name: ";
                    echo @$searchname; ?>
                    <?php @$lastname = $fetch['lastname'];
                    echo @$lastname; ?>
                </p>
                <p>
                    <?php if ($username == "" || @$fetch == null) {
                        echo '';
                    } else {
                        echo "Username: ";
                        echo @$username;
                    } ?>
                </p>
                <?php if (!empty($fetch) == null) {
                    echo '';
                } else { ?>
                    <p>
                        <?php echo "gender: ";
                        echo $gender; ?>
                    </p>
                <?php } ?>
                <?php if (!empty($fetch) != null) {
                    ?>
                    <form method="POST">
                        <!-- <label for="id">Please Enter The Username again</label> -->
                        <input placeholder="Username Of Your Freind" metho="post" id="id" type="text" name='addfriend'>
                        <button class="subb" type="submit">Add freind</button>
                    </form>
                <?php } ?>
                <?php echo !empty($already) ?>
                <button class="closebn">Close</button>
            </div>
            <p>
                <?php if (@$fetch == null) {
                    echo "";
                } ?>
            </p>
        </div>
    <?php } ?>
    <div class="friendsparent">
        <h2 class="h2">Your Friends</h2>


        <?php $firstUser = null; ?>

        <?php foreach ($accepted_friends as $friend_username => $friend_imgname): ?>
            
            
            <?php
                $sql_friend_info = "SELECT * FROM `login` WHERE username = '$friend_username'";
                $result_friend_info = $conn->query($sql_friend_info);
                $friend_info = $result_friend_info->fetch_assoc();
            ?>

            <?php !$firstUser ? $firstUser = $friend_info['id'] : null ?>
            <button class="chat" data-id="<?php echo $friend_info['id']; ?>">
            
                <div class="freinds">

                    <?php if (!empty($friend_imgname)): ?>
                        <img class="friendimg" src="<?php echo $friend_imgname; ?>" alt="Profile Image">
                    <?php endif; ?>

                    <div class="info">
                        <p class="name">Name:
                            <?php echo $friend_info['name']; ?>
                        </p>
                    </div>
                </div>

            </button>

        <?php endforeach; ?>
    </div>
    <div id="ct" class="chat_container" >
        <p style="display: none;" id="bck"class="pback">Back</p>
        <div id="chat">
            
        </div>
        <div class="send">
            <input type="text" id="msg" placeholder="Enter A Message Here">
            <button type="button" id="sendBtn">
                Send
            </button>
        </div>
    </div>
    <script>
        try {
            document.querySelector('.closebn').addEventListener('click', function() {
            document.querySelector('.FreindSearch').remove();
        })
        } catch (error) {
            console.log('')
        }
        let imgmenu = document.querySelector('.imgmenu');
        let search = document.getElementById('search');
        let items = document.querySelector('.items');
        let list = document.getElementById('list');
        let closebtn = document.getElementById('closebtn');
        imgmenu.addEventListener('click', function () {
            list.style.cssText = "position:absolute;height: 100%; width:300px; transition:1s; background-color:#1d1d1f; z-index:2"
            var x = window.matchMedia("(max-width: 700px)"); 
            if (x.matches){
                list.style.cssText = "position:absolute;height: 100%; width:100%; transition:1s; background-color:#1d1d1f; z-index:2"
            }
            search.style.cssText = "display:block;"
            items.style.cssText = "display:block;"
            closebtn.style.cssText = "display:block;"
        });
        closebtn.onclick = function () {
            list.style.cssText = "position:absolute;opacity:0;height:0px;width:0px; transition:1s;"
            // search.style.cssText = "display:none;"
            items.style.cssText = "display:none;"
            closebtn.style.cssText = "display:none;"
        }
        // var toggleSwitch = document.getElementById('toggleSwitch');
        // var navbar =document.querySelector('.welcome_container');
        // toggleSwitch.addEventListener('change', function() {
        //     if (this.checked) {
        //     document.body.style.cssText = 'background: white;color:black;';
        //     navbar.style.cssText = "background: white; color:black"
        //     } else {
        //     document.body.style.cssText = 'background: #222831;color:white;';
        //     navbar.style.cssText = "background: #222831; color:white"
        //     }
        // });

        document.getElementById('btn').addEventListener('click', function () {
            document.getElementById('frm').style.cssText = 'position: absolute;display:flex;flex-direction: column;align-items: center;right: 4%;height: 100vh;border: solid 1px;border-bottom: none;border-right: none;border-top: none;z-index:10;'
            var x = window.matchMedia("(max-width: 700px)"); 
            if (x.matches) {
                document.getElementById('frm').style.cssText = 'width:100%;background:#1d1d1f;position: absolute;display:flex;flex-direction: column;align-items: center;right: 0%;height: 100vh;border: solid 1px;border-bottom: none;border-right: none;border-top: none;z-index:10;'
            }
        })
        document.querySelector('.frndclose').addEventListener('click', function () {
            document.getElementById('frm').style.cssText = 'display:none'
        })
        const inputField = document.getElementById('msg');
        const submitButton = document.getElementById('sendBtn');

    // Listen for keypress event on the input field
        inputField.addEventListener('keypress', function(event) {
      // Check if the enter key was pressed (keyCode 13)
        if (event.keyCode === 13) {
        // Trigger the click event on the submit button
        submitButton.click();
        }
    });

    // Add a click event listener to the submit button
    submitButton.addEventListener('click', function() {
      // Perform the desired action when the button is clicked
        console.log('Button clicked!');
    });
    </script>
</body>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
    import { getDatabase, push, get, ref, onChildAdded } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-database.js";

    const firebaseConfig = {
        apiKey: "AIzaSyAuW7liubBSyvQimsXYomQ5mSv-p9VvxUM",
        authDomain: "chatters-534ac.firebaseapp.com",
        databaseURL: "https://chatters-534ac-default-rtdb.firebaseio.com",
        projectId: "chatters-534ac",
        storageBucket: "chatters-534ac.appspot.com",
        messagingSenderId: "700588849272",
        appId: "1:700588849272:web:f8ae004aa6816061c9558d",
        measurementId: "G-VGLRD0EDSE"
    };

    const app = initializeApp(firebaseConfig);

    const db = getDatabase(app);

    let userId = "<?php echo $id; ?>"

    let firstUser = "<?php echo $firstUser ?>"
    let username = "<?php echo $name; echo ""; echo $lastname ?>"
    let userChatname = "<?php echo $friend_info['name']; ?>";
    console.log(userChatname);  
    let userChatId = firstUser;
    let messages = [];

    document.querySelectorAll("button[data-id]").forEach((el)=>{
            
        el.onclick = function () {
            userChatId = el.getAttribute("data-id")
            
            document.getElementById("chat").innerHTML = null;

            messages.forEach(message => {
                var from = message['from'];
                var to = message['to'];
                var msg = message['msg'];
                if(from == userId && to == userChatId || from == userChatId && to == userId){ // group chat condition
                    if(from == userId){
                        // me
                        document.getElementById("chat").innerHTML += `
                        <div class="me_msg">
                            <div class="me"></div>
                            <div class="msg">${msg}</div>
                        </div>
                        `
                    }else{
                        // not me
                        document.getElementById("chat").innerHTML += `
                        <div class="Reciever_msg">
                            <div class="Reciever"></div>
                            <div class="msg">${msg}</div>
                        </div>
                        `
                    }
                    
                }
            });
            document.getElementById("ct").scrollTop = document.getElementById("chat").scrollHeight;
        }

    })

    
    document.getElementById("sendBtn").addEventListener("click", (e) => {
    const message = document.getElementById("msg").value;

    if (message && message.trim() !== "") {
        push(ref(db, `messages`), {
            from: userId,
            to: userChatId,
            msg: message
        }).then(() => {
            document.getElementById("msg").value = null;
            document.getElementById("ct").scrollTop = document.getElementById("chat").scrollHeight;
        });
    }
});


    document.querySelectorAll(`button[data-id="${userChatId}"]`)[0].click();

    onChildAdded(ref(db, `messages`), function(e){

        var from = e.val()['from'];
        var to = e.val()['to'];
        var msg = e.val()['msg'];
        messages.push(e.val())

        if(from == userId && to == userChatId || from == userChatId && to == userId){ // group chat condition
            
            if(from == userId){
                // me
                document.getElementById("chat").innerHTML += `
                <div class="me_msg">
                    <div class="me"></div>
                    <div class="msg">${msg}</div>
                </div>
                `
            }else{
                // not me
                document.getElementById("chat").innerHTML += `
                <div class="Reciever_msg">
                    <div class="Reciever"></div>
                    <div class="msg">${msg}</div>
                </div>
                `
            }
        }
        document.getElementById('sendBtn').addEventListener('click', function(){
            document.getElementById('chat').scrollHeight;
        })
        document.getElementById("ct").scrollTop = document.getElementById("chat").scrollHeight;
    })
    
    var x = window.matchMedia("(max-width: 700px)"); 
    if (x.matches) {
        let chatt = document.querySelector('.chat_container');
        let friend = document.querySelector('.friendsparent');
        friend.style.cssText = "width:100%;";
        chatt.style.cssText = "display:none;position: absolute;top: 59px;left: -1px;width: 100%;height: 61vh;background-color: #1d1d1f;color: black;overflow-y: scroll;"
        const boxes = document.querySelectorAll('.freinds');
        boxes.forEach(box => {
            box.style.width = '53vh';
        });
        const chats =document.querySelectorAll('.chat');
        chats.forEach(chat => {
            chat.addEventListener('click', function() {
                friend.style.cssText = 'display:none'
                var z = window.matchMedia("(max-height: 800px) and (min-height:700)");
                if (z.matches) {
                    chatt.style.cssText = "display:block;position: absolute;top: 59px;left: -1px;width: 100%;height: 47vh;background-color: #1d1d1f;color: black;overflow-y: scroll;"
                }
                chatt.style.cssText = "display:block;position: absolute;top: 59px;left: -1px;width: 100%;height: 53vh;background-color: #1d1d1f;color: black;overflow-y: scroll;"
                document.querySelector('.send').style.cssText = 'top: 490px;left: 2px;background-color: #1d1d1f;width: 100%;height: 50px;position: fixed;bottom: 0;';
                document.querySelector('#msg').style.cssText = "margin-top: 10px;width: 60%;border-radius: 10px;height: 30px;border: none;font-family: 'Carter One', cursive";
                document.querySelector('#sendBtn').style.cssText = "width: 17vh;height: 33px;border-radius: 10px;border: none;background-color: #fa8050;font-family: 'Carter One', cursive;font-size: 18px;cursor: pointer";
                var x = window.matchMedia("(max-width: 600px)"); 
                if (x.matches) {
                    document.getElementById('bck').style.cssText = "display:block;position: fixed;color: #000000;left: 9px;top: 70px;background: white;font-size: 30px;border-radius: 30%;"
                }document.getElementById('bck').addEventListener('click', function() {
                    friend.style.cssText = 'display:block'
                    document.querySelector('.chat_container').style.cssText = "display:none;";
                })
            })
        });
    }
</script>
</html> 