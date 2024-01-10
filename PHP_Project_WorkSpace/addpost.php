<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    session_start();
    include 'connectDB.php';
    $_SESSION['Add Success'] = false;
    if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["submit_button"])){
        if (!isset($_SESSION['LOGIN_CHECK']) || $_SESSION['LOGIN_CHECK'] !== TRUE) {
            header('Location: login.php');
            exit();
        } else {
            $title = $_POST['post-title'];
            $content = $_POST['post-content'];
            $username = $_SESSION['UserName'];
            $posttime = date("Y-m-d H:i:s");
            $postID  = uniqid();
            $sql = "INSERT INTO posted(Username,Title,Content,Posttime,PostID) VALUES('$username','$title', '$content','$posttime','$postID')";
            $result = $conn->query($sql);
            if ($result) {
                header('Location: myPost.php');
                $_SESSION['Add_Success'] = true;
                exit();
            }
        }
    }
?>
<!-- htmlCode -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
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
        h1 {
            text-align: center;
        }
        #content {
            flex: 1;
            padding: 20px;
        }
        
        #new-post-form {
            max-width: 600px;
            margin: 0 auto;
        }
        form{
            margin-left: 0;
        }
        li {
            padding: 6px;
        }
        li:hover {
            cursor: pointer;
            background-color: darkgray;
        }
        a {
            text-decoration: none;
        }
        
        ul {
            list-style-type: none;
        }
        html{
            background-color: lightgray;
        }
        input {
            margin-bottom: 15px;
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
        <h1>New Post</h1>
        <form id="new-post-form" action = "addpost.php" method = "POST">
            <label for="post-title">Title:</label>
            <br>
            <input type="text" id="post-title" name="post-title" required>
            <br>
            <label for="post-content">Content:</label>
            <textarea id="post-content" name="post-content" rows="10" cols="100" required></textarea>
            <button type="submit" name="submit_button" >Submit Post</button>
        </form>
    </div>
</body>

</html>