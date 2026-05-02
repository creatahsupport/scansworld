<?php
date_default_timezone_set('Asia/Kolkata');
require_once('PHPMailerAutoload.php');
$To_email =$_ENV['To_Email'];   
function mailer($subject,$message,$receiver)
{    

  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPDebug = 0;
  $mail->SMTPAuth = TRUE;
  $mail->SMTPSecure = "ssl";
  $mail->Port     = $_ENV['MAIL_PORT'];  
  $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password =$_ENV['SMTP_PASSWORD'];
    $mail->Host = $_ENV['SMTP_HOST'];
  
  
  $mail->Mailer   = "smtp";
  $mail->SetFrom($_ENV['SMTP_SETFROM'], "New Enquiry");
  $mail->AddAddress($receiver);
  
  $mail->Subject =$subject;
  $mail->WordWrap   = 80;  
  // $cc = "creatahmailinquiry@gmail.com";
  // $mail->AddCC($cc);
  // $mail->AddCC('', 'cc');
  
  // print_r($admin_mail);die;
  $mail->MsgHTML($message); 
  $mail->IsHTML(true);
  if(!$mail->send()) 
  {
    $message=false;
  }
  else 
  {
    $message=true; 
  }
  return $message;
  
  }

?>
