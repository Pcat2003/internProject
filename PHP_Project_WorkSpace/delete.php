<?php
    include 'connectDB.php';
    session_start();
    $_SESSION['del']= "";
        $this_id = $_GET['this_id'];
        $sql = "DELETE FROM posted where PostID = '$this_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['del'] = "Delete Successfully";
            header('Location: myPost.php');
            $conn->close();
            exit();
        } else {
            $_SESSION['del'] = "Delete failed";
            header('Location: myPost.php');
            $conn->close();
            exit();
        }
        
?>