<?php

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
header('Content-type: application/json');

require_once('php-mailer/PHPMailerAutoload.php');
$mail = new PHPMailer();

// Enter your email address:
$to = "";

// Form Fields
$name = $_POST["name"];
$surname = $_POST["surname"];
$email = $_POST["email"];
// $phone = $_POST["widget-contact-form-phone"];
// $service = $_POST["widget-contact-form-service"];
$interested = $_POST["interested"];
$message = $_POST["message"];
// $antispam =  $_POST['widget-contact-form-antispam'];

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    
     if($name != '' && $surname != '' && $email != '' && $message != '') {

        $fullName = $name.' '.$surname;

        //If you don't receive the email, enable and configure these parameters below: 

        //$mail->isSMTP();                                      // Set mailer to use SMTP
        //$mail->Host = 'mail.yourserver.com';                  // Specify main and backup SMTP servers, example: smtp1.example.com;smtp2.example.com
        //$mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'SMTP username';                    // SMTP username
        //$mail->Password = 'SMTP password';                    // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 587;                                    // TCP port to connect to 

        $mail->IsHTML(true);                                    // Set email format to HTML
        $mail->CharSet = 'UTF-8';

        $mail->From = $email;
        $mail->FromName = $fullName;
        $mail->AddAddress('info@changeagents.lk');
        $mail->AddAddress('lividul@gmail.lk');
        $mail->AddAddress();								  
        $mail->AddReplyTo($email, $name);
        $mail->Subject = 'New Message From Contact Form';

        $name = isset($fullName) ? "Name: $fullName<br><br>" : '';
        $email = isset($email) ? "Email: $email<br><br>" : '';
        // $phone = isset($phone) ? "Phone: $phone<br><br>" : '';
        // $company = isset($company) ? "Company: $company<br><br>" : '';
        $service = isset($interested) ? "Service: $interested<br><br>" : '';
        $message = isset($message) ? "Message: $message<br><br>" : '';

        $mail->Body = $name . $email . $service . $message . '<br><br><br>This email was sent from: ' . $_SERVER['HTTP_REFERER'];
         
                             
        if(!$mail->Send()) {
    	   $response = array ('response'=>'error', 'message'=> $mail->ErrorInfo);  
    	}else {
           $response = array ('response'=>'success');  
        }
        echo json_encode($response);

    } else {
    	$response = array ('response'=>'error');     
    	echo json_encode($response);
    }
}
?>
