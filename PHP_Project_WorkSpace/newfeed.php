<?php
include 'connectDB.php';
session_start();


if (!isset($_SESSION['LOGIN_CHECK']) || $_SESSION['LOGIN_CHECK'] !== TRUE) {
    header('Location: login.php');
    exit();
} else {
    if (isset($_GET['search'])){
        $search = $_GET['search'];
        $search = trim($search);
        $sql = "SELECT * FROM posted WHERE Username like '%$search%' OR Title LIKE '%$search%'";
    }
    else{
        $sql = "Select * from posted";
    }

    $result = $conn->query($sql);
    $html_content = "";

    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_assoc();
        $html_content .= "<section>";
        $html_content .= "<p id = 'title' style =' font-size : 1.5rem; font-family: Arial; font-weight: bold;'>" . $row["Title"] . "</p>";
        $html_content .= "<p style =' font-size : 1.15rem; font-family: Arial;font-weight: lighter;' id = 'content'>" . $row["Content"] . "</p>";
        $html_content .= "<p style =' font-size : 0.76rem; font-family: Arial; font-style:Italic;padding-bottom: 25px;' id = 'author'>" . "By " . $row["Username"] . " on " . $row['Posttime'] . "</p>";
        $html_content .= "</section>";
        $html_content .= "<p>---------------------------------------------------------------------------------------------------------------------------</p>";
    }
    if ($result->num_rows == 0){
        $html_content .= "<br>No Results<br>";
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
    <title>Welcome</title>
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
            background-color: #d0d3d4;
        }

        a {
            text-decoration: none;
        }

        ul {
            list-style-type: none;
        }

        li {
            padding: 6px;
        }

        li:hover {
            cursor: pointer;
            background-color: darkgray;
        }

        html {
            background-color: lightgray;
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
        <h1>Welcome</h1>
        <form action="newfeed.php" method="GET">
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" placeholder="Username or Title">
            <input type="submit" value="Search" >
        </form>
        <p>________________oOo________________</p>
        <p>
        <p><?php echo $html_content; ?></p>
    </div>
</body>

</html>