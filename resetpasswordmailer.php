<?php
//project done by - JPRX
//Include required PHPMailer files
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
Class Mailer {
	/*##########Script Information#########
	# Purpose: Send mail Using PHPMailer#
	#          & Gmail SMTP Server 	  #
	# Created: 24-11-2019 			  #
	#	Author : Hafiz Haider			  #
	# Version: 1.0					  #
	# Website: www.BroExperts.com 	  #
	#####################################*/

	public function sendEmail($email, $password){

	//Create instance of PHPMailer
		$mail = new PHPMailer();
	//Set mailer to use smtp
		$mail->isSMTP();
	//Define smtp host
		$mail->Host = "smtp.gmail.com";
	//Enable smtp authentication
		$mail->SMTPAuth = true;
	//Set smtp encryption type (ssl/tls)
		$mail->SMTPSecure = "tls";
	//Port to connect smtp
		$mail->Port = "587";
	//Set gmail username
		$mail->Username = "plmcoopuniform@gmail.com";
	//Set gmail password
		$mail->Password = "khaarsgeavdoxyqt";
	//Email subject
		$mail->Subject = "PLM Cooperative Forgot Password";
	//Set sender email
		$mail->setFrom('plmcoopuniform@gmail.com');
	//Enable HTML
		$mail->isHTML(true);
	//Attachment
	//	$mail->addAttachment('img/attachment.png');
	//Email body
		$mail->Body = "<h1>PLM COOPERATIVE FORGOT PASSWORD</h1></br><p>Here is your new temporary password: </p></br>".$password."<p>Please change your password right away.</p>";
        //$mail->Body = "<h1>PLM COOPERATIVE FORGOT PASSWORD</h1></br><p>Here is your new temporary password: </p>"."i12312312"."Please change your password right away";
	//Add recipient
		$mail->addAddress($email);
	//Finally send email
		if ( $mail->send() ) {
			echo "Email Sent..!";
		}else{
			echo "Message could not be sent. Mailer Error: ";
		}
	//Closing smtp connection
		$mail->smtpClose();

	}
}
?>
