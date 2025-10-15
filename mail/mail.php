<?php
date_default_timezone_set('Asia/Kolkata');
require_once('PHPMailerAutoload.php');
$To_email = "creatahmailinquiry@gmail.com";     
function mailer($subject,$message,$receiver)
{    

  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPDebug = 0;
  $mail->SMTPAuth = TRUE;
  $mail->SMTPSecure = "ssl";
  $mail->Port     = 465;  
  $mail->Username = "enquiry@companyonline.in";
  $mail->Password = "ZMW.7oSxu3&9";
  $mail->Host     = "companyonline.in";
  
  
  $mail->Mailer   = "smtp";
 $mail->SetFrom("noreply@gmail.com", "New Enquiry");
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
