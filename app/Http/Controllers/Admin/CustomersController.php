<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mail;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    private $validations = [
        'mailName'          => "required|string|max:30|unique:mails",
        'mailHost'          => "required|string|max:30",
        'mailUsername'      => "required|email|unique:mails",
        'mailPassword'      => "required|string|min:8|max:30",
        'mailSmtpSecure'    => "required|string|size:3",
        'mailPort'          => 'required|numeric|digits_between:3,3',
    ];

    private $validations_messages = [
        'required'              => 'il campo :attribute è obbligatorio',
        'min'                   => 'il campo :attribute deve avere minimo :min caratteri',
        'max'                   => 'il campo :attribute non può superare i :max caratteri',
        'url'                   => 'il campo deve essere un url valido',
        'exists'                => 'Valore non valido',
        'size'                  => 'Il campo :attribute deve essere esattamente di :size caratteri',
        'digits_between'        => 'Il campo :attribute deve essere esattamente di :min cifre',
        'email'                 => 'Il campo deve contenere una mail',
        'unique'                => ':attribute già presente nel db'
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
    $request->validate([
        'mailName'         => "required|string|max:30|unique:mails,mailName,{$mail->id}",
        'mailHost'         => "required|string|max:30",
        'mailUsername'     => "required|email|unique:mails,mailUsername,{$mail->id}",
        'mailPassword'     => "required|string|min:8|max:30",
        'mailSmtpSecure'   => "required|string|size:3",
        'mailPort'         => 'required|numeric|digits_between:3,3',
    ]);

    $data = $request->all();

    $mail->mailName             = $data['mailName'];
    $mail->mailHost             = $data['mailHost'];
    $mail->mailUsername         = $data['mailUsername'];
    $mail->mailPassword         = $data['mailPassword'];
    $mail->mailSmtpSecure       = $data['mailSmtpSecure'];
    $mail->mailPort             = $data['mailPort'];

    $mail->save();

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
