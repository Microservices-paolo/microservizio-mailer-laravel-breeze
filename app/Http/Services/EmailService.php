<?php

namespace App\Http\Services;

use App\Models\Mail;
use App\Http\Middleware\IdentificationFrontEnd;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use stdClass;


 // Questo service contiene tutta la logica che permette l'invio di mail tramite PHPMailer.
 class EmailService
{
    // Independence Injection per prendere il dati dal middleware IdentificationFrontEnd
    private $identificationFrontEnd;
    private $securityPassword;
    

    public function __construct(IdentificationFrontEnd $identificationFrontEnd, SecurityPassword $securityPassword)
    {
        $this->identificationFrontEnd = $identificationFrontEnd;
        $this->securityPassword = $securityPassword;
    }

    // setMailData() si occupa di prendere i dati necessari all'invio delle mail tramite il metodo getMailData() del middleware IdentificationFrontEnd
    public function setMailData()
    {
        $mailData = new stdClass();

        $mailData->mailHost = $this->identificationFrontEnd->getMailData('mailHost');
        $mailData->mailUsername = $this->identificationFrontEnd->getMailData('mailUsername');
        $mailData->mailPassword = $this->identificationFrontEnd->getMailData('mailPassword');
        $mailData->mailSmtpSecure = $this->identificationFrontEnd->getMailData('mailSmtpSecure');
        $mailData->mailPort = $this->identificationFrontEnd->getMailData('mailPort');
        $mailData->mailFrom = $mailData->mailUsername;

        return $mailData; 
    }

    // sendEmail() contiene la logica fondamentale di questo microservizio, consente tramite PHPMailer di mandare le mail grazie ai dati ottenuti
    public function sendEmail($to, $subject, $body)
    {       
        try {
    
            // Utilizzo del metodo setMailData()
            $mailData = $this->setMailData();

            // Utilizzo di PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
        
            $mail->Host = $mailData->mailHost;
            $mail->Username = $mailData->mailUsername;
            $mail->Password = $this->securityPassword->decryptData($mailData->mailPassword, $_ENV['SECRET_KEY']);
            $mail->SMTPSecure = $mailData->mailSmtpSecure;
            $mail->Port = $mailData->mailPort;
            $mail->setFrom($mailData->mailFrom);
        
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
        
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
