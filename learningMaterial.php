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

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="./styles.css">

    <title>CODIFY | Home</title>

    <link rel="icon" href="./assets/img/title-logo.png" type="image/x-icon">


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

                    <a href="./message.php" class="nav__link">
                        <i class='bx bx-message-square-detail nav__icon'></i>
                        <span class="nav__name">Messages</span>
                    </a>

                    <a href="./learningMaterial.php" class="nav__link active">
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
    <!--===== Learning Material  =====-->

    <div class="learningMaterials">
        <section class="learning__Materials">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-javaScript">
                            <h1 class="learning_Font">Java<br>script</h1>
                            <div class="card-back">
                                <a class="learnMore" href="#">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-go">
                            <h1 class="learning_Font">Go</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://go.dev/ref/spec">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-java">
                            <h1 class="learning_Font">Java</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://www3.ntu.edu.sg/home/ehchua/programming/java/JavaReference.html">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-kotlin">
                            <h1 class="learning_Font">Kotlin</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://kotlinlang.org/docs/home.html">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-php">
                            <h1 class="learning_Font">PHP</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://www.php.net/manual/en/langref.php">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-c_sharp">
                            <h1 class="learning_Font">C#</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://learn.microsoft.com/en-us/dotnet/csharp/language-reference/">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-swift">
                            <h1 class="learning_Font">Swift</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://www.swift.org/getting-started/">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-ruby">
                            <h1 class="learning_Font">Ruby</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://rubyreferences.github.io/rubyref/">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-c">
                            <h1 class="learning_Font">C</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://en.cppreference.com/w/c">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-sql">
                            <h1 class="learning_Font">SQL</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://www.sqltutorial.org/sql-reference/">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-noSql">
                            <h1 class="learning_Font">NoSQL</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://www.mongodb.com/nosql-explained">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card" id="module">
                        <div class="cover item-rust">
                            <h1 class="learning_Font">Rust</h1>
                            <div class="card-back">
                                <a class="learnMore" href="https://doc.rust-lang.org/stable/reference/">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>

    <!-- Spacing -->
    <div class="p-5"></div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-2fYq6JtP5u81b4oWd+jIc3u6OAA8K6CV9dLv0vOGOpd1PgeurPoW8Kg4NWEq06iC" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="..." crossorigin="anonymous"></script>

    <!-- MAIN JS -->
    <script src="./main.js"></script>
</body>

</html>