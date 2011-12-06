<?php

class Mailer {

    public static function sendMail($subject, $bodyText, $to ){

        // create mail object
        $mail = new Zend_Mail('utf-8');

        // configure base stuff
        $mail->addTo($to);
        $mail->setSubject($subject);
        $mail->setFrom('admin@yousuckapp.com');
        $mail->setBodyHtml($bodyText);
        $mail->send();

    }
}
