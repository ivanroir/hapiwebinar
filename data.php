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

    $sqlSelect = "SELECT * FROM users WHERE email = '" . $_GET["email"] . "' AND password = '" . $_GET["password"] . "'";
    $result = $conn->query($sqlSelect);

    if(!empty($result) && $result->num_rows > 0) {
        $sqlCheck = mysqli_query($conn, $sqlSelect) or die("Check query failed");
        $existingInfo = mysqli_fetch_assoc($sqlCheck);
        $session_id = $existingInfo["status"];
        echo $session_id;
    }
    else {
        echo "0";
    }

    $conn->close();
?>