<?php

namespace App\Models\Plaid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'application_id',
        'account_name',
        'account_name_alias',
        'account_type',
        'account_subtype',
        'account_available_balance',
        'account_current_balance',
        'account_limit',
    ];
}
