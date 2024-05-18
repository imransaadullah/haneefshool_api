<?php
namespace API;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer {
    private static $mailer = null;

    public function __construct() {
        if (self::$mailer == null) {
            $mail = new PHPMailer();
            $mail->SMTPDebug = 2;
            // $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Username = $_ENV['OFFICIAL_EMAIL'];
            $mail->Password = $_ENV['OFFICIAL_EMAIL_PASSWORD'];
            self::$mailer = $mail;
        }
    }

    public static function setReplyTo($email, $name = '') {
        try {
            new self();
            self::$mailer->addReplyTo($email, $name);
        } catch (\Exception $e) {}
    }

    public static function sendmail($title, $message, $email, $name, $internal = true, $isHTML = false)
	{
        try {
            new self();
            $mail = self::$mailer;
            
            if($internal){
                $mail->setFrom($email, $name);
                $mail->addReplyTo($email, "RE: $title - $name");
                $mail->addAddress($_ENV['OFFICIAL_EMAIL'], $_ENV['OFFICIAL_EMAIL_NAME']);
            }else{
                $mail->setFrom($_ENV['OFFICIAL_EMAIL'], $_ENV['OFFICIAL_EMAIL_NAME']);
                $mail->addAddress($email, $name);
            }
            
            $mail->Subject = $title;

            if($isHTML){
                $mail->isHTML(true);
                $mail->msgHTML($message);
            }else{
                $mail->Body = $message;
            }

            if($mail->send()){
                return true;
            }
            return $mail->ErrorInfo;
        } catch (\Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
	}
}