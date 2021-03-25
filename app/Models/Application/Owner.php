<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'owner',
        'ownership_percent',
        'title',
        'last_name',
        'first_name',
        'dob',
        'ssn',
        'email',
        'phone',
    ];
}
