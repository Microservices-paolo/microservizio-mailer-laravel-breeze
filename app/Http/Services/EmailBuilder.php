<?php
namespace App\Http\Services;

 // Questo service è fondamentale con i suoi metodi per il controller Api\MailController affinchè possa costruire il testo delle mail da mandare.
class EmailBuilder
{
    // buildMailBody() è il metodo di partenza per generare l'html delle mail, il contenuto del body viene generato dagli altri due metodi
    public function buildMailBody($email, $telephone, $contact, $name, $isClient){
        $content =  $isClient ? $this->getMailBodyClient($name) : $this->getMailBodyAdmin($email, $telephone, $contact);
        return <<<END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                $content
            </body>
            </html>
        END;
    }

    // getMailBodyAdmin() genera il body della mail di richiesta informazioni che arriverà all'admin proprietario del front-end
    function getMailBodyAdmin($email, $telephone, $contact) {
        return <<<END

            <h1>Mail del cliente</h1>
            <p>Email: $email; </p>
            <p>Telefono: $telephone; </p>
            <p>Il cliente vorrebbe essere contattato attraverso: $contact;</p>
            
        END;
    }

    // getMailBodyClient() genera il body della mail di conferma riguardo l'avvenuto invio della richiesta di informazioni presso l'admin. Tale mail arriva quindi al cliente.
    function getMailBodyClient($name) {
        return <<<END
        
            <h1>Ciao $name</h1>
            
            <p>Abbiamo ricevuto la tua richiesta verrai contattato a breve!</p>
        
        END;
    }

}
