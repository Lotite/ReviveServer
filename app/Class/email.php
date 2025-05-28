<?php

namespace App\Class;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class email
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'latifiyates@gmail.com'; 
        $this->mail->Password = 'drcj nucq wrac hkig'; 
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $this->mail->Port = 465; 

        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
    }

    public function send($to, $subject, $body, $from = null, $fromName = null)
    {
        try {
            $from = $from ?: 'latifiyates@gmail.com';
            $fromName = $fromName ?: 'Revive';
            $this->mail->setFrom($from, $fromName);
            $this->mail->addAddress($to);

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}