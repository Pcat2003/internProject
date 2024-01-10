<?php
session_start();
include 'connectDB.php';
if(isset($_SESSION['REGISTER_SUCCESS'])){
    echo "<p style= 'color: navy';>".$_SESSION["REGISTER_SUCCESS"]."</p>";
    unset($_SESSION['REGISTER_SUCCESS']);
}
if(isset($_SESSION['LOGIN_FAILED'])){
    echo $_SESSION["LOGIN_FAILED"];
    unset($_SESSION['LOGIN_FAILED']);
}
#Get data from login form
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['LOGIN_CHECK'] = FALSE;
    
#Get_db
$sql = "SELECT * FROM users WHERE Username = '$username' AND Passwords = '$password'";
$result = $conn->query($sql);
#Compare and direct
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if ($row["Roles"] == 'admin') {
        header("Location: admin.php");
        $_SESSION['LOGIN_CHECK'] = TRUE;
        $_SESSION['UserName'] = 'admin';
        exit();
    } else 
        if ($row["Roles"] == 'User') {
            header('Location: newfeed.php');
            $_SESSION['LOGIN_CHECK'] = TRUE;
            $_SESSION['UserName'] = $username;
            exit();
        }
    
} else {
    $_SESSION['LOGIN_FAILED'] = "WRONG USERNAME OR PASSWORD";
    header("Location: login.php");
    exit();
}
}
$conn->close();
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <a href="register.php" style=" font-family: Arial, Helvetica, sans-serif">Register</a>
    <form action="login.php" method="post">
        <h2>Login</h2>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" placeholder="Enter username" style="height: 30px; width: 300px;" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Enter password" style="height: 30px; width: 300px;" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>