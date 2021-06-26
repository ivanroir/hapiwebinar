<?php 
    header("Access-Control-Allow-Origin: *");

    $servername = "localhost";
    $username = "u480472038_freseniuskabi";
    $password = "Ivan.Roir090493";
    $database = "u480472038_freseniuskabi";

    //$conn = mysqli_connect('localhost', 'root', '', 'ndap'); //dev
    $conn = mysqli_connect($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $id = $_POST['id'];
    $mode = $_POST['mode'];

    if ($mode == "reset_password") {
        $UPDATE = "UPDATE users SET reset_password = 0, status = '' WHERE id = '" . $id . "'";
    }
    else {
        $UPDATE = "UPDATE users SET forgot_password = 0 WHERE id = '" . $id . "'";
    }
    
    if ($conn->query($UPDATE) === TRUE) {
       echo "1";
    } else {
        echo "0";
    }
    
    $conn->close();
?>