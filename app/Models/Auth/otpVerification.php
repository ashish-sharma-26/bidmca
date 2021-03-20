<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
      'phone',
      'otp'
    ];
}
