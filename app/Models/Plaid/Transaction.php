<?php

namespace App\Models\Plaid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'application_id',
        'account_name',
        'amount',
        'merchant_name',
        'merchant_name_alias',
        'category',
        'date',
    ];
}
