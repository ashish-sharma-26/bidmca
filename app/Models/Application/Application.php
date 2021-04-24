<?php

namespace App\Models\Application;

use App\Models\Common\City;
use App\Models\Common\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'user_id',
        'business_name',
        'loan_amount',
        'state_incorporation_id',
        'is_business_operating',
        'fed_tax_id',
        'industry_type',
        'due_status',
        'due_amount',
        'lender_names',
        'due_contract',
        'contract_file',
        'billing_street_address',
        'billing_city_id',
        'billing_state_id',
        'billing_zipcode',
        'billing_phone',
        'mode',
        'amount_per_year',
        'billing_street_address2',
        'billing_city_id2',
        'billing_state_id2',
        'billing_zipcode2',
        'billing_phone2',
        'signature_file',
        'account_email',
    ];

    public function state(){
        return $this->hasOne(State::class,'id', 'billing_state_id');
    }

    public function stateOfIncorporation(){
        return $this->hasOne(State::class,'id', 'state_incorporation_id');
    }

    public function owner(){
        return $this->hasMany(Owner::class, 'application_id','id');
    }

    public function bid(){
        return $this->hasOne(Bid::class, 'application_id','id');
    }

    public function bids(){
        return $this->hasMany(Bid::class, 'application_id','id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function bankAccount(){
        return $this->hasMany(BankAccount::class, 'application_id','id');
    }

    public function getLoanAmountAttribute($value)
    {
        return number_format($value);
    }

    public function getStatusAttribute($value){
        if($value == 1){
            return '<label class="badge badge-primary">Drafted</label>';
        }
        if($value == 2){
            return '<label class="badge badge-warning">Pending for Approval</label>';
        }
        if($value == 3){
            return '<label class="badge badge-success">Approved</label>';
        }
        if($value == 4){
            return '<label class="badge badge-danger">Rejected</label>';
        }
    }
}
