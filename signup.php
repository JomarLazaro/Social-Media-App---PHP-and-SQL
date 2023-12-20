<?php
include('connection.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate input (you can add more validation as needed)
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $message = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $message = "Password and Confirm Password do not match.";
    } else {
        $email = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "User already exists. Please choose a different email.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $insertSql = "INSERT INTO users (firstName, lastName, username, email, password, registrationDate) VALUES (?, ?, ?, ?, ?, NOW())";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("sssss", $firstname, $lastname, $username, $email, $hashedPassword);

            if ($insertStmt->execute()) {
                // Redirect to the login page after successful registration
                header("Location: login.php");
                exit();
            } else {
                $message = "Error during registration: " . $insertStmt->error;
            }

            $insertStmt->close();
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Codify | Signup</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="./assets/img/title-logo.png" type="image/x-icon">
</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <h2 class="Inactive underlineHover"><a href="./login.php"> Sign up </a></h2>
    <h2 class="active"><a href="./signup.php"></a>Sign Up </h2>
    <p><?php echo $message; ?></p>

    <!-- Signup Form -->
    <form method="post">
        <input type="text" id="firstname" class="fadeIn second" name="firstname" placeholder="First Name">
        <input type="text" id="lastname" class="fadeIn second" name="lastname" placeholder="Last Name">
        <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
        <input type="email" id="email" class="fadeIn third" name="email" placeholder="Email">
        <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
        <input type="password" id="confirmPassword" class="fadeIn third" name="confirmPassword" placeholder="Confirm Password">
        <input type="submit" class="fadeIn fourth" value="Sign Up">
    </form>
  </div>
</div>
</body>
</html>
