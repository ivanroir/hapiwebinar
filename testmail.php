<?php 
    use PHPMailer\PHPMailer\PHPMailer;

    $name = $_POST['email'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $status = "";
    $response = "";
    
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";  
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();
    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = "";
        $mail->SMTPAuth = true;
        $mail->Username = "hapi@hapiwebinar.tk";
        $mail->Password = "Ivan.Roir090493";
        $mail->Port = 587;
        //$mail->SMTPSecure = "tls";

        $mail->isHTML(true);
        $mail->setFrom($email, $name);
        $mail->addAddress("hapi@hapiwebinar.tk");
        $mail->Subject = ("$email ($subject)");
        $mail->Body = $body;

        if ($mail->send()) {
            $status = "success";
            $response = "Email is sent!";
        }
        else {
            $status = "failed";
            $response = "Something is wrong: <br>" . $mail->ErrorInfo;
        }
    }
    catch(e) {
        console.log(e);
    }
    exit(json_encode(array("status" => $status, "response" => $response)));
?>