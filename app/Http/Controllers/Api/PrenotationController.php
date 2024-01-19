<?php

namespace App\Http\Controllers\Api;

use App\Models\Mail;
use Illuminate\Http\Request;

use App\Http\Services\EmailBuilder;
use App\Http\Services\EmailService;
use App\Http\Controllers\Controller;
use App\Http\Services\PrenotationBuilder;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\IdentificationFrontEnd;
use App\Http\Services\ValidationsService;

class PrenotationController extends Controller
{
    private $emailService;
    private $prenotationBuilder;
    private $identificationFrontEnd;
    private $validationsService;

    public function __construct(EmailService $emailService, PrenotationBuilder $prenotationBuilder,  IdentificationFrontEnd $identificationFrontEnd, ValidationsService $validationsService )
    {
        $this->emailService = $emailService;
        $this->prenotationBuilder = $prenotationBuilder;
        $this->identificationFrontEnd = $identificationFrontEnd;
        $this->validationsService = $validationsService;
    }

    public function reservePrenotation(Request $request){
        // Validazione tramite metodo
        $validator = $this->validationsService->validateJson($request, 'prenotations');

        if ($validator->fails()) {
            // Gestisci gli errori come preferisci
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $email = $request->email;
            $name = $request->name;
            $telephone = $request->telephone;
            $people = $request->people;
            $message = $request->message;
            $date = $request->date;
            $hour = $request->hour;
            $sendMail = $request->sendMail;
            
            if($sendMail){
                // Prendiamo i dati dal Middleware
                $mailFrom = $this->identificationFrontEnd->getMailData('mailUsername');

                // Invia email al cliente
                $this->emailService->sendEmail($email, "Email di conferma", 
                $this->prenotationBuilder->buildMailBody($email, $name, $telephone, $people, $message, $date, $hour, true));
                // Invia email al proprietario
                $this->emailService->sendEmail($mailFrom, "Email mandata da $name", 
                $this->prenotationBuilder->buildMailBody($email, $name, $telephone, $people, $message, $date, $hour, false));
                    
                return response()->json(['message' => 'Richiesta effettuata con successo.'],200);
            } else {
                return response()->json(['message' => 'Richiesta non valida.'], 400);
            }
        }
    }

    // public function validateJson(Request $request){
    //     // Decodifica il JSON nel formato di un array associativo
    //     $data = json_decode($request->getContent(), true);

    //     // Definisci le regole di validazione
    //     $rules = [
    //         'email'     => 'required|string|max:255',
    //         'name'      => 'required|string|max:255',
    //         'telephone' => 'required|string|max:255',
    //         'people'    => 'required|numeric|max:255',
    //         'message'   => 'nullable|string|max:255',
    //         'date'      => 'required|string|max:255',
    //         'hour'      => 'required|string|max:255',
    //         'sendMail'  => 'required|boolean',
    //     ];

    //     // Esegui la validazione
    //     $validator = Validator::make($data, $rules);
    //     return $validator;
    // }
    
}
