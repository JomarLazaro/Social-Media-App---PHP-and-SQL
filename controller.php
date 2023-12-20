<?php
include("./connection.php");

session_start();

if (isset($_POST['createPost'])) {
    // Retrieve form data
    $title = $_POST['postTitle'];
    $description = $_POST['postContent'];
    $programmingLanguage = $_POST['postLanguage'];
    $userId = $_SESSION['userId'];

    // File handling
    $targetDir = "DataFile/";  // Adjust this based on your file storage directory
    $uploadedFile = basename($_FILES['fileInput']['name']);
    $targetFilePath = $targetDir . $uploadedFile;

    if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $targetFilePath)) {
        // File uploaded successfully, now insert data into the database
        $stmt = $conn->prepare("INSERT INTO posts (title, description, programmingLanguage, filePath, userId, datePost) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssi", $title, $description, $programmingLanguage, $targetFilePath, $userId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("location: home.php");
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error uploading file.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

if (isset($_POST['deletePost'])) {
    $postId = $_POST['postId'];

    $sqlDeleteComments = "DELETE FROM comments WHERE postId = $postId";
    $resultDeleteComments = $conn->query($sqlDeleteComments);

    if ($resultDeleteComments) {
        // Now delete the post
        $sqlDeletePost = "DELETE FROM posts WHERE postId = $postId";
        $resultDeletePost = $conn->query($sqlDeletePost);

        if ($resultDeletePost) {
            header("location: home.php");
        } else {
            echo "Error deleting post: " . $conn->error;
        }
    } else {
        echo "Error deleting comments: " . $conn->error;
    }
}

if (isset($_POST['editPost'])) {
    // Retrieve form data
    $postId = $_POST['postId'];
    $title = $_POST['editPostTitle'];
    $description = $_POST['editPostContent'];
    $programmingLanguage = $_POST['editPostLanguage'];

    // File handling for the updated file, if provided
    if (!empty($_FILES['editFileInput']['name'])) {
        $targetDir = "DataFile/";
        $uploadedFile = basename($_FILES['editFileInput']['name']);
        $targetFilePath = $targetDir . $uploadedFile;

        if (move_uploaded_file($_FILES['editFileInput']['tmp_name'], $targetFilePath)) {
            // Update data including the new file path
            $sql = "UPDATE posts SET title='$title', description='$description', programmingLanguage='$programmingLanguage', filePath='$targetFilePath' WHERE postId=$postId";

            // Print the SQL query for debugging
            echo "SQL Query: $sql";

            // Execute the query
            $result = $conn->query($sql);

            if ($result) {
                header("location: home.php");
            } else {
                echo "Error updating post: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        // Update data without changing the file path
        $sql = "UPDATE posts SET title='$title', description='$description', programmingLanguage='$programmingLanguage' WHERE postId=$postId";

        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            header("location: home.php");
        } else {
            echo "Error updating post: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}

if (isset($_POST['addComment'])) {
    // Retrieve form data
    $postId = $_POST['postId'];
    $content = $_POST['content'];
    $userId = $_SESSION['userId'];

    // Check if the commenter is not the post owner
    $postOwnerQuery = "SELECT userId FROM posts WHERE postId = $postId";
    $postOwnerResult = $conn->query($postOwnerQuery);

    if ($postOwnerResult && $postOwnerRow = $postOwnerResult->fetch_assoc()) {
        $postOwnerId = $postOwnerRow['userId'];

        // Insert the comment into the database
        $sql = "INSERT INTO comments (content, postId, userId, dateCommented)
                VALUES ('$content', $postId, $userId, NOW())";

        $result = $conn->query($sql);

        if ($result && $userId !== $postOwnerId) {
            // Add a notification for the post owner
            $notificationContent = $_SESSION['name'] . ' commented on your post: ' . $content;
            $insertNotificationQuery = "INSERT INTO notifications (content, userId, senderId, notificationDate) 
                                        VALUES ('$notificationContent', $postOwnerId, $userId, NOW())";
            mysqli_query($conn, $insertNotificationQuery);
        }

        // Redirect back to the post page or wherever you want
        header("location: home.php");
    } else {
        echo "Error retrieving post information: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}


if (isset($_POST['updateCredentials'])) {
    $userId = $_SESSION['userId']; // Replace with your actual session variable

    // Retrieve updated credentials from the form
    $newFirstName = $_POST['newFirstName'];
    $newLastName = $_POST['newLastName'];
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];

    // Update user credentials in the database
    $updateSql = "UPDATE users SET firstName = '$newFirstName', lastName = '$newLastName', username = '$newUsername', email = '$newEmail' WHERE userId = $userId";
    $updateResult = $conn->query($updateSql);

    if ($updateResult) {
        // Redirect to the profile page after successful update
        header("Location: profile.php");
    } else {
        // Handle the case when the update fails
        echo "Error updating credentials: " . $conn->error;
    }
}

/// Check if the like button is clicked
if (isset($_POST['likePost'])) {
    // Handle the like action
    handleLike();
}

function handleLike() {
    global $conn;

    $postId = $_POST['postId'];
    $userId = $_SESSION['userId'];

    // Check if the user already liked the post
    $checkLikeQuery = "SELECT * FROM likes WHERE postId = $postId AND userId = $userId";
    $checkLikeResult = mysqli_query($conn, $checkLikeQuery);

    if ($checkLikeResult) {
        if (mysqli_num_rows($checkLikeResult) > 0) {
            // User already liked the post, unlike it
            $unlikeQuery = "DELETE FROM likes WHERE postId = $postId AND userId = $userId";
            $unlikeResult = mysqli_query($conn, $unlikeQuery);

            if ($unlikeResult) {
                $isLiked = false;
            } else {
                $isLiked = true; // Failed to unlike, treat as if liked
            }
        } else {
            // User has not liked the post, like it
            $likeQuery = "INSERT INTO likes (postId, userId, dateLiked) VALUES ($postId, $userId, NOW())";
            $likeResult = mysqli_query($conn, $likeQuery);

            if ($likeResult) {
                $isLiked = true;
                
            } else {
                $isLiked = false; // Failed to like, treat as if not liked
            }
        }

        // Return a JSON response indicating whether the post is liked or not
        echo json_encode(['isLiked' => $isLiked]);
        exit();
    } else {
        echo json_encode(['error' => 'Error checking like status']);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $userId = $_POST['userId'];

    // Insert the message into the database
    $sql = "INSERT INTO chats (message, senderId, receiverId, sendDate) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $message, $userId, $receiverId);

    if ($stmt->execute()) {
        // Return the HTML markup for the new message
        echo '<div>' . $message . '</div>';
    } else {
        echo 'Error sending message';
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];

    // Fetch messages from the database
    $sql = "SELECT * FROM chats WHERE senderId = ? OR receiverId = ? ORDER BY sendDate ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display messages
    while ($row = $result->fetch_assoc()) {
        $message = $row['message'];

        echo '<div>' . $message . '</div>';
    }

    $stmt->close();
}

