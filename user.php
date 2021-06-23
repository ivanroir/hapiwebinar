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

    $sqlSelect = "SELECT * FROM users WHERE email = '" . $_POST["email"] . "' AND code = '" . $_POST["code"] . "'";
    $result = $conn->query($sqlSelect);

    if(!empty($result) && $result->num_rows > 0) {
        $sqlCheck = mysqli_query($conn, $sqlSelect) or die("Check query failed");
        $existingInfo = mysqli_fetch_assoc($sqlCheck);
        $session_id = $existingInfo["status"];

        if (empty($session_id) || $session_id === session_id()) {

            $session_id = session_id();
            $_SESSION["session_id"] = session_id();

            $sqlUpdate = "UPDATE users 
            SET status = '$session_id' 
            WHERE email = '" . $_POST["email"] . "' AND code = '" . $_POST["code"] . "'";

            if ($conn->query($sqlUpdate) === TRUE) {
                echo "1";
            } else {
                echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
            }
        }
        else {
            echo $session_id;
        }
    }
    else {
        echo "0";
    }

    $conn->close();
?>