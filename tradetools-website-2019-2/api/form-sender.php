<?php

require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Form_Sender {

    // Email SMTP
    private $from_email = "info@mintlab.com.br";
    private $from_name = "Website Tradetools";


    private $smtp_host = "email-ssl.com.br";
    private $smtp_user = "info@mintlab.com.br";
    private $smtp_pass = "DzGoDe517";
    private $smpt_port = "587";
    private $smtp_secure = 'tls';

    private $mail;

    public function __construct($debug = false){

        $this->mail = new PHPMailer(true);

        if ($debug) $this->mail->SMTPDebug = 3;

        $this->mail->isSMTP();
        $this->mail->SMTPAuth =     true;
        $this->mail->Host =         $this->smtp_host;
        $this->mail->Username =     $this->smtp_user;
        $this->mail->Password =     $this->smtp_pass;
        $this->mail->SMTPSecure =   $this->smtp_secure;
        $this->mail->Port =         $this->smpt_port;

        $this->mail->ReturnPath =   $this->from_email;
        $this->mail->CharSet =      "UTF-8";
        $this->mail->Encoding =     'base64';

        $this->mail->isHTML(true);

        $this->mail->SetFrom( $this->from_email, $this->from_name);

    }

    public function send( $to_email, $to_name, $filepath = false, $filename = false, $email_subject, $email_body){

        $status_return = false;


        try {

            //Recipients
			foreach($to_email as $each_to_email)
			{
				$this->mail->AddReplyTo($each_to_email, $to_name);
				$this->mail->AddAddress($each_to_email, $to_name);
			}

            //Attachments
            if($filepath && $filename){
                $this->mail->addAttachment($filepath, $filename);
            }

            //Content
            $this->mail->Subject = $email_subject;
            $this->mail->Body    = $email_body;


            if ($this->mail->send()) {
                $status_return = true;
            }

        } catch (Exception $e) {
            $status_return = false;
        }

        return $status_return;

    }

}