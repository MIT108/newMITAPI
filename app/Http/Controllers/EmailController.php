<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class EmailController extends Controller
{
    //
    public function sendMail($subject, $body, $receiverEmail, $receiverName){

        $senderEmail = env('MAIL_SENDER_EMAIL');
        $senderPassword = env('MAIL_SENDER_PASSWORD');
        $senderName = env('MAIL_SENDER_NAME');
        $logo = env('APP_LOGO');
        $site = env('FRONT_ADMIN_APP_URL')."/Login";

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = env('MAIL_HOST');                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = env('MAIL_USERNAME');                     //SMTP username
            $mail->Password   = env('MAIL_PASSWORD');                            //SMTP password //jfltubgqbwniivya
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');            //Enable implicit TLS encryption
            $mail->Port       = env('MAIL_PORT');
            $mail->SMTPDebug  = 0;                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($senderEmail, $senderName);
            $mail->addAddress($receiverEmail);    //Name is optional
            $mail->addReplyTo($receiverEmail, $receiverName);

            // //Attachments
            // if (count($attachmentsArray) > 0) {
            //     $mail->addAttachment('/var/tmp/file.tar.gz');
            //     foreach ($attachmentsArray as $attachment) {
            //         $mail->addAttachment($attachment->path, $attachment->name);
            //     }
            // }
            // $logo = env('APP_URL')."/assets/image/logo.webp";

            $body = view('email.basic')->with('logo', $logo)->with('body', $body)->with('site', $site)->render();
            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
