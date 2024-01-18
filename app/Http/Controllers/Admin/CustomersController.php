<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\SecurityPassword;

class CustomersController extends Controller
{
    private $securityPassword;
    
    public function __construct(SecurityPassword $securityPassword)
    {
        $this->securityPassword = $securityPassword;
    }

    private $validations = [
        'mailName'          => "required|string|regex:/^[^\s]+$/|max:30|unique:mails",
        'mailHost'          => "required|string|regex:/\./|max:30",
        'mailUsername'      => "required|email|unique:mails",
        'mailPassword'      => "required|string|min:8|max:30",
        'mailSmtpSecure'    => "required|string|regex:/^[a-zA-Z]+$/|size:3",
        'mailPort'          => "required|numeric|digits_between:3,3",
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
        'unique'                => ':attribute già presente nel db',
        
        'mailName.regex'        => 'Il campo :attribute non può contenere spazi.',
        'mailHost.regex'        => 'Il campo :attribute deve contenere almeno un punto.',
        'mailSmtpSecure.regex'  => 'Il campo :attribute deve contenere solo lettere.',
       
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

        $data['mailPassword'] = $this->securityPassword->encryptData($data['mailPassword'], $_ENV['SECRET_KEY']);

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
            'mailName'         => "required|string|max:30|regex:/^[^\s]+$/|unique:mails,mailName,{$mail->id}",
            'mailHost'         => "required|string|regex:/\./|max:30",
            'mailUsername'     => "required|email|unique:mails,mailUsername,{$mail->id}",
            'mailPassword'     => "nullable|string|min:8|max:30",
            'mailSmtpSecure'   => "required|string|regex:/^[a-zA-Z]+$/|size:3",
            'mailPort'         => 'required|numeric|digits_between:3,3',
        ], $this->validations_messages);

        $data = $request->all();

        // Se il campo mailPassword è vuoto, mantieni la password precedente
        if (empty($data['mailPassword'])) {
            $data['mailPassword'] = $mail->mailPassword;
        } else {
            // Altrimenti, hash della nuova password
            $data['mailPassword'] = $this->securityPassword->encryptData($data['mailPassword'], $_ENV['SECRET_KEY']);
        }

        $mail->mailName             = $data['mailName'];
        $mail->mailHost             = $data['mailHost'];
        $mail->mailUsername         = $data['mailUsername'];
        $mail->mailPassword         = $data['mailPassword'];
        $mail->mailSmtpSecure       = $data['mailSmtpSecure'];
        $mail->mailPort             = $data['mailPort'];

        $mail->save();

        return redirect()->route('admin.mails.index', ['mail' => $mail->id]);
    }

    public function destroy(Mail $mail)
    {
        $mail->delete();

        return to_route('admin.mails.index')->with('delete_success', $mail);
    }
}
