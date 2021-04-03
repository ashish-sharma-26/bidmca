<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $table = 'bids';

    protected $fillable = [
        'application_id',
        'user_id',
        'interest_rate',
        'duration',
        'amount'
    ];
    public function getAmountAttribute($value)
    {
        return number_format($value);
    }
}
