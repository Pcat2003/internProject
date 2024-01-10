<?php
include 'connectDB.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
$_SESSION["postID"] = $_GET['this_id'];
$_SESSION['editStatus'] = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $title = $_POST['post-title'];
    $content = $_POST['post-content'];
    $posttime = date("Y-m-d H:i:s");
    $query = "UPDATE posted SET Title = '$title', Content = '$content', Posttime = '$posttime' WHERE PostID = '$post_id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION["editStatus"] = "EDIT SUCCESSFUL";
        header('Location: myPost.php');
        exit();
    } else {
        $_SESSION["editStatus"] = mysqli_error($conn);
        header('Location: myPosts.php');
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Post Editor</title>
    <br>
    <style>
        h1 {
            text-align: center;
        }

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

        a {
            text-decoration: none;
            color: black;
        }

        li:hover {
            cursor: pointer;
            background-color: darkgray;
        }

        html {
            background-color: lightgray;
        }

        #new-post-form {
            max-width: 600px;
            margin: 0 auto;
        }

        form {
            margin-left: 0;
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
        <h1>Editor</h1>
        <form id="new-post-form" action="edit.php" method="POST">
            <label for="this_id"></label>
            <input type="hidden" name="post_id" value='<?php echo $_SESSION['postID']; ?>'>
            <label for="post-title">Title:</label>
            <br>
            <input type="text" id="post-title" name="post-title" required>
            <br>
            <label for="post-content">Content:</label>
            <textarea id="post-content" name="post-content" rows="10" cols="100" required></textarea>
            <button type="submit" name="submit_button">Post</button>
        </form>
    </div>
</body>

</html>