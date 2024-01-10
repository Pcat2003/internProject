<?php
include 'connectDB.php';
session_start();
$html_content = "";
if (isset($_SESSION['del'])){
    $html_content .= $_SESSION['del'];
    unset($_SESSION['del']);
}
if (isset($_SESSION['editStatus'])){
    $html_content .= $_SESSION['editStatus'];
    unset($_SESSION['editStatus']);
}
if (isset($_SESSION['Add_Success'])) {
    $html_content .= "<p>Post successfully</p><br>";
    unset($_SESSION['Add_Success']);
}
if (!isset($_SESSION['LOGIN_CHECK']) || $_SESSION['LOGIN_CHECK'] !== TRUE) {
    header('Location: login.php');
    exit();
} else {
    $username = $_SESSION['UserName'];
    echo $username;
    if (isset($_GET['search'])){
        $search = $_GET['search'];
        $search = trim($search);
        $sql = "SELECT * FROM posted WHERE Username = '$username' AND (Title LIKE '%$search%' OR Content LIKE '%$search%')";
    }else{
        $sql  = "SELECT * FROM posted WHERE Username = '$username'";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        for ($i = 0; $i < $result->num_rows; $i++) {
            $row = $result->fetch_assoc();
            $html_content .= "<section>";
            $html_content .= "<p id = 'title' style =' font-size : 1.5rem; font-family: Arial; font-weight: bold;'>" . $row["Title"] . "</p>";
            $html_content .= "<p style =' font-size : 1rem; font-family: Arial;' id = 'content'>" . $row["Content"] . "</p>";
            $html_content .= "<p style =' font-size : 0.7rem; font-family : Arial; font-style: italic;' ".$row["Posttime"]."</p>";
            $html_content .= "<a class='delAndEdit' id ='edit' href = 'edit.php?this_id=".$row['PostID']."'> Edit</a><br>";
            $html_content .= "<a class='delAndEdit' id = 'delete' href = 'delete.php?this_id=".$row['PostID']."'> Delete</a>";
            $html_content .= "<p>--------------------------------</p>";
            $html_content .= "</section>";
        }
    } else {
        $html_content .= "<br>YOU HAVE NO POST";
    }
}
$conn->close();
?>
<!-- htmlCode -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Post</title>
    <br>
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }
        #sidebar {
            width: 200px;
            background-color: #d5d5d5;
            padding: 20px;
        }
        #content {
            flex: 1;
            padding: 20px;
        }

        li {
            padding: 6px;
        }
        .delAndEdit{
            font-size : 1rem; 
            font-style: normal;
            display:inline-block;
        }
        .delAndEdit:hover{
            cursor: pointer;
            background-color: #B2BABB;
        }
        a {
            text-decoration: none;
            color: black;
        }
        ul {
            list-style-type: none;
        }
        li:hover {
            cursor: pointer;
            background-color: darkgray;
        }
        html {
            background-color: lightgray;
        }
        #edit.delAndEdit{
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="newfeed.php">New Feed</a></li>
            <li><a href="myPost.php">My Post</a></li>
            <li><a href="addpost.php">Write Post</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
    <div id="content">
        <h1>My Post</h1>
        <form action="myPost.php" method="GET">
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" placeholder="Title or Content">
            <input type="submit" value="Search" >
        </form>
        <p>________________oOo________________</p>
        <p><?php echo $html_content; ?></p>
    </div>
</body>
</html>