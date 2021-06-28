<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $from = "hapi@hapiwebinar.tk";
    $to =  $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['body'];
    
    $headers = "From: " . $from;
    mail($to, $subject, $message, $headers);
    
?>