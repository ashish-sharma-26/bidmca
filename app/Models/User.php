<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 *
 * @package namespace App\Models\Auth;
 */
class User extends Authenticatable implements Transformable
{
    use TransformableTrait, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'user_type',
        'is_active',
        'facebook_id',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value){
        $date = new Carbon($value);
        return $date->format('Y-m-d h:i');
    }

    public function getUserTypeAttribute($value)
    {
        if($value === 1){
            return 'Broker';
        }
        if($value === 2){
            return 'Lender';
        }
        if($value === 3){
            return 'Borrower';
        }
    }

    public function getIsActiveAttribute($value)
    {
        if($value == 1){
            return 'Active';
        }
        if($value == 0){
            return 'Inactive';
        }
    }
}
