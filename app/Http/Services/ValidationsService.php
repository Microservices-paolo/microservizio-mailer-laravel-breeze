<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationsService
{   

    public function validateJson(Request $request, $validationType)
    {
        // Decodifica il JSON nel formato di un array associativo
        $data = json_decode($request->getContent(), true);

        // Definisci le regole di validazione in base al tipo
        $rules = $this->getValidationRules($validationType);

        // Esegui la validazione
        $validator = Validator::make($data, $rules);
        return $validator;
    }

    private function getValidationRules($validationType)
    {
        $validationRules = [
            'mails' => [
                'email' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'telephone' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'sendMail' => 'required|boolean',
            ],
            'prenotations' => [
                'email'     => 'required|string|max:255',
                'name'      => 'required|string|max:255',
                'telephone' => 'required|string|max:255',
                'people'    => 'required|numeric|max:255',
                'message'   => 'nullable|string|max:255',
                'date'      => 'required|string|max:255',
                'hour'      => 'required|string|max:255',
                'sendMail'  => 'required|boolean',
            ],
            // Aggiungi altri tipi di validazione se necessario
            'otherType' => [
                // Regole di validazione per un altro tipo
            ],
        ];

        return $validationRules[$validationType] ?? [];
    }

}