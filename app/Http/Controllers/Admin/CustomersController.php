<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mail;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    private $validations = [
        'mailName'          => "required|string|max:100",
        'mailHost'          => "required|string|max:100",
        'mailUsername'      => "required|string|max:100",
        'mailPassword'      => "required|string|max:100",
        'mailSmtpSecure'    => "required|string|max:100",
        'mailPort'          => "required|string|max:100",
    ];

    private $validations_messages = [
        'required'  => 'il campo :attribute è obbligatorio',
        'min'       => 'il campo :attribute deve avere minimo :min caratteri',
        'max'       => 'il campo :attribute non può superare i :max caratteri',
        'url'       => 'il campo deve essere un url valido',
        'exists'    => 'Valore non valido'
    ];
    
    public function index()
    {
        $mails = Mail::all();

        return view('admin.mails.index', compact('mails'));
    }

    public function create()
    {
        return view('admin.mails.create');
    }

    public function store(Request $request)
    {   
      
        //validare i dati
        $request->validate($this->validations, $this->validations_messages);

        $data = $request->all();

        $newMail = new Mail();

        $newMail->mailName          = $data['mailName'];
        $newMail->mailHost          = $data['mailHost'];
        $newMail->mailUsername      = $data['mailUsername'];
        $newMail->mailPassword      = $data['mailPassword'];
        $newMail->mailSmtpSecure    = $data['mailSmtpSecure'];
        $newMail->mailPort          = $data['mailPort'];

        $newMail->save();

        return redirect()->route('admin.mails.index', ['mail' => $newMail]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Mail $mail)
    {
        return view('admin.mails.edit', compact('mail'));
    }

    public function update(Request $request, Mail $mail)
    {
        //validare i dati
        $request->validate($this->validations, $this->validations_messages);

        $data = $request->all();

        $mail->mailName             = $data['mailName'];
        $mail->mailHost             = $data['mailHost'];
        $mail->mailUsername         = $data['mailUsername'];
        $mail->mailPassword         = $data['mailPassword'];
        $mail->mailSmtpSecure       = $data['mailSmtpSecure'];
        $mail->mailPort             = $data['mailPort'];

        $mail->update();

        return redirect()->route('admin.mails.index', ['mail' => $mail->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
