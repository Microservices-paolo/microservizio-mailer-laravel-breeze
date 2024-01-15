<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\Mail;
use Exception;

// Questo Middleware è fondamentale per permettere l'accesso e l'utilizzo di questo servizio soltanto ai front-end autorizzati.
class IdentificationFrontEnd
{   
    // checkFrontEndAndDb() è il metodo che confronta se il parametro chiave del frontend (X-Frontend) è presente nel DB.
    private function checkFrontEndAndDb($req)
    {
        $frontend = $req->header('X-Frontend');
        return Mail::where('mailName', $frontend)->first();
    }

    // getMailData() è il metodo che permette l'accesso dei dati del DB al controller Api\MailController e al service EmailService.
    public function getMailData($data)
    { 
        return Session::get('current_frontend_data.'. $data);
    }

    // putOnSession() avvia la sessione con i dati necessari per l'SMTP che verranno condivisi al controller Api\MailController e al service EmailService.
    private function putOnSession($id)
    {
        Session::put('current_frontend_data', $id->toArray());
    }

    // Questo è il metodo base di questo middleware nella Pipeline, permette di andare avanti soltanto nel caso in cui tutte le condizioni vengano rispettate, altrimenti restituirà accesso negato.
    public function handle($request, Closure $next)
    {
        // Verifica la condizione con il metodo checkFrontEndAndDb()
        if ($id_frontend = $this->checkFrontEndAndDb($request))
        {
            // Avvio della sessione con il metodo putOnSession()
            $this->putOnSession($id_frontend);

            // Esito positivo
            return $next($request);
        }

        // Esito negativo
        return response()->json(['error' => 'Accesso negato'], 403);
    }

}
