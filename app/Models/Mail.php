<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $table = 'mails'; // Nome della tabella nel database

    protected $fillable = [
        'mailName',
        'mailHost',
        'mailUsername',
        'mailPassword',
        'mailSmtpSecure',
        'mailPort',
    ];

    // Aggiungi eventuali altri metodi o proprietà necessarie
}