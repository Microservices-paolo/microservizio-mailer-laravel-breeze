<?php
namespace App\Http\Services;

 // Questo service è fondamentale con i suoi metodi per il controller Api\MailController affinchè possa costruire il testo delle mail da mandare.
class PrenotationBuilder
{
    // buildMailBody() è il metodo di partenza per generare l'html delle mail, il contenuto del body viene generato dagli altri due metodi
    public function buildMailBody($mail, $name, $telephone, $people, $messagge, $date, $hour, $isClient){
        $content =  $isClient ? $this->getMailBodyClient($name, $people, $date, $hour) : $this->getMailBodyAdmin($mail, $name, $telephone, $people, $messagge, $date, $hour);
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
    function getMailBodyAdmin($mail, $name, $telephone, $people, $message, $date, $hour) {
        $mailMessage = $message == "" ? "" :  "<span>Messaggio da parte del cliente:</span> <p>$message</p>";
        return <<<END
            <h1>Prenotazione tavolo $name</h1>
            <p>$name ha prenotato un tavolo per $people persone per il giorno $date alle ore $hour.</p>
            <span>Mail: $mail, Cellulare: $telephone </span>
            <p> $mailMessage </p>
        END;
    }

    // getMailBodyClient() genera il body della mail di conferma riguardo l'avvenuto invio della richiesta di informazioni presso l'admin. Tale mail arriva quindi al cliente.
    function getMailBodyClient($name, $people, $date, $hour) {
        return <<<END
        
            <h1>Ciao $name</h1>
            
            <p>La tua prenotazione è stata inoltrata con successo!</p>
            <span>Riepilogo prenotazione:</span>
            <p>$name, $people, $date, $hour</p>
        
        END;
    }

}
