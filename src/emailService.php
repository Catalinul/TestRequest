<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;


function sendEmail($emailToSend, $subject, $body){

require_once('PHPMailer\PHPMailer.php');
require_once('PHPMailer\SMTP.php');
require_once('PHPMailer\Exception.php');


$Office365_mail = new PHPMailer(true);
 
$Office365_mail->IsSMTP();
$Office365_mail->SMTPAuth = true;
 
$Office365_mail->Host = "smtp.office365.com";
$Office365_mail->Port = 25; 
$Office365_mail->Username = "censored";
$Office365_mail->Password = "censored";
 
 
$Office365_mail->AddAddress($emailToSend);
$Office365_mail->SetFrom("constantin.pirvu@s.unibuc.ro", "Test Request Platform <constantin.pirvu@s.unibuc.ro>");
$Office365_mail->Subject = $subject;
$Office365_mail->Body    = $body;
$Office365_mail->IsHTML(true);
 
try
{
$Office365_mail->Send();
echo "Setting up PHPMailer with Office365 SMTP using php Success!";
}
catch(Exception $exception)
{
echo "<pre>";
var_dump($exception);
echo "</pre>";
//Something went bad
echo "PHPMailer with Office365 Fail :: " . $Office365_mail->ErrorInfo;
}
    
}

?>