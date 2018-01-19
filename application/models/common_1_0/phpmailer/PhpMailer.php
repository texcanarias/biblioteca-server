<?php

namespace serve\src\common\phpmailer;

class PhpMailer {

    static function factoryPHPMailer() {
        date_default_timezone_set('Etc/UTC');
        require __DIR__ . '/../../../../vendor/autoload.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->IsHTML(true);
        $mail->Username = "adclick.1999@gmail.com";
        $mail->Password = "5lQXBgmRrpELAzOxGPQB";
        $mail->Port = 587;
        $mail->setFrom("no-response@euskalit-beta.com", "No reply");
        return $mail;
    }

}
