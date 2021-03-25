<?php

namespace App\Models\Application;

use App\Models\Common\City;
use App\Models\Common\State;
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

    public function city(){
        return $this->hasOne(City::class,'id', 'billing_city_id');
    }

    public function state(){
        return $this->hasOne(State::class,'id', 'billing_state_id');
    }
}
