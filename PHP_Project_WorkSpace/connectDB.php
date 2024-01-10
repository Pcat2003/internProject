<?php
    $conn  = mysqli_connect("localhost","root","","project_db");
    if($conn->connect_error) {
        die("Can't connect to database: ".$conn->connect_error);
    }
?>