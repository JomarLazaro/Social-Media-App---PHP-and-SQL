<?php
include 'connection.php';

// Assuming you have a session variable for the logged-in user
session_start();
$userId = $_SESSION['userId'];

// Fetch user information
$sql = "SELECT * FROM users WHERE userId = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    die("Error fetching user data: " . $conn->error);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <!-- ===== Bootstrap CSS ===== -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="./styles.css">

    <title>CODIFY | Home</title>

    <link rel="icon" href="./assets/img/title-logo.png" type="image/x-icon">

    <style>
        body {
            background-color: #f4f7f6;
            margin-top: 20px;
        }

        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
        }

        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7
        }

        .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        }

        .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s
        }

        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .people-list .chat-list li.active {
            background: #efefef
        }

        .people-list .chat-list li .name {
            font-size: 15px
        }

        .people-list .chat-list img {
            width: 45px;
            border-radius: 50%
        }

        .people-list img {
            float: left;
            border-radius: 50%
        }

        .people-list .about {
            float: left;
            padding-left: 8px
        }

        .people-list .status {
            color: #999;
            font-size: 13px
        }

        .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6
        }

        .chat .chat-header img {
            float: left;
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff
        }

        .chat .chat-history ul {
            padding: 0
        }

        .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        .chat .chat-history ul li:last-child {
            margin-bottom: 0px
        }

        .chat .chat-history .message-data {
            margin-bottom: 15px
        }

        .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px
        }

        .chat .chat-history .message {
            color: #444;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }

        .chat .chat-history .message:after {
            bottom: 100%;
            left: 7%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #fff;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .my-message {
            background: #1d8ecd;
            width: 400px;

        }

        .chat .chat-history .my-message:after {
            bottom: 100%;
            left: 30px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #efefef;
            border-width: 10px;
            margin-left: -10px
        }

        .chat .chat-history .other-message {
            background: #e8f1f3;
            text-align: right;
            width: 400px;
        }

        .chat .chat-history .other-message:after {
            border-bottom-color: #e8f1f3;
            left: 93%
        }

        .chat .chat-message {
            padding: 20px
        }

        .online,
        .offline,
        .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }

        .online {
            color: #86c541
        }

        .offline {
            color: #e47297
        }

        .me {
            color: #1d8ecd
        }

        .float-right {
            float: right
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0
        }

        @media only screen and (max-width: 767px) {
            .chat-app .people-list {
                height: 465px;
                width: 100%;
                overflow-x: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .chat-app .people-list.open {
                left: 0
            }

            .chat-app .chat {
                margin: 0
            }

            .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .chat-app .chat-history {
                height: 300px;
                overflow-x: auto
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .chat-app .chat-list {
                height: 480px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: calc(100vh - 350px);
                overflow-x: auto
            }
        }
    </style>

</head>

<body id="body-pd">
    <?php include("./modal.php"); ?>

    <!-- Header -->
    <header class="header" id="header">
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>

        <form class="form-inline">
            <div class="form-outline">
                <input type="search" id="form1" class="form-control form-control-sm" placeholder="Type query" aria-label="Search" style="width: 300px; text-align: left;">
                <button class="btn btn-outline-dark" type="button">
                    <i class='bx bx-search'></i>
                </button>
            </div>
        </form>

        <?php
        $userId = $_SESSION['userId'];

        // Fetch notifications for the given user
        $sql = "SELECT n.notificationId, n.content, n.senderId, n.notificationDate, u.username AS senderUsername
        FROM notifications n
        INNER JOIN users u ON n.senderId = u.userId
        WHERE n.userId = $userId
        ORDER BY n.notificationDate DESC";

        $result = $conn->query($sql);

        // Display notifications
        if ($result->num_rows > 0) {
            echo '<div class="notification">';
            echo '<a href="#" class="notification" id="notification-link" data-toggle="dropdown">';
            echo '<i class="bx bx-bell nav__icon"></i>';
            echo '<span class=""></span>';
            echo '</a>';
            echo '<div class="notification-dropdown dropdown-menu" id="notification-dropdown">';
            echo '<h5 class="header-notification pl-3">Notifications</h5>';
            echo '<hr>';

            while ($row = $result->fetch_assoc()) {
                $notificationId = $row['notificationId'];
                $content = $row['content'];
                $senderUser = $row['senderUsername'];

                echo '<a href="#" class="dropdown-item">' . $content . ' by ' . $senderUser . '</a>';
            }

            echo '</div>';
            echo '</div>';
        } else {
            // If there are no notifications
            echo 'No notifications';
        }

        ?>
    </header>

    <!-- Side Navigation Bar -->
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <!-- Brand Icon -->
                <a href="" class="nav__logo">
                    <i class='bx bx-layer nav__logo-icon'></i>
                    <span class="nav__logo-name">CODIFY</span>
                </a>

                <!-- Side Bar Menu -->
                <div class="nav__list">
                    <a href="./home.php" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>

                    <a href="./profile.php" class="nav__link">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>

                    <a href="./message.php" class="nav__link active">
                        <i class='bx bx-message-square-detail nav__icon'></i>
                        <span class="nav__name">Messages</span>
                    </a>

                    <a href="./learningMaterial.php" class="nav__link">
                        <i class='bx bx-book nav__icon'></i>
                        <span class="nav__name">Learning material</span>
                    </a>
                </div>
            </div>

            <!-- Logout Icon -->
            <a href="logout.php" class="nav__link">
                <i class='bx bx-log-out nav__icon'></i>
                <span class="nav__name">Log Out</span>
            </a>
        </nav>
    </div>

    <!-- MAIN Components -->

    <!-- Spacing -->
    <div class="p-5"></div>

    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search..." id="userSearch">
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            <?php
                            $excludeUserId = $_SESSION['userId'];
                            $usersQuery = "SELECT * FROM users WHERE userId != $excludeUserId";
                            $usersResult = $conn->query($usersQuery);

                            if ($usersResult->num_rows > 0) {
                                while ($userRow = $usersResult->fetch_assoc()) {
                                    $users = $userRow['firstName'] . ' ' . $userRow['lastName'];
                                    $userId = $userRow['userId'];

                                    // Display the user in the list with a class for filtering
                                    echo '<li class="clearfix user-item" data-user-id="' . $userId . '">';
                                    echo '<div class="about">';
                                    echo '<div class="name">' . $users . '</div>';
                                    echo '</div>';
                                    echo '</li>';
                                }
                            } else {
                                echo '<li class="clearfix">';
                                echo '<div class="about">';
                                echo '<div class="name">No other users</div>';
                                echo '</div>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="chat-about">
                                        <h6 class=""><strong>Receiver</strong></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="chat-history">
                            <ul class="m-b-0" id="chatMessages">
                                <?php
                                // Fetch chat messages from the database
                                $receiverUserId = isset($_GET['receiverId']) ? $_GET['receiverId'] : null; // Set the receiver user ID (replace with your logic to get the receiver ID)
                                $sessionUserId = $_SESSION['userId'];

                                // Ensure that both senderId and receiverId have valid values before including them in the query
                                if ($sessionUserId !== null && $receiverUserId !== null) {
                                    $chatQuery = "SELECT * FROM chats 
                                     WHERE (senderId = $sessionUserId AND receiverId = $receiverUserId) 
                                        OR (senderId = $receiverUserId AND receiverId = $sessionUserId) 
                                     ORDER BY sendDate ASC";

                                    $chatResult = $conn->query($chatQuery);

                                    if ($chatResult) {
                                        while ($chatRow = $chatResult->fetch_assoc()) {
                                            $messageSender = $chatRow['senderId'] == $sessionUserId ? 'my-message' : 'other-message';
                                            $messageContent = $chatRow['message'];
                                            $timestamp = $chatRow['sendDate'];

                                            echo '<li class="clearfix">';
                                            echo '<div class="message-data">';
                                            echo '<span class="message-data-time">' . $timestamp . '</span>';
                                            echo '</div>';
                                            echo '<div class="message ' . $messageSender . ' float-right">' . $messageContent . '</div>';
                                            echo '</li>';
                                        }
                                    } else {
                                        // Handle query execution error
                                        echo "Error executing chat query: " . $conn->error;
                                    }
                                } else {
                                    // Handle case where either $sessionUserId or $receiverUserId is not set
                                    echo "Invalid user IDs";
                                }
                                ?>
                            </ul>
                        </div>

                        <div class="chat-message clearfix">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-send"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter text here..." id="chatInput">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-2fYq6JtP5u81b4oWd+jIc3u6OAA8K6CV9dLv0vOGOpd1PgeurPoW8Kg4NWEq06iC" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="..." crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-aJqLOjENzC5u+bPj87iVc0flJeXGS5r5h18OGoF5qWXL1M/j3p5wr5L4GxnWwwEA" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $(".user-item").on("click", function() {
                var receiverUserId = $(this).data("user-id");
                var receiverName = $(this).find(".name").text();
                $(".chat-about h6 strong").text(receiverName);

                // Update the chat messages for the selected user
                updateChatMessages(receiverUserId);
            });

            function updateChatMessages(receiverUserId) {
                var sessionUserId = <?php echo $_SESSION['userId']; ?>;
                var chatMessagesContainer = $('#chatMessages');

                if (receiverUserId) { // Ensure receiverUserId is set
                    $.ajax({
                        url: 'controller.php',
                        method: 'POST',
                        data: {
                            action: 'fetch_chat_messages',
                            receiverUserId: receiverUserId
                        },
                        success: function(response) {
                            chatMessagesContainer.html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + error);
                        }
                    });
                } else {
                    console.error("Invalid receiverUserId");
                }
            }

            // Use jQuery to handle keypress event in the chat input
            $('#chatInput').keypress(function(e) {
                if (e.which == 13) { // Enter key pressed
                    var message = $(this).val().trim();
                    if (message !== '') {
                        var receiverUserId = $(".user-item.active").data("user-id"); // Update with the correct logic

                        if (receiverUserId) { // Ensure receiverUserId is set
                            $.ajax({
                                url: 'controller.php',
                                method: 'POST',
                                data: {
                                    action: 'send_chat_message',
                                    receiverUserId: receiverUserId,
                                    message: message
                                },
                                success: function(response) {
                                    console.log(response); // Log the response for testing
                                    updateChatMessages(receiverUserId);
                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX Error: " + error);
                                }
                            });
                        } else {
                            console.error("Invalid receiverUserId");
                        }

                        $(this).val('');
                    }
                }
            });

            // Initial update of chat messages (you may want to update it based on the initial selected user)
            var initialReceiverUserId = <?php echo $receiverUserId; ?>;
            if (initialReceiverUserId) {
                updateChatMessages(initialReceiverUserId);
            }
        });
    </script>

    <!-- MAIN JS -->
    <script src="./main.js"></script>

</body>

</html>