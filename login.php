<?php
include('connection.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['login'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "Email and password are required.";
    } else {
        $email = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['userId'] = $row['userId'];
                $_SESSION['name'] = $row['firstName'] . ' ' . $row['lastName'];
                header("Location: home.php");
                exit();
            } else {
                $message = "Incorrect password";
            }
        } else {
            $message = "User not found";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" ></html>
<head>
  <meta charset="UTF-8">
  <title>Codify | Login</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="icon" href="./assets/img/title-logo.png" type="image/x-icon">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Sign In </h2>
    <h2 class="inactive underlineHover"><a href="./signup.php"> Sign Up </a></h2>
    <p><?php echo $message; ?></p>

    <!-- Login Form -->
    <form method="post" action="">
      <input type="email" id="login" class="fadeIn second" name="login" placeholder="email">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="#">Forgot Password?</a>
    </div>

  </div>
</div>
<!-- partial -->
  
</body>
</html>
