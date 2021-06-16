<?php

namespace App\Models\Plaid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liability extends Model
{
    protected $fillable = [
        'application_id',
        'type',
        'account_name',
        'overdue',
        'last_payment',
        'last_payment_date',
        'last_statement',
        'last_statement_date',
        'principal_amount',
        'originate_date',
        'maturity_date',
        'ir',
        'guarantor',
    ];
}
