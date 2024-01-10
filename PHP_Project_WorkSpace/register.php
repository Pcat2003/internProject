<?php
include 'connectDB.php';
if(isset($_SESSION['REGISTER_UNSUCCESS'])){
    echo $_SESSION['REGISTER_UNSUCCESS'];
    unset($_SESSION['REGISTER_UNSUCCESS']);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $re_password = $_POST['re-enter_password'];
    $sql = "SELECT * FROM users WHERE Username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION["REGISTER_UNSUCCESS"] = "Username already exists";
        header("Location: register.php");
        exit();
    }else
    if ($password != $re_password) {
        $_SESSION["REGISTER_UNSUCCESS"] = "Passwords do not match";
        header("Location: register.php");
        exit();
    }
    else{
    $sql = "INSERT INTO users (Username, Passwords) VALUES ('$username', '$password')";
    if ($conn->query($sql) == true) {
        $_SESSION["REGISTER_SUCCESS"] = "REGISTER SUCCESSFUL";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION["REGISTER_UNSUCCESS"] = "REGISTER FAILED";
        header("Location: register.php");
        exit();
    }
    }
}
$conn->close();
?>

<!-- HTML_CODE -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
</head>
<body>
    <a href="login.php" style=" font-family: Arial, Helvetica, sans-serif">Login</a>
    <form action="register.php" method="post">
        <h2>Register</h2>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" placeholder="Enter username" style="height: 30px; width: 300px;" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Enter password" style="height: 30px; width: 300px;" required><br>
        <label for="re-enter_password">Re-enter password:</label><br>
        <input type="password" id="re-enter_password" name="re-enter_password" placeholder="Re-enter password" style="height: 30px; width: 300px;" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>