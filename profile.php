<?php
include 'connection.php';
session_start();

$sessionUserId = $_SESSION['userId'];

// Fetch user information
$sql = "SELECT * FROM users WHERE userId = $sessionUserId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    die("Error fetching user data: " . $conn->error);
}

?>

<?php
function checkIfLiked($postId, $userId)
{
    global $conn;

    $checkLikeQuery = "SELECT * FROM likes WHERE postId = $postId AND userId = $userId";
    $checkLikeResult = mysqli_query($conn, $checkLikeQuery);

    return (mysqli_num_rows($checkLikeResult) > 0);
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
        WHERE n.userId = $sessionUserId
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

                    <a href="./profile.php" class="nav__link active">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Profile</span>
                    </a>

                    <a href="./message.php" class="nav__link">
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

    <!-- User Information -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Your Profile Information</h5>
                            <button type="button" class="btn btn-outline-info border-0" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#editProfileModal" aria-expanded="false" data-toggle="collapse" data-target="#editProfileModal" aria-expanded="false" aria-controls="editProfileModal"><i class="bx bx-edit"></i></button>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>User Id:</strong> <?php echo $userData['userId']; ?></li>
                            <li class="list-group-item"><strong>Name:</strong> <?php echo $userData['firstName'] . " " . $userData['lastName']; ?></li>
                            <li class="list-group-item"><strong>Username:</strong> <?php echo $userData['username']; ?></li>
                            <li class="list-group-item"><strong>Email:</strong> <?php echo $userData['email']; ?></li>
                            <li class="list-group-item"><strong>Registration Date:</strong> <?php echo $userData['registrationDate']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for updating user credentials -->
                    <form action="controller.php" method="post">
                        <div class="mb-3">
                            <label for="newFirstName" class="form-label">New First Name</label>
                            <input type="text" class="form-control" id="newFirstName" name="newFirstName" value="<?php echo $userData['firstName'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="newLastName" class="form-label">New Last Name</label>
                            <input type="text" class="form-control" id="newLastName" name="newLastName" value="<?php echo $userData['lastName'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="newUsername" class="form-label">New Username</label>
                            <input type="text" class="form-control" id="newUsername" name="newUsername" value="<?php echo $userData['username'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="newEmail" class="form-label">New Email</label>
                            <input type="email" class="form-control" id="newEmail" name="newEmail" value="<?php echo $userData['email'] ?>" required>
                        </div>
                        <!-- Add a hidden input field for userId -->
                        <input type="hidden" name="userId" value="<?php echo $userData['userId']; ?>">
                        <button type="submit" class="btn btn-primary" name="updateCredentials">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Post -->
    <?php
    $sessionUserId = $_SESSION['userId'];
    $sql = "SELECT posts.*, 
            users.*, 
            COUNT(DISTINCT likes.userId) AS likeCount,
            COUNT(comments.commentId) AS commentCount
        FROM posts
        JOIN users ON posts.userId = users.userId
        LEFT JOIN likes ON posts.postId = likes.postId
        LEFT JOIN comments ON posts.postId = comments.postId
        WHERE posts.userId = $sessionUserId
        GROUP BY posts.postId
        ORDER BY posts.datePost DESC";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $serverTime = new DateTime();
        $serverTime->add(new DateInterval('PT7H'));

        while ($post_info = mysqli_fetch_assoc($result)) {
            $postDate = new DateTime($post_info['datePost']);
            $timeDifference = $serverTime->diff($postDate);

            // Format the output based on the time difference
            $output = '';

            if ($timeDifference->y > 0) {
                $output = $timeDifference->y . ' years ago';
            } elseif ($timeDifference->m > 0) {
                $output = $timeDifference->m . ' months ago';
            } elseif ($timeDifference->d > 0) {
                $output = $timeDifference->d . ' days ago';
            } elseif ($timeDifference->h > 0) {
                $output = $timeDifference->h . ' hours ago';
            } elseif ($timeDifference->i > 0) {
                $output = $timeDifference->i . ' minutes ago';
            } else {
                $output = 'Just now';
            }
    ?>
            <div class="container mt-5 mb-5 d-flex justify-content-center align-items-center">
                <div class="card shadow" style="width: 920px;">

                    <div class="card-header d-flex justify-content-between">
                        <div class="text-start" id="user__Name">
                            <button type="button" data-toggle="modal" data-target="#profileModal">
                                <?php echo $post_info['firstName'] . ' ' . $post_info['lastName']; ?>
                            </button>
                        </div>

                        <!-- Profile Button Modal -->

                        <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="profileModalLabel"><?php echo $post_info['firstName'] . ' ' . $post_info['lastName']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group">
                                            <li class="list-group-item"><strong>Name:</strong> <?php echo $post_info['firstName'] . ' ' . $post_info['lastName']; ?></li>
                                            <li class="list-group-item"><strong>Username:</strong> <?php echo $post_info['username'] ?> </li>
                                            <li class="list-group-item"><strong>Email:</strong> <?php echo $post_info['email'] ?> </li>
                                            <li class="list-group-item"><strong>Registration Date:</strong> <?php echo $post_info['registrationDate'] ?> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end"><?php echo $post_info['programmingLanguage']; ?></div>
                    </div>

                    <div class="card-body" style="height: 100%; overflow-y: auto;"> <!-- Set a fixed height, adjust as needed -->
                        <div class="d-flex justify-content-between">
                            <div class="text-start font-weight-bold">
                                <strong><?php echo $post_info['title']; ?></strong>
                            </div>
                            <div class="text-end text-muted small"><?php echo $output; ?></div>
                        </div>

                        <p class="card-text"><?php echo $post_info['description']; ?></p>

                        <div class="modal-footer d-flex justify-content-between">
                            <div class="postButtons d-flex justify-content-end">
                                <button class="btn btn-outline-primary border-0 like-button" data-post-id="<?php echo $post_info['postId']; ?>" onclick="toggleLike(this)">
                                    <?php
                                    // Check if the user already liked the post
                                    $isLiked = checkIfLiked($post_info['postId'], $sessionUserId);

                                    // Display the appropriate icon based on whether the user liked the post or not
                                    if ($isLiked) {
                                        echo '<i class="bx bxs-like"></i>';
                                    } else {
                                        echo '<i class="bx bx-like"></i>';
                                    }
                                    ?>
                                </button>

                                <button class="btn btn-outline-primary border-0 ml-2" id="comment_Button" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#commentsModal<?php echo $post_info['postId']; ?>" aria-expanded="false" aria-controls="commentsCollapse<?php echo $post_info['postId']; ?>" type="button" data-toggle="collapse" data-target="#collapseComment" aria-expanded="false" aria-controls="collapseComment"><i class='bx bx-comment'></i></button>
                            </div>

                            <?php if ($sessionUserId == $post_info['userId']) { ?>
                                <div class="postButtons d-flex justify-content-end download_Button text-end mt-3">
                                    <button class="btn btn-outline-info border-0 bx bx-edit d-flex mt-2" id="like_Button" data-bs-toggle="modal" data-bs-target="#editPostModal<?php echo $post_info['postId']; ?>"></button>
                                    <button class="btn btn-outline-danger border-0 bx bx-trash-alt d-flex mt-2" id="like_Button" data-bs-toggle="modal" data-bs-target="#deletePostModal<?php echo $post_info['postId']; ?>"></button>
                                </div>

                                <!-- Edit Post Modal -->
                                <div class="modal fade" id="editPostModal<?php echo $post_info['postId']; ?>" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Your edit post form goes here -->
                                                <form action="controller.php" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="postId" value="<?php echo $post_info['postId']; ?>">
                                                    <!-- Your form fields for editing post go here -->
                                                    <div class="mb-3">
                                                        <label for="editPostTitle" class="form-label">Title</label>
                                                        <input type="text" class="form-control" id="editPostTitle" name="editPostTitle" value="<?php echo $post_info['title']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editPostContent" class="form-label">Content</label>
                                                        <textarea class="form-control" id="editPostContent" name="editPostContent"><?php echo $post_info['description']; ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editPostLanguage" class="form-label">Programming Language</label>
                                                        <input type="text" class="form-control" id="editPostLanguage" name="editPostLanguage" value="<?php echo $post_info['programmingLanguage']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editFileInput" class="form-label">File</label>
                                                        <input type="file" class="form-control" id="editFileInput" name="editFileInput">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="editPost">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Post Confirmation Modal -->
                                <div class="modal fade" id="deletePostModal<?php echo $post_info['postId']; ?>" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deletePostModalLabel">Delete Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this post?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="controller.php" method="post">
                                                    <input type="hidden" name="postId" value="<?php echo $post_info['postId']; ?>">
                                                    <button type="submit" class="btn btn-danger" name="deletePost">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>

                        <!-- Likes count, Comments count-->
                        <div class="">
                            <h6 class="text-start text-muted small mb-0" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#likeModal<?php echo $post_info['postId']; ?>"><?php echo $post_info['likeCount']; ?> likes</h6>
                            <h6 class="text-start text-muted small mb-0" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#commentsModal<?php echo $post_info['postId']; ?>" aria-expanded="false" aria-controls="commentsCollapse<?php echo $post_info['postId']; ?>">View all <?php echo $post_info['commentCount']; ?> comments</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Like Modal -->
            <div class="modal fade" id="likeModal<?php echo $post_info['postId']; ?>" tabindex="-1" aria-labelledby="likeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="likeModalLabel">Likes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Fetch and display likes for this post -->
                            <?php
                            $postId = $post_info['postId'];
                            $likesQuery = "SELECT users.firstName, users.lastName, likes.dateLiked
                               FROM likes
                               JOIN users ON likes.userId = users.userId
                               WHERE likes.postId = $postId";
                            $likesResult = mysqli_query($conn, $likesQuery);

                            if ($likesResult) {
                                $serverTime = new DateTime();
                                $serverTime->add(new DateInterval('PT7H'));

                                while ($like = mysqli_fetch_assoc($likesResult)) {
                                    $likeDate = new DateTime($like['dateLiked']);
                                    $timeDifference = $serverTime->diff($likeDate);

                                    // Format the output based on the time difference
                                    $output = '';

                                    if ($timeDifference->y > 0) {
                                        $output = $timeDifference->y . ' years ago';
                                    } elseif ($timeDifference->m > 0) {
                                        $output = $timeDifference->m . ' months ago';
                                    } elseif ($timeDifference->d > 0) {
                                        $output = $timeDifference->d . ' days ago';
                                    } elseif ($timeDifference->h > 0) {
                                        $output = $timeDifference->h . ' hours ago';
                                    } elseif ($timeDifference->i > 0) {
                                        $output = $timeDifference->i . ' minutes ago';
                                    } else {
                                        $output = 'Just now';
                                    }

                                    echo '<div class="d-flex justify-content-between"> <p class="text-start" >' . $like['firstName'] . ' ' . $like['lastName'] . '</p>';
                                    echo '<p class="text-end">' . $output . '</p></div>';
                                }
                            } else {
                                echo "Error fetching likes: " . mysqli_error($conn);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Modal -->
            <div class="modal fade" id="commentsModal<?php echo $post_info['postId']; ?>" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentsModalLabel">Comments</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Fetch and display comments for this post -->
                            <?php
                            $postId = $post_info['postId'];
                            $commentsQuery = "SELECT comments.*, users.firstName AS commenterFirstName, users.lastName AS commenterLastName 
                                              FROM comments JOIN users ON comments.userId = users.userId 
                                              WHERE comments.postId = $postId 
                                              ORDER BY `comments`.`dateCommented` DESC";
                            $commentsResult = mysqli_query($conn, $commentsQuery);

                            if ($commentsResult) {
                                $serverTime = new DateTime();
                                $serverTime->add(new DateInterval('PT7H')); // Add 7 hours to the server time

                                while ($comment = mysqli_fetch_assoc($commentsResult)) {
                                    $commentTime = new DateTime($comment['dateCommented']);
                                    $timeDifference = $serverTime->diff($commentTime);

                                    // Format the output based on the time difference
                                    $output = '';

                                    if ($timeDifference->y > 0) {
                                        $output = $timeDifference->y . ' years ago';
                                    } elseif ($timeDifference->m > 0) {
                                        $output = $timeDifference->m . ' months ago';
                                    } elseif ($timeDifference->d > 0) {
                                        $output = $timeDifference->d . ' days ago';
                                    } elseif ($timeDifference->h > 0) {
                                        $output = $timeDifference->h . ' hours ago';
                                    } elseif ($timeDifference->i > 0) {
                                        $output = $timeDifference->i . ' minutes ago';
                                    } else {
                                        $output = 'Just now';
                                    }

                                    // Display comment and time
                                    echo '<div class="comment-container mb-2">';
                                    echo '<p class="comment-text mb-0"><strong>' . $comment['commenterFirstName'] . ' ' . $comment['commenterLastName'] . ':</strong> ' . $comment['content'] . '</p>';
                                    echo '<p class="comment-time text-muted small">' . $output . '</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo "Error fetching comments: " . mysqli_error($conn);
                            }
                            ?>
                        </div>
                        <!-- Comment area -->
                        <div class="modal-footer">
                            <form action="controller.php" method="post" class="w-100">
                                <div class="d-flex align-items-center">
                                    <textarea class="form-control flex-grow-1 mr-2" id="comment" name="content" data-post-id="<?php echo $post_info['postId']; ?>" rows="1" placeholder="Add a comment..."></textarea>
                                    <button type="submit" class="btn btn-primary" name="addComment">
                                        <i class="bx bx-send"></i>
                                    </button>
                                    <input type="hidden" name="postId" value="<?php echo $post_info['postId']; ?>">
                                    <input type="hidden" name="userId" value="<?php echo $sessionUserId; ?>">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<script> alert('No Record Found');</script>";
    }
    ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-2fYq6JtP5u81b4oWd+jIc3u6OAA8K6CV9dLv0vOGOpd1PgeurPoW8Kg4NWEq06iC" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="..." crossorigin="anonymous"></script>

    <!-- MAIN JS -->
    <script src="./main.js"></script>
</body>

</html>