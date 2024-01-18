<?php

namespace App\Http\Controllers\Api;

use App\Models\Mail;
use Illuminate\Http\Request;
use App\Http\Services\EmailBuilder;
use App\Http\Services\EmailService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\IdentificationFrontEnd;

class MailController extends Controller
{
    private $emailService;
    private $emailBuilder;
    private $pranotationBuilder;
    private $identificationFrontEnd;

    public function __construct(EmailService $emailService, EmailBuilder $emailBuilder, PrenotationBuilder $prenotationBuilder,  IdentificationFrontEnd $identificationFrontEnd)
    {
        $this->emailService = $emailService;
        $this->emailBuilder = $emailBuilder;
        $this->prenotationBuilder = $prenotationBuilder;
        $this->identificationFrontEnd = $identificationFrontEnd;
    }

    public function createMail(Request $request){
        // Validazione tramite metodo
        $validator = $this->validateJson($request);

        if ($validator->fails()) {
            // Gestisci gli errori come preferisci
            return response()->json(['error' => $validator->errors()], 422);
        } else {
        
            $email = $request->email;
            $name = $request->name;
            $telephone = $request->telephone;
            $contact = $request->contact;
            $sendMail = $request->sendMail;

            if($sendMail){
                // Prendiamo i dati dal Middleware
                $mailFrom = $this->identificationFrontEnd->getMailData('mailUsername');

                $test = true;

                // Invia email al cliente
                $this->emailService->sendEmail($email, "Email di conferma", 
                $test ? $this->emailBuilder->buildMailBody($email, $telephone, $contact, $name, true) : $this->prenotationBuilder->buildMailBody($email, $telephone, $contact, $name, true));

                // Invia email al proprietario
                $this->emailService->sendEmail($mailFrom, "Email mandata da $name", 
                $test ? $this->emailBuilder->buildMailBody($email, $telephone, $contact, $name, false) : $this->prenotationBuilder->buildMailBody($email, $telephone, $contact, $name, false));
                    
                return response()->json(['mail' => $email, "nome" => $name, "telephone" => $telephone, "contact" => $contact, "sendMail" => $sendMail],200);
            } else {
                return response()->json(['message' => 'Richiesta non valida.'], 400);
            }
        }
    }

    public function validateJson(Request $request){
        // Decodifica il JSON nel formato di un array associativo
        $data = json_decode($request->getContent(), true);

        // Definisci le regole di validazione
        $rules = [
            'email' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'sendMail' => 'required|boolean',
        ];

        // Esegui la validazione
        $validator = Validator::make($data, $rules);
        return $validator;
    }
    
}
