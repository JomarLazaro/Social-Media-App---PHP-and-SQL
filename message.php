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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="..." crossorigin="anonymous">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI/tZ1a9lGqZMsU8tFzE3fU5zjkslOS2TfDw9NA=" crossorigin="anonymous"></script>


    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="./styles.css">

    <title>CODIFY | Home</title>

    <link rel="icon" href="./assets/img/title-logo.png" type="image/x-icon">

    <style>
        @import url(http://fonts.googleapis.com/css?family=Roboto);

        * {
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);
        }

        .error-template {
            padding: 40px 15px;
            text-align: center;
        }

        .error-actions {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .error-actions .btn {
            margin-right: 10px;
        }

        .message-box h1 {
            color: #252932;
            font-size: 98px;
            font-weight: 700;
            line-height: 98px;
            text-shadow: rgba(61, 61, 61, 0.3) 1px 1px, rgba(61, 61, 61, 0.2) 2px 2px, rgba(61, 61, 61, 0.3) 3px 3px;
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
            echo '<i class="bx bx-bell nof__icon"></i>';
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
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="error-template">
                <h1>
                    :) Oops!</h1>
                <h2>
                    Temporarily down for maintenance</h2>
                <h1>
                    We’ll be back soon!</h1>
                <div>
                    <p>
                        Sorry for the inconvenience but we’re performing some maintenance at the moment.
                        we’ll be back online shortly!</p>
                    <p>
                        — The Team</p>
                </div>
                <div class="error-actions">
                    <a href="home.php" style="margin-top: 10px;" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-home">
                    </span>Take Me Home </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <svg class="svg-box" width="380px" height="500px" viewbox="0 0 837 1045" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z" id="Polygon-1" stroke="#3bafda" stroke-width="6" sketch:type="MSShapeGroup"></path>
                        <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z" id="Polygon-2" stroke="#7266ba" stroke-width="6" sketch:type="MSShapeGroup"></path>
                        <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z" id="Polygon-3" stroke="#f76397" stroke-width="6" sketch:type="MSShapeGroup"></path>
                        <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z" id="Polygon-4" stroke="#00b19d" stroke-width="6" sketch:type="MSShapeGroup"></path>
                        <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z" id="Polygon-5" stroke="#ffaa00" stroke-width="6" sketch:type="MSShapeGroup"></path>
                    </g>
                </svg>
        </div>
    </div>
</div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-2fYq6JtP5u81b4oWd+jIc3u6OAA8K6CV9dLv0vOGOpd1PgeurPoW8Kg4NWEq06iC" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="..." crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-aJqLOjENzC5u+bPj87iVc0flJeXGS5r5h18OGoF5qWXL1M/j3p5wr5L4GxnWwwEA" crossorigin="anonymous"></script>

    <!-- MAIN JS -->
    <script src="./main.js"></script>

</body>

</html>