<?php 
    session_start(); 
    
    header("Access-Control-Allow-Origin: *");

    $servername = "localhost";
    $username = "u480472038_freseniuskabi";
    $password = "Ivan.Roir090493";
    $database = "u480472038_freseniuskabi";

    //$conn = mysqli_connect('localhost', 'root', '', 'freseniuskabi'); //dev
    $conn = mysqli_connect($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlSelect = "SELECT * FROM users WHERE email = '" . $_POST["email"] . "'";
    $result = $conn->query($sqlSelect);

    if(!empty($result) && $result->num_rows > 0) {
        $sqlCheck = mysqli_query($conn, $sqlSelect) or die("Check query failed");
        $existingInfo = mysqli_fetch_assoc($sqlCheck);
        $zoom = $existingInfo['zoom_entered'] + 1;

        $sqlUpdate = "UPDATE users 
        SET zoom_entered = $zoom
        WHERE email = '" . $_POST["email"] . "'";

        if ($conn->query($sqlUpdate) === TRUE) {
            echo "1";
        } else {
            echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
        }
    }
    else {
        echo "0";
    }

    $conn->close();
?>